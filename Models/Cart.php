<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Cart extends Model
{
    protected $table = 'cart';

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

    // Cart belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Cart belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}