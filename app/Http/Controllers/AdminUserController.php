<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\User::query();
        
        if ($request->filled('q')) {
            $search = $request->query('q');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('role')) {
            $query->where('role', $request->query('role'));
        }
        
        $totalUsers = \App\Models\User::count();
        $totalAdmins = \App\Models\User::where('role', 'admin')->count();
        $users = $query->orderBy('created_at', 'desc')->paginate(8)->onEachSide(1)->withQueryString();
        
        return view('admin.users', compact('users', 'totalUsers', 'totalAdmins'));
    }

    public function updateRole(Request $request, \App\Models\User $user)
    {
        // Cycle roles: user -> admin -> user
        if ($user->role === 'user') {
            $user->role = 'admin';
        } else {
            // Ensure we don't demote the last admin
            if (\App\Models\User::where('role', 'admin')->count() <= 1) {
                return back()->withErrors(['error' => 'CANNOT_DEMOTE_LAST_ADMIN_ACCOUNT']);
            }
            $user->role = 'user';
        }
        $user->save();
        $user->notify(new \App\Notifications\RoleChangedNotification($user->role));
        
        return back()->with('success', 'USER_ROLE_UPDATED // LEVEL: ' . strtoupper($user->role));
    }

    public function edit(\App\Models\User $user)
    {
        return view('admin.users-edit', compact('user'));
    }

    public function update(Request $request, \App\Models\User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,user',
        ]);

        if ($user->role === 'admin' && $request->role !== 'admin') {
            if (\App\Models\User::where('role', 'admin')->count() <= 1) {
                return back()->withErrors(['error' => 'CANNOT_DEMOTE_LAST_ADMIN_ACCOUNT']);
            }
        }

        $oldRole = $user->role;
        $user->name = $request->name;
        $user->role = $request->role;
        $user->save();

        if ($oldRole !== $request->role) {
            $user->notify(new \App\Notifications\RoleChangedNotification($user->role));
        }

        return redirect()->route('admin.users.index')->with('success', 'USER_DATA_OVERRIDDEN // LEVEL: ' . strtoupper($user->role));
    }

    public function destroy(\App\Models\User $user)
    {
        if ($user->role === 'admin' && \App\Models\User::where('role', 'admin')->count() <= 1) {
            return back()->withErrors(['error' => 'CANNOT_DELETE_LAST_ADMIN_ACCOUNT']);
        }
        
        $user->delete();
        return back()->with('success', 'USER_RECORD_PURGED');
    }
}
