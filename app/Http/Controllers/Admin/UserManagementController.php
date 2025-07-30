<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request): View
    {
        $search = $request->get('search');
        $role = $request->get('role');
        $status = $request->get('status');

        $users = User::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                           ->orWhere('email', 'like', "%{$search}%");
            })
            ->when($role, function ($query, $role) {
                return $query->where('role', $role);
            })
            ->when($status !== null, function ($query) use ($status) {
                return $query->where('is_active', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalKasir = User::where('role', 'kasir')->count();
        $totalMembers = User::where('role', 'member')->count();
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();

        return view('admin.users.index', compact(
            'users', 
            'search', 
            'role', 
            'status',
            'totalUsers',
            'totalAdmins',
            'totalKasir',
            'totalMembers', 
            'activeUsers', 
            'inactiveUsers'
        ));
    }

    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,kasir,member'],
            'is_active' => ['boolean']
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active');

        User::create($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'in:admin,kasir,member'],
            'is_active' => ['boolean']
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['string', 'min:8', 'confirmed']
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User berhasil diperbarui!');
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()
                           ->with('error', 'Anda tidak dapat menonaktifkan akun sendiri!');
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
                        ->with('success', "User {$user->name} berhasil {$status}!");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()
                           ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
                        ->with('success', "User {$userName} berhasil dihapus!");
    }
}