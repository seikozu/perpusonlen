<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\OtpMail;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    protected function authenticated(Request $request, $user)
    {
        // Generate OTP 6 karakter
        $otp = strtoupper(Str::random(6));

        // Simpan ke database
        $user->update([
            'otp' => $otp
        ]);

        // Kirim email OTP
        Mail::to($user->email)->send(new OtpMail($otp));

        // Logout dulu (belum benar-benar login)
        Auth::logout();

        // Simpan id user sementara di session
        session(['user_id_otp' => $user->id]);

        // Redirect ke halaman OTP
        return redirect('/otp');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
