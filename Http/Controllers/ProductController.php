<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\UserActivity;

class ProductController extends Controller
{
    // Show all products in admin panel
    public function index()
    {
        $products = Product::with('category')->latest()->get();

        return view('admin.products.index', compact('products'));
    }

    // Show add product form
    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    // Store product
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {

            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(
                public_path('products'),
                $imageName
            );
        }

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imageName,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product added successfully.');
    }

    public function show($id)
    {
    $product = Product::with('category')->findOrFail($id);

    // Track product view
    UserActivity::create([
        'user_id' => auth()->id(),
        'product_id' => $product->id,
        'activity_type' => 'view',
    ]);

    // Check if product is wishlisted
    $isWishlisted = Wishlist::where('user_id', auth()->id())
        ->where('product_id', $product->id)
        ->exists();

    // Get user's activities
    $activities = UserActivity::with('product')
        ->where('user_id', auth()->id())
        ->get();

    // Activity weights
    $weights = [
        'view' => 1,
        'cart' => 3,
        'wishlist' => 4,
        'purchase' => 5,
    ];

    // Calculate category scores
    $categoryScores = [];

    foreach ($activities as $activity) {

        if (!$activity->product) {
            continue;
        }

        $categoryId = $activity->product->category_id;

        $weight = $weights[$activity->activity_type] ?? 0;

        if (!isset($categoryScores[$categoryId])) {
            $categoryScores[$categoryId] = 0;
        }

        $categoryScores[$categoryId] += $weight;
    }

    // Highest-interest category first
    arsort($categoryScores);

    $categoryIds = array_keys($categoryScores);

    // Get products already purchased by the user
    $purchasedProductIds = UserActivity::where('user_id', auth()->id())
    ->where('activity_type', 'purchase')
    ->pluck('product_id')
    ->toArray();

    // Get recommended products
    $recommendations = Product::whereIn('category_id', $categoryIds)
    ->where('id', '!=', $product->id)
    ->whereNotIn('id', $purchasedProductIds)
    ->where('stock', '>', 0)
    ->with('category')
    ->limit(4)
    ->get();

    return view(
        'products.show',
        compact(
            'product',
            'isWishlisted',
            'recommendations'
        )
    );
    }


    // Show edit product form
    public function edit($id)
    {
    $product = Product::findOrFail($id);

    $categories = Category::all();

    return view(
        'admin.products.edit',
        compact('product', 'categories')
    );
    }

   // Update product
    public function update(Request $request, $id)
   {
    $product = Product::findOrFail($id);

    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $imageName = $product->image;

    // If new image is uploaded
    if ($request->hasFile('image')) {

        $imageName = time() . '.' . $request->image->extension();

        $request->image->storeAs(
            'products',
            $imageName,
            'public'
        );
    }

    $product->update([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'stock' => $request->stock,
        'image' => $imageName,
    ]);

    return redirect('/admin/products')
        ->with('success', 'Product updated successfully!');
    }

    // Delete product
    public function destroy($id)
{
    // Find product
    $product = Product::findOrFail($id);

    // Delete this product from all users' carts
    Cart::where('product_id', $product->id)->delete();

    // Delete product image
    if ($product->image) {

        $imagePath = storage_path(
            'app/public/products/' . $product->image
        );

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Delete product
    $product->delete();

    return redirect('/admin/products')
        ->with(
            'success',
            'Product and related cart items deleted successfully!'
        );
}
}