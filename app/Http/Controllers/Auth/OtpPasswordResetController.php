<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordOtpMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OtpPasswordResetController extends Controller
{
    
    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    
    public function sendOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withInput()->withErrors(['email' => 'Email tidak terdaftar dalam sistem kami.']);
        }

        
        $otpCode = (string) rand(100000, 999999);

        
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $otpCode,
                'created_at' => now(),
            ]
        );

        
        try {
            Mail::to($request->email)->send(new ResetPasswordOtpMail($otpCode));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['email' => 'Gagal mengirim email: ' . $e->getMessage()]);
        }

        
        session([
            'reset_email' => $request->email,
            'otp_resend_cooldown' => now()->addSeconds(60)->timestamp
        ]);

        return redirect()->route('password.verify')->with('status', 'Kode verifikasi OTP telah dikirim ke email Anda.');
    }

    
    public function showVerifyCode(): View|RedirectResponse
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi habis, silakan masukkan email kembali.']);
        }

        $email = session('reset_email');
        $cooldown = session('otp_resend_cooldown', 0);
        $secondsRemaining = max(0, $cooldown - now()->timestamp);

        return view('auth.verify-code', compact('email', 'secondsRemaining'));
    }

    
    public function verifyOtp(Request $request): RedirectResponse
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi habis, silakan masukkan email kembali.']);
        }

        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ], [
            'code.required' => 'Kode verifikasi wajib diisi.',
            'code.size' => 'Kode verifikasi harus berukuran 6 digit.',
        ]);

        $email = session('reset_email');

        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record || $record->token !== $request->code) {
            return back()->withErrors(['code' => 'Kode verifikasi salah.']);
        }

        
        $createdAt = Carbon::parse($record->created_at);
        if ($createdAt->addMinutes(15)->isBefore(now())) {
            return back()->withErrors(['code' => 'Kode verifikasi telah kedaluwarsa. Silakan minta kode baru.']);
        }

        
        session(['reset_verified' => true]);

        return redirect()->route('password.reset', ['token' => $record->token]);
    }

    
    public function resendOtp(Request $request): RedirectResponse
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi habis, silakan masukkan email kembali.']);
        }

        $email = session('reset_email');
        $cooldown = session('otp_resend_cooldown', 0);

        if (now()->timestamp < $cooldown) {
            $remaining = $cooldown - now()->timestamp;
            return back()->withErrors(['code' => "Harap tunggu {$remaining} detik sebelum meminta kode baru."]);
        }

        $otpCode = (string) rand(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $otpCode,
                'created_at' => now(),
            ]
        );

        try {
            Mail::to($email)->send(new ResetPasswordOtpMail($otpCode));
        } catch (\Exception $e) {
            return back()->withErrors(['code' => 'Gagal mengirim kode ulang: ' . $e->getMessage()]);
        }

        session(['otp_resend_cooldown' => now()->addSeconds(60)->timestamp]);

        return back()->with('status', 'Kode verifikasi baru telah dikirim ke email Anda.');
    }

    
    public function showResetPassword(Request $request): View|RedirectResponse
    {
        if (!session()->has('reset_email') || !session()->get('reset_verified')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Akses ditolak. Silakan lakukan verifikasi terlebih dahulu.']);
        }

        $email = session('reset_email');
        $token = DB::table('password_reset_tokens')->where('email', $email)->value('token') ?? '';

        return view('auth.reset-password', compact('email', 'token'));
    }

    
    public function resetPassword(Request $request): RedirectResponse
    {
        if (!session()->has('reset_email') || !session()->get('reset_verified')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Akses ditolak. Silakan lakukan verifikasi terlebih dahulu.']);
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $email = session('reset_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request')->withErrors(['email' => 'User tidak ditemukan.']);
        }

        
        $user->password = Hash::make($request->password);
        $user->save();

        
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        
        session()->forget(['reset_email', 'otp_resend_cooldown', 'reset_verified']);

        return redirect()->route('login')->with('success', 'Password Anda berhasil disetel ulang. Silakan login kembali.');
    }
}
