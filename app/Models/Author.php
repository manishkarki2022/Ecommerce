<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'status', 'created_by'];

    public function authorImage()
    {
        return $this->hasMany(AuthorImage::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
