<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\UserActivity;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'wishlist',
            compact('wishlists')
        );
    }

    public function add($productId)
    {
    // Check that the product exists
    $product = Product::findOrFail($productId);

    // Check if already in wishlist
    $exists = Wishlist::where('user_id', auth()->id())
        ->where('product_id', $product->id)
        ->exists();

    if ($exists) {
        return back()->with(
            'error',
            'This product is already in your wishlist.'
        );
    }

    // Add product to wishlist
    Wishlist::create([
        'user_id' => auth()->id(),
        'product_id' => $product->id,
    ]);

    // Track wishlist activity
    UserActivity::create([
    'user_id' => auth()->id(),
    'product_id' => $product->id,
    'activity_type' => 'wishlist',
    ]);

    return back()->with(
        'success',
        'Product added to wishlist!'
    );
    }
    

    // Remove product from wishlist
    public function remove($id)
    {
    $wishlist = Wishlist::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $wishlist->delete();

    return back()->with(
        'success',
        'Product removed from wishlist!'
    );
    }
}