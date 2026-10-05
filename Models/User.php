<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Wishlist;
use App\Models\UserActivity;

class User extends Authentication
{
   use HasFactory, Notifiable;
   protected $fillable = [
    'name',
    'email',
    'password',
    'role'
   ];
   protected $hidden = [
    'password',
    'remember_token',
   ];

   public function wishlists()
   {
    return $this->hasMany(Wishlist::class);
   }

   public function activities()
   {
    return $this->hasMany(UserActivity::class);
   }
}