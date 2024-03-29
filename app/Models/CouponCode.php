<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponCode extends Model
{
    use HasFactory;
    protected $fillable=['code','name','max_uses','max_uses_user','type','discount_amount','min_amount','status','start_at','expire_at','description'];
    protected $table='discount_coupons';
}
