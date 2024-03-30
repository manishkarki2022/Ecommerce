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
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
