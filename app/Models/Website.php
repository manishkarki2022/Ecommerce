<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory, Sluggable;
    protected $fillable = [
        'name',
        'slug',
        'quote',
        'description',
        'address',
        'phone',
        'email',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'youtube',
        'logo',
    ];
    protected $table = 'websites';
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name' // Generate slug based on the 'name' attribute
            ]
        ];
    }
}
