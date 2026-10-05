<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;

class UserController extends Controller
{
    // Show all users
    public function index()
    {
        $users = User::latest()->get();

        return view(
            'admin.users.index',
            compact('users')
        );
    }

    // Show user details
    public function show($id)
    {
    $user = User::findOrFail($id);

    return view(
        'admin.users.show',
        compact('user')
    );
    }

    // Show edit user page
    public function edit($id)
    {
    $user = User::findOrFail($id);

    return view(
        'admin.users.edit',
        compact('user')
    );
    }

    // Update user
    public function update(Request $request, $id)
    {
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',

        'email' => 'required|email|unique:users,email,' . $user->id,

        'role' => 'required|in:user,admin',
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
    ]);

    return redirect('/admin/users')
        ->with('success', 'User updated successfully!');
    }

    // Delete user safely
    public function destroy($id)
    {
    $user = User::findOrFail($id);

    // Prevent deleting your own account
    if ($user->id === auth()->id()) {
        return back()->with(
            'error',
            'You cannot delete the account you are currently logged in with.'
        );
    }

    // Prevent deleting another admin
    if ($user->role === 'admin') {
        return back()->with(
            'error',
            'Another admin account cannot be deleted from here.'
        );
    }

    // Prevent deleting users who have order history
    if (Order::where('user_id', $user->id)->exists()) {
        return back()->with(
            'error',
            'This user cannot be deleted because they have order history.'
        );
    }

    // Delete user's cart items
    Cart::where('user_id', $user->id)->delete();

    // Delete user
    $user->delete();

    return redirect('/admin/users')
        ->with(
            'success',
            'User and related cart items deleted successfully!'
        );
    }
}