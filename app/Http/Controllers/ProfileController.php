<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    public function getProfile(Request $request) {
        
        $profile = Auth::user();
        if (!$profile) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'profile tidak ditemukan 😠'
            ]);
        }
        if (!$profile->email_verified_at) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'email belum terverifikasi 😠'
            ]);        
        }

        return response()->json([
            'response_code' => '00',
            'response_message' => 'profile berhasil ditampilkan 😎',
            'data' => [
                'profile' => $profile
            ]
        ]);
    }

    public function updateProfile (Request $request) {

        $profile = Auth::user();
        if (!$profile->email_verified_at) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'email belum terverifikasi 😠'
            ]);        
        }
        if ($request->hasFile('photo')) {
            $name = strtolower(str_replace(' ', '', $profile->name));
            $extension = $request->file('photo')->extension();
            $photo = $request->file('photo')->storeAs('/photos/users/photo-profile', $name.".".$extension, 'public');
        }
        $profile->update([
            'name' => $request->name,
            'photo' => '/storage/' . $photo
        ]);

        return response()->json([
            'response_code' => '00',
            'response_message' => 'profile berhasil diupdate 😎',
            'data' => [
                'profile' => $profile
            ]
        ]);
    }
}
