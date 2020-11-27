<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;
use App\User;   

class SocialiteController extends Controller
{
    public function redirectToProvider($provider) {
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return response()->json([
            'url' => $url
        ]);
    }

    public function handleProviderCallback($provider) {
        try {
            $social_user = Socialite::driver($provider)->stateless()->user();
            // dd($social_user);
            if(!$social_user) {
                return response()->json([
                    'response_code' => '01',
                    'response_message' => 'login failed'
                ], 401);
            }

            $user = User::where('email', $social_user->email)->first();
            if(!$user) {
                if($provider == 'google') {
                    $photo = $social_user->avatar;
                }
                $user = User::create([
                    'id' => \Str::uuid(),
                    'email' => $social_user->email,
                    'name' => $social_user->name,
                    // 'password' => bcrypt('password'),
                    'email_verified_at' => Carbon::now('Asia/Jakarta'),
                    'photo' => $photo
                ]);
            }

            return response()->json([
                'response_code' => '00',
                'response_message' => 'user berhasil login',
                'data' => [
                    'user' => $user,
                    'token' => \Auth::login($user)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'response_status' => '01',
                'response_message' => $e->getMessage()
            ]);
        }
    }
}
