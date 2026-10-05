<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\UserActivity;

class CartController extends Controller
{
    // Add product to cart
    public function add(Request $request, $id)
    {
        // Validate quantity
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Find product
        $product = Product::findOrFail($id);

        // Check stock
        if ($product->stock < $request->quantity) {
            return back()->with(
                'error',
                'Not enough stock available.'
            );
        }

        // Check whether product already exists in cart
        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {

            // Existing quantity + new quantity
            $newQuantity = $cart->quantity + $request->quantity;

            // Check stock again
            if ($newQuantity > $product->stock) {
                return back()->with(
                    'error',
                    'Requested quantity exceeds available stock.'
                );
            }

            $cart->update([
                'quantity' => $newQuantity
            ]);

        } else {

            // Create new cart item
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        // Track add to cart activity
        UserActivity::create([
        'user_id' => auth()->id(),
        'product_id' => $product->id,
        'activity_type' => 'cart',
        ]);

        return redirect('/cart')
            ->with('success', 'Product added to cart successfully!');
    }

    // Show cart
        public function index()
    {
        $cartItems = Cart::with('product')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

        $total = $cartItems->sum(function ($item) {

        return $item->product->price * $item->quantity;

        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    // Update cart quantity
public function update(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    // Find cart item
    $cart = Cart::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    // Get product
    $product = Product::findOrFail($cart->product_id);

    // Check stock
    if ($request->quantity > $product->stock) {
        return back()->with(
            'error',
            'Only ' . $product->stock . ' items are available.'
        );
    }

    // Update quantity
    $cart->update([
        'quantity' => $request->quantity
    ]);

    return back()->with(
        'success',
        'Cart quantity updated successfully!'
    );
}

    // Remove product from cart
public function remove($id)
{
    $cart = Cart::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $cart->delete();

    return back()->with(
        'success',
        'Product removed from cart successfully!'
    );
}

    // Clear entire cart
public function clear()
{
    Cart::where('user_id', auth()->id())->delete();

    return back()->with(
        'success',
        'Cart cleared successfully!'
    );
}
}