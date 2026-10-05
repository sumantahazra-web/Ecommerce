<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\UserActivity;

class AIController extends Controller
{
    public function askAI(Request $request)
    {
        $request->validate([
        'question' => 'required|string|max:1000',
        ]);

        $question = $request->input('question');

        $products = Product::with('category')
        ->where('stock', '>', 0)
        ->get();

        $productData = $products->map(function ($product) {
        return [
        'name' => $product->name,
        'category' => $product->category->name ?? 'Unknown',
        'price' => $product->price,
        'description' => $product->description,
        'stock' => $product->stock,
        ];
        })->toArray();

        $activities = UserActivity::with('product')
        ->where('user_id', auth()->id())
        ->get();

        $activityData = $activities->map(function ($activity) {
        return [
        'activity' => $activity->activity_type,
        'product' => $activity->product->name ?? 'Unknown',
        'category' => $activity->product->category->name ?? 'Unknown',
        ];
        })->toArray();

        $purchasedProducts = $activities
        ->where('activity_type', 'purchase')
        ->map(function ($activity) {
        return $activity->product->name ?? 'Unknown';
        })
        ->unique()
        ->values()
        ->toArray();

        $response = Http::withToken(config('services.openai.api_key'))
            ->post('https://api.openai.com/v1/responses', [
                'model' => 'gpt-4.1-mini',
                'input' => "You are the AI assistant for MyShop, an e-commerce website.

                Here are the currently available products:

                " . json_encode($productData) . "

                Here is the current user's activity history:

                " . json_encode($activityData) . "

                Here are the products the user has already purchased:

                " . json_encode($purchasedProducts) . "

                Use the user's activity history to understand their interests and preferences.

                When appropriate, recommend specific products from the available MyShop products.
                Only recommend products that actually exist in the available products list.
                Do not invent product names.
                Consider the user's previous views, cart items, wishlist items, and purchases when making recommendations.
                Do not recommend products that the user has already purchased.
                Prioritize products that match the user's interests but have not been purchased yet.

                User question:
                " . $question,
                ]);

        if ($response->failed()) {
            return response()->json([
            'error' => 'Sorry, the AI service is currently unavailable. Please try again later.',
            ], 500);
            }

        return response()->json([
            'answer' => $response->json('output.0.content.0.text'),
        ]);
    }
}