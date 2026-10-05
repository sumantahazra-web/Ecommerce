<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserActivity;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = \App\Models\Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        // Don't allow checkout with an empty cart
        if ($cartItems->isEmpty()) {
            return redirect('/cart')
                ->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view(
            'checkout',
            compact('cartItems', 'total')
        );
    }

    public function placeOrder(Request $request)
    {
    // Validate delivery address
    $request->validate([
    'address' => 'required|string|min:10',

    'payment_method' => 'required|in:Cash on Delivery,Online Payment',
    ]);

    // Get current user's cart
    $cartItems = Cart::with('product')
        ->where('user_id', auth()->id())
        ->get();

    // Stop if cart is empty
    if ($cartItems->isEmpty()) {
        return redirect('/cart')
            ->with('error', 'Your cart is empty.');
    }

    // Check products and stock
    foreach ($cartItems as $item) {

        if (!$item->product) {
            return redirect('/cart')
                ->with(
                    'error',
                    'A product in your cart no longer exists.'
                );
        }

        if ($item->quantity > $item->product->stock) {
            return redirect('/cart')
                ->with(
                    'error',
                    $item->product->name .
                    ' has only ' .
                    $item->product->stock .
                    ' item(s) available.'
                );
        }
    }

    // Calculate total
    $total = $cartItems->sum(function ($item) {
        return $item->product->price * $item->quantity;
    });

    // Start database transaction
    DB::beginTransaction();

    try {

        // Create order
    $order = Order::create([
    'user_id' => auth()->id(),
    'total_amount' => $total,
    'address' => $request->address,
    'payment_method' => $request->payment_method,
    'status' => 'Pending',
    ]);

        // Create order items and reduce stock
        foreach ($cartItems as $item) {

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

            // Reduce stock
            $item->product->decrement(
                'stock',
                $item->quantity
            );

            // Track purchase activity
            UserActivity::create([
            'user_id' => auth()->id(),
            'product_id' => $item->product_id,
            'activity_type' => 'purchase',
            ]);
        }

        // Clear cart
        Cart::where('user_id', auth()->id())->delete();

        // Everything successful
        DB::commit();

        return redirect('/dashboard')
            ->with(
                'success',
                'Order placed successfully! Order #' . $order->id
            );

    } catch (\Exception $e) {

        // Undo database changes
        DB::rollBack();

        return back()->with(
            'error',
            'Something went wrong while placing your order. Please try again.'
        );
    }
    }

    public function myOrders()
    {
    $orders = Order::where('user_id', auth()->id())
        ->latest()
        ->get();

    return view(
        'orders.index',
        compact('orders')
    );
    }

    public function show($id)
    {
    $order = Order::with('items.product')
        ->where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    return view('orders.show', compact('order'));
    }


    public function cancel($id)
    {
    // Find only the logged-in user's order
    $order = Order::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    // Only Pending orders can be cancelled
    if ($order->status !== 'Pending') {
        return back()->with(
            'error',
            'This order cannot be cancelled because its status is ' .
            $order->status . '.'
        );
    }

    // Restore product stock
    foreach ($order->items as $item) {

        if ($item->product) {

            $item->product->increment(
                'stock',
                $item->quantity
            );
        }
    }

    // Change order status
    $order->update([
        'status' => 'Cancelled'
    ]);

    return redirect('/my-orders')
        ->with(
            'success',
            'Order #' . $order->id . ' cancelled successfully!'
        );
    }


    //Admin Order List
    public function index()
    {
    $orders = Order::with('user')
        ->latest()
        ->get();

    return view('admin.orders.index', compact('orders'));
    } 

    //Admin Order Details
    public function showAdmin($id)
    {
    $order = Order::with('user', 'items.product')
        ->findOrFail($id);

    return view('admin.orders.show', compact('order'));
    }

    //Admin Update Order Status
    public function updateStatus(Request $request, $id)
    {
    $request->validate([
        'status' => 'required|in:Pending,Processing,Shipped,Delivered,Cancelled',
    ]);

    $order = Order::with('items.product')->findOrFail($id);

    // If admin cancels the order
    if ($request->status === 'Cancelled') {

        // Only Pending orders can be cancelled
        if ($order->status !== 'Pending') {
            return back()->with(
                'error',
                'Only Pending orders can be cancelled.'
            );
        }

        // Restore product stock
        foreach ($order->items as $item) {

            if ($item->product) {
                $item->product->increment(
                    'stock',
                    $item->quantity
                );
            }
        }
    }

    // Update order status
    $order->update([
        'status' => $request->status,
    ]);

    return redirect('/admin/orders/' . $order->id)
        ->with(
            'success',
            'Order status updated successfully!'
        );
    }

}