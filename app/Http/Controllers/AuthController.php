<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function register(Request $request): RedirectResponse
    {
        $role = $request->input('role');
        $institutionRoles = ['school', 'university', 'company'];

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:user,school,university,company'],
        ];

        if (in_array($role, $institutionRoles, true)) {
            $rules['org_contact'] = ['required', 'string', 'max:255'];
            $rules['org_phone'] = ['required', 'string', 'max:30'];
            $rules['org_address'] = ['required', 'string'];
            $rules['org_doc'] = ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'];
        }

        $data = $request->validate($rules);

        $orgDocPath = null;
        if (in_array($role, $institutionRoles, true) && $request->hasFile('org_doc')) {
            $orgDocPath = $request->file('org_doc')->store('org-docs', 'public');
        }

        $status = $role === 'user' ? 'active' : 'pending';

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
            'status' => $status,
            'org_contact' => $data['org_contact'] ?? null,
            'org_phone' => $data['org_phone'] ?? null,
            'org_address' => $data['org_address'] ?? null,
            'org_doc' => $orgDocPath,
        ]);

        if ($status === 'active') {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('status', 'Pendaftaran berhasil. Akun menunggu verifikasi super admin sebelum bisa login.');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }

        $user = Auth::user();

        if ($user->status === 'pending') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->withErrors(['email' => 'Akun masih menunggu verifikasi super admin.'])->withInput();
        }

        if ($user->status === 'rejected') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->withErrors(['email' => 'Pendaftaran ditolak. Hubungi admin untuk informasi.'])->withInput();
        }

        $request->session()->regenerate();
        return redirect()->intended($this->redirectFor($user));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    private function redirectFor(User $user): string
    {
        return match ($user->role) {
            'super_admin' => '/admin',
            'school', 'university', 'company' => '/',
            default => '/',
        };
    }
}
