<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CouponCode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class DiscountCodeController extends Controller
{
    public function index()
    {

    }
    public function create()
    {
        return view('admin.coupon.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:discount_coupons,code',
            'name' => 'required|string',
            'max_uses' => 'nullable|integer',
            'max_uses_user' => 'nullable|integer',
            'discount_amount' => 'required|numeric|min:0',
            'min_amount' => 'nullable|numeric|min:0',
            'status' => 'required',
            'start_at' => ['nullable', 'date', function ($attribute, $value, $fail) use ($request) {
                if ($value) {
                    $now = now();
                    $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $value);
                    if ($startAt->lessThan($now)) {
                        $fail('Starting date must be greater than current date');
                    }
                }
            }],
            'expire_at' => 'nullable|date|after:start_at',
            'description' => 'nullable|string',
        ]);

        $discount = new CouponCode();
        $discount->fill($request->all());
        $discount->save();
        return redirect()->route('coupons.create')->with('success', 'Discount code created successfully');
    }

    public function edit($id)
    {

    }
    public function update(Request $request, $id)
    {

    }
    public function destroy($id)
    {

    }
}
