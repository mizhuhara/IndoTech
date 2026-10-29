<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    public function notice(Request $request): View|RedirectResponse
    {
        // Jika akun sudah active (disetujui admin), otomatis tandai terverifikasi dan masuk ke dashboard
        if (strtolower((string) $request->user()->status) === 'active') {
            if (! $request->user()->hasVerifiedEmail()) {
                $request->user()->markEmailAsVerified();
            }

            return redirect()->route('dashboard');
        }

        if ($request->user()->role === 'user') {
            if (! $request->user()->hasVerifiedEmail()) {
                $request->user()->markEmailAsVerified();
            }

            return redirect()->route('welcome');
        }

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $request->fulfill();

        return redirect()->route('dashboard')->with('status', 'Email berhasil diverifikasi.');
    }

    public function send(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Tautan verifikasi baru sudah dikirim ke email Anda.');
    }
}
