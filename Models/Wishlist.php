<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    // Wishlist belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Wishlist belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}