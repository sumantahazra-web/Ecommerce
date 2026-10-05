<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    // Show all categories
    public function index()
    {
        $categories = Category::latest()->get();

        return view('admin.categories.index', compact('categories'));
    }

    // Show add category page
    public function create()
    {
    return view('admin.categories.create');
    }

    // Store category
    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
    ]);

    Category::create([
        'name' => $request->name,
    ]);

    return redirect('/admin/categories')
        ->with('success', 'Category added successfully!');
    }

    // Show edit category page
    public function edit($id)
    {
    $category = Category::findOrFail($id);

    return view(
        'admin.categories.edit',
        compact('category')
    );
    }

    // Update category
    public function update(Request $request, $id)
    {
    $category = Category::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
    ]);

    $category->update([
        'name' => $request->name,
    ]);

    return redirect('/admin/categories')
        ->with('success', 'Category updated successfully!');
    }

    // Delete category
    public function destroy($id)
    {
    // Find category
    $category = Category::findOrFail($id);

    // Check whether products are using this category
    $productCount = Product::where(
        'category_id',
        $category->id
    )->count();

    // If products exist, don't delete category
    if ($productCount > 0) {

        return back()->with(
            'error',
            'This category cannot be deleted because it is being used by ' .
            $productCount .
            ' product(s).'
        );
    }

    // Delete category
    $category->delete();

    return redirect('/admin/categories')
        ->with(
            'success',
            'Category deleted successfully!'
        );
    }
}