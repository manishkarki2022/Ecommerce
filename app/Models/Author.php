<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Author extends Model
{
    use HasFactory, Sluggable;
    protected $fillable = ['name', 'description', 'status', 'created_by','slug'];
    protected $table ='authors';
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,
            ]
        ];
    }

    public function authorImage()
    {
        return $this->hasMany(AuthorImage::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
