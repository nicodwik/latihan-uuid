<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function random($count) {
        $blogs = Blog::select('*')->inRandomOrder()->limit($count)->get();
        return response()->json([
            'response_code' => '00',
            'response_message' => 'Blog berhasil ditampilkan',
            'data' => [
                'blogs' => $blogs
            ]
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png'
        ]);

        
        $data = $request->all();
        $data['id'] = Str::uuid();
        $data['updated_at'] = Carbon::now('Asia/Jakarta');
        $data['created_at'] = Carbon::now('Asia/Jakarta');
        $blog = Blog::create($data);

        if ($request->hasFile('image')) {
            $image = $data['image'];
            $extension = $image->extension();
            try {
                $image = $image->storeAs('/photo/blogs', $blog->id . "." . $extension, 'public');
                $blog->update([
                    'image' => "/storage/" . $image
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'response_code' => '01',
                    'response_message' => $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'response_code' => '00',
            'response_message' => 'success',
            'data' => [
                'blog' => $blog
            ]
        ]);
    }
}
