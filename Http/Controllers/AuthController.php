<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show registration page
    public function register()
    {
        return view('register');
    }

    // Register user
    public function registerSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

        return redirect('/login')
            ->with('success', 'Registration successful');
    }

    // Show login page
    public function login()
    {
        return view('login');
    }

    // Login user
    public function loginSubmit(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credential)) {

            $request->session()->regenerate();

            // Redirect according to role
            if (Auth::user()->role == 'admin') {
                return redirect('/admin/dashboard');
            }

            return redirect('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password'
        ]);
    }

    // User Dashboard
  
    public function userDashboard(Request $request)
    {
    $query = Product::with('category')->latest();

    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            // Search by product name
            $q->where('name', 'like', '%' . $search . '%')

              // Search by category name
              ->orWhereHas('category', function ($categoryQuery) use ($search) {

                  $categoryQuery->where(
                      'name',
                      'like',
                      '%' . $search . '%'
                  );

              });

        });
    }

    // Filter by category
    if ($request->filled('category')) {

        $query->where(
            'category_id',
            $request->category
        );
    }

    // Filter by minimum price
    if ($request->filled('min_price')) {

        $query->where(
            'price',
            '>=',
            $request->min_price
        );
    }

    // Filter by maximum price
    if ($request->filled('max_price')) {

        $query->where(
            'price',
            '<=',
            $request->max_price
        );
    }

    $products = $query->get();

    $categories = Category::orderBy('name')->get();

    return view(
        'user_dashboard',
        compact('products', 'categories')
    );
    }


    // Admin Dashboard
    public function adminDashboard()
    {
        return view('admin_dashboard');
    }

    // Admin Panel
    public function admin()
    {
        return view('admin');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}