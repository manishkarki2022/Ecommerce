<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CouponCode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class DiscountCodeController extends Controller
{
    public function index()
    {
        $discounts = CouponCode::latest()->paginate(10);
        return view('admin.coupon.index', compact('discounts'));
    }
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Perform the search query
        $discounts = CouponCode::where(function ($query) use ($keyword) {
            $query->where('code', 'like', '%' . $keyword . '%')
                ->orWhere('name', 'like', '%' . $keyword . '%');
        })->paginate(10);

        // Pass the search results to your view
        return view('admin.coupon.index', ['discounts' => $discounts]);
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
        return redirect()->route('coupons.index')->with('success', 'Discount code created successfully');
    }

    public function edit($id)
    {
        $discount = CouponCode::findOrFail($id);
        return view('admin.coupon.edit', compact('discount'));

    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => ['required', 'string', Rule::unique('discount_coupons')->ignore($id)],
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
                        $fail('Starting date must be greater than the current date');
                    }
                }
            }],
            'expire_at' => 'nullable|date|after:start_at',
            'description' => 'nullable|string',
        ]);

        $discount = CouponCode::findOrFail($id);
        $discount->update($request->all());

        return redirect()->route('coupons.index')->with('success', 'Discount code updated successfully');
    }

    public function destroy($id)
    {
        $discount = CouponCode::findOrFail($id);
        $discount->delete();
        return redirect()->route('coupons.index')->with('success', 'Discount code deleted successfully');
    }
}
