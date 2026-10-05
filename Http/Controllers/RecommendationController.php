<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserActivity;
use App\Models\Product;

class RecommendationController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Activity weights
        $weights = [
            'view' => 1,
            'cart' => 3,
            'wishlist' => 4,
            'purchase' => 5,
        ];

        // Get user's activities with product information
        $activities = UserActivity::with('product')
            ->where('user_id', $userId)
            ->get();

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

        // Sort categories by highest score
        arsort($categoryScores);

        // Get categories in order of user interest
        $categoryIds = array_keys($categoryScores);

        // Get products from interested categories
        $products = Product::whereIn('category_id', $categoryIds)
            ->where('stock', '>', 0)
            ->with('category')
            ->get();

        return view(
            'recommendations',
            compact('products')
        );
    }
}