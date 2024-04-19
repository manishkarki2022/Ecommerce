<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    use HasFactory;
    protected $table = 'highlights';
    protected $fillable = ['name','category_id', 'slug', 'description', 'image', 'is_active'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}


