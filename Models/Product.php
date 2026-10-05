<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\UserActivity;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function wishlists()
    {
    return $this->hasMany(Wishlist::class);
    }

    public function activities()
    {
    return $this->hasMany(UserActivity::class);
    }
}