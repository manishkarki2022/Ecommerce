<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorImage extends Model
{
    use HasFactory;
    protected $fillable = ['image', 'author_id'];
    protected $table = 'author_image';

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
