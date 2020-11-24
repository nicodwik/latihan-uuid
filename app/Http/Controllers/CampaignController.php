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
            'address' => \Request('address'),
            'required' => \Request('required'),
            'collected' => \Request('collected'),
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

    public function index() {
        $campaigns = Campaign::paginate(3);
        return response()->json([
            'response_code' => '00',
            'response_message' => 'success',
            'data' => $campaigns
        ]);
    }

    public function detail($id) {
        $campaign = Campaign::find($id);
        return response()->json([
            'response_code' => '00',
            'response_message' => 'suucess',
            'data' => $campaign,
        ]);
    }

    public function search($keyword) {
        $data = Campaign::where('title', 'LIKE', "%".$keyword."%")->get();
        $count = $data->count();
        return response()->json([
            'response_code' => '00',
            'response_message' => 'data berhasil ditampilkan',
            'data' => $data ,
            'total' => $count
        ]);
    }
}
