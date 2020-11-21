<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campaign;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CampaignController extends Controller
{
    public function random($count) {
        $campaigns = Campaign::select('*')->inRandomOrder()->limit($count)->get();

        return response()->json([
            'response_code' => '00',
            'response_message' => 'data campaign berhasil ditampilkan',
            'data' => [
                'campaigns' => $campaigns
            ]
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png'
        ]);

        $campaign = Campaign::create([
            'id' => Str::uuid(),
            'title' => \request('title'),
            'description' => \Request('description'),
            'created_at'=> Carbon::now('Asia/Jakarta'),
            'updated_at'=> Carbon::now('Asia/Jakarta'),
        ]);

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->extension();

            try {
                $image = $request->file('image')
                    ->storeAs('/photo/campaigns/thumbnail-image', 0 . "." . $extension, 'public');
                $campaign->update([
                    'image' => "/storage/" . $image
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'response_code' => '01',
                    'response_message' => $e->getMessage(),
                ]);
            }
        }

        return response()->json([
            'response_code' => '00',
            'response_message' => 'photo campaign berhasil ditambahkan',
            'data' => [
                'campaign' => $campaign
            ]
        ]);
    }
}
