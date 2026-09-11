<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Display a listing of system users with search & filter support.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Search filter (Name, Email, Role)
        if ($request->filled('q')) {
            $q = trim($request->query('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('role', 'like', "%{$q}%");
            });
        }

        // Status filter
        if ($request->filled('status') && strtolower($request->query('status')) !== 'all') {
            $status = strtolower($request->query('status'));
            $query->where('status', $status);
        }

        // Role filter
        if ($request->filled('role') && strtolower($request->query('role')) !== 'all') {
            $role = strtolower($request->query('role'));
            $query->where('role', 'like', "%{$role}%");
        }

        $query->orderByDesc('id');

        $users = $query->paginate(8)->withQueryString();

        $totalUsersCount = User::count();
        $activeUsersCount = User::whereIn('status', ['active', 'Active'])->count();
        $pendingUsersCount = User::whereIn('status', ['pending', 'Pending'])->count();

        return view('admin.users.index', [
            'users' => $users,
            'totalUsersCount' => $totalUsersCount,
            'activeUsersCount' => $activeUsersCount,
            'pendingUsersCount' => $pendingUsersCount,
            'activeRole' => $request->query('role', 'all'),
            'activeStatus' => $request->query('status', 'all'),
            'searchQuery' => $request->query('q', ''),
        ]);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'regex:/[A-Za-z]/', 'regex:/[0-9]/'],
            'role' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string', 'max:20'],
        ], [
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.min' => 'Password minimal harus 8 karakter.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => strtolower($validated['role']),
            'status' => strtolower($validated['status']),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "User \"{$user->name}\" berhasil ditambahkan.");
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8', 'regex:/[A-Za-z]/', 'regex:/[0-9]/'],
            'role' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string', 'max:20'],
        ], [
            'email.unique' => 'Email ini sudah digunakan oleh user lain.',
            'password.min' => 'Password minimal harus 8 karakter.',
        ]);

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => strtolower($validated['role']),
            'status' => strtolower($validated['status']),
        ];

        if (! empty($validated['password'])) {
            $payload['password'] = Hash::make($validated['password']);
        }

        $user->update($payload);

        return redirect()->route('admin.users.index')
            ->with('success', "Data user \"{$user->name}\" berhasil diperbarui.");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Prevent self deletion
        if (auth()->check() && auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Prevent deleting main super admin
        if ($user->email === User::ADMIN_EMAIL) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Akun Super Admin utama tidak dapat dihapus.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "User \"{$name}\" berhasil dihapus.");
    }
}
