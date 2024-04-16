<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function bookType()
    {
        return $this->belongsTo(BookType::class);
    }
    public function ebook()
    {
        return $this->hasOne(Ebook::class);
    }
    public function item()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Define the relationship with SubCategory if needed
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
    public function ratings()
    {
        return $this->hasMany(ProductRating::class)->where('status', 1);
    }
    public function author()
    {
        return $this->belongsTo(Author::class);
    }


}
