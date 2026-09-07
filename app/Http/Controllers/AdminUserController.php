<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Display a listing of users with search and filter capabilities.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Search by keyword (name or email)
        if ($request->filled('q')) {
            $q = trim($request->query('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        // Filter by Status
        if ($request->filled('status') && strtolower($request->query('status')) !== 'all') {
            $query->where('status', strtolower($request->query('status')));
        }

        // Filter by Role
        if ($request->filled('role') && strtolower($request->query('role')) !== 'all') {
            $query->where('role', strtolower($request->query('role')));
        }

        $totalUsersCount = User::count();
        $users = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'totalUsersCount' => $totalUsersCount,
            'activeRole' => $request->query('role', 'all'),
            'activeStatus' => $request->query('status', 'all'),
            'searchQuery' => $request->query('q', ''),
        ]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', 'in:super_admin,school_admin,university_rep,company_hr,user'],
            'status' => ['required', 'string', 'in:active,pending,inactive'],
            'org_contact' => ['nullable', 'string', 'max:255'],
            'org_phone' => ['nullable', 'string', 'max:50'],
            'org_address' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', "User \"{$user->name}\" berhasil ditambahkan.");
    }

    /**
     * Display the specified user profile details.
     */
    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'string', 'in:super_admin,school_admin,university_rep,company_hr,user'],
            'status' => ['required', 'string', 'in:active,pending,inactive'],
            'org_contact' => ['nullable', 'string', 'max:255'],
            'org_phone' => ['nullable', 'string', 'max:50'],
            'org_address' => ['nullable', 'string', 'max:500'],
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', "Data user \"{$user->name}\" berhasil diperbarui.");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if (Auth::id() === $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->email === User::ADMIN_EMAIL) {
            return redirect()->route('admin.users.index')
                ->with('error', 'User Super Admin utama tidak dapat dihapus.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "User \"{$userName}\" berhasil dihapus.");
    }
}
