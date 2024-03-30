<?php
use App\Models\Category;
use App\Models\ProductImage;

function getCategories()
{
    return Category::orderBy('name', 'asc')
        ->where('showHome','Yes')
        ->where('status',1)
        ->get();
}
function getProductImage($id){
    return ProductImage::where('product_id',$id)->first();
}
?>
