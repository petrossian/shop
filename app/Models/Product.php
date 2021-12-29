<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'title', 'body', 'file'];

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function images(){
        return $this->belongsToMany(Image::class);
    }

    public function wishlists(){
        return $this->hasMany(Wishlist::class);
    }

    public function charts(){
        return $this->hasMany(Chart::class);
    }

    public function coupons(){
        return $this->belongsToMany(Coupon::class);
    }
}
