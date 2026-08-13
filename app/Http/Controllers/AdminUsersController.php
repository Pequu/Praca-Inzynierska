<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name', 'asc')->get();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],

        'email' => [
            'required',
            'email',
            'max:255',
            'unique:users,email,' . $user->getKey(),
        ],

        'role_id' => $user->getKey() === Auth::id()
            ? ['nullable']
            : ['required', 'exists:roles,id'],
    ]);

    $user->name = $validated['name'];
    $user->email = $validated['email'];

    if ($user->getKey() !== Auth::id()) {
        $user->role_id = $validated['role_id'];
    }

    $user->save();

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'Dane użytkownika zostały zaktualizowane.');
}

    public function destroy(User $user)
    {
        if ($user->getKey() === Auth::id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Nie możesz usunąć własnego konta.');
        }

        User::destroy($user->getKey());

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Konto użytkownika zostało usunięte.');
    }
}
