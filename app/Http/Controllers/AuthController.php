<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\User;
use App\Role;
use App\OtpCode;
use Carbon\Carbon;
use Hash;

class AuthController extends Controller
{
    public function register(Request $request) {

        $request->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required']
            ]);

        $user = User::create([
            'id' => Str::uuid(),
            'name' => 'random name',
            'email' => \Request('email'),
            'password' => bcrypt(\Request('password')),
            // 'role_id' => Role::where('name', 'user')->first()->id,
            'created_at' => Carbon::now('Asia/Jakarta'),
            'updated_at' => Carbon::now('Asia/Jakarta')
        ]);
        $otpcode = OtpCode::create([
            'id' => Str::uuid(),
            'code' => mt_rand(100000, 999999),
            'expired_at' => Carbon::now('Asia/jakarta')->addMinutes(5),
            'user_id' => $user->id,
            'created_at' => Carbon::now('Asia/jakarta'),
            'updated_at' => Carbon::now('Asia/jakarta')
        ]);

        return response()->json([
            'response_code' => '00',
            'response_message' => "Registrasi berhasil, cek email anda untuk verifikasi 😎",
            'data' => [
                'user' => $user
            ]
        ], 200);
    }

    public function verification(Request $request) {
        $request->validate([
            'code' => ['required', 'integer', 'digits:6']
        ]);

        $code = OtpCode::where('code', $request->code)->first();
        if (!$code) {
            return response()->json([
                'response_code' => "01",
                'response_message' => "OTP tidak ditemukan 😠"
            ]);
        }

        if (Carbon::now('Asia/Jakarta') >= $code->expired_at) {
            return response()->json([
                'response_code' => "01",
                'response_message' => 'OTP telah kadaluarsa 😠'
            ]);
        }
        $email = $code->user->email;
        $user = User::where('email', $email)->update([
            'email_verified_at' => Carbon::now('Asia/Jakarta')
        ]);

        return response()->json([
            'response_code' => "00",
            'response_message' => 'email ' . $email . ' telah terverifikasi 😎'
        ]);
    }

    public function regenerateOtp(Request $request) {
        
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'response_code' => "01",
                'response_message' => 'email tidak ditemukan 😠'
            ]);
        }

        OtpCode::where('user_id', $user->id)->update([
            'code' => mt_rand(100000, 999999),
            'expired_at' => Carbon::now('Asia/Jakarta')->addMinutes(5),
            'updated_at' => Carbon::now('Asia/jakarta')
        ]);
        
        return response()->json([
            'response_code' => "00",
            'response_message' => 'kode OTP berhasil diperbarui 😎'
        ]);
        
    }

    public function updatePassword(Request $request) {
        
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'confirm_password' => ['required' ,'same:password']
        ]);

        $user = User::where('email', $request->email)->first();
        $checkDuplicate = Hash::check($request->password, $user->password, []);
        if ($checkDuplicate) {
            return response()->json([
                'response_code' => "01",
                'response_message' => 'password harus berbeda dari password awal 😠'
            ]);
        }

        $user->update([
            'password' => bcrypt($request->password),
            'updated_at' => Carbon::now('Asia/Jakarta')
        ]);
        return response()->json([
            'response_code' => "00",
            'response_message' => 'Password berhasil diperbarui 😎',
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function login(Request $request) {
        
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string']
        ]);
        $data = $request->all();
        $token = Auth::attempt($data);
        if(!$token) {
            return response()->json([
                'response_code' => "01",
                'response_message' => 'Email atau password salah 😠',
            ]);
        }
        $user = User::where('email', $data['email'])->first();
        if (!$user->email_verified_at) {
            return response()->json([
                'response_code' => "01",
                'response_message' => 'Email belum diverifikasi, mohon verifikasi dulu 😠',
            ]);
        }
        return response()->json([
            'response_code' => "00",
            'response_message' => 'Login berhasil 😎',
            'data' => [
                'token' => $token,
                'user' => $user
            ]
        ]);
    }
}
