<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
