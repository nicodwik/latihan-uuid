<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class TestController extends Controller
{
    public function checkAdmin() {
        return "<h1> Access Granted 😎 </h1>";
    }

    public function checkVerified() {
        if(\Auth::user()->email_verified_at != null) {
            return "<h1> You're verified 😎 </h1>";
        }
    return "<h1> You're not verified 😠 </h1>";
    }

    public function getUsers(Request $request) {
        $users = User::orderBy('created_at', 'desc')->get();
        return response()->json([
            'data' => $users
        ]);
    }

    public function removeUser(Request $request, $id) {
        $user = User::find($id);
        $user->delete();
        
        return response()->json([
            'response_code' => '00',
            'response_message' => 'user berhasil dihapus 😎'
        ]);
    }
}
