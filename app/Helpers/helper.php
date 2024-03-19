<?php
use App\Models\Category;

function getCategories()
{
    return Category::orderBy('name', 'asc')
        ->where('showHome','Yes')
        ->where('status',1)
        ->get();
}




?>
