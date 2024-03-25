<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function create(){
        $cities = City::get();
        $shippingCharges = Shipping::select('shipping_charges.*', 'cities.name')
            ->leftJoin('cities', 'cities.id','shipping_charges.city_id')
            ->get();
        return view('admin.shipping.create', compact('cities', 'shippingCharges'));
    }
    public function store(Request $request){
        $request->validate([
            'city'=>'required|unique:shipping_charges,city_id',
            'amount'=>'required|numeric',
        ]);
        if ($request->city == 'rest_of_city') {
            $cityId = 'rest_of_city';
        } else {
            $cityId = $request->city;
        }
        $shipping = new Shipping();
        $shipping->city_id = $cityId;
        $shipping->amount = $request->amount;
        $shipping->save();

        $type = 'success';
        $message = 'Shipping charge added successfully';
        session()->flash($type, $message);
        return redirect()->route('shipping.create');
    }
    public function edit($id){
        $shipping = Shipping::find($id);
        $cities = City::get();
        return view('admin.shipping.edit', compact('shipping', 'cities'));
    }
    public function update(Request $request, $id){
        $request->validate([
            'city'=>'required|unique:shipping_charges,city_id,'.$id.',id',
            'amount'=>'required|numeric',
        ]);
        if ($request->city == 'rest_of_city') {
            $cityId = 'rest_of_city';
        } else {
            $cityId = $request->city;
        }
        $shipping = Shipping::find($id);
        $shipping->city_id = $cityId;
        $shipping->amount = $request->amount;
        $shipping->save();

        $type = 'success';
        $message = 'Shipping charge updated successfully';
        session()->flash($type, $message);
        return redirect()->route('shipping.create');
    }
    public function destroy($id){
        Shipping::destroy($id);
        $type = 'success';
        $message = 'Shipping charge deleted successfully';
        session()->flash($type, $message);
        return redirect()->route('shipping.create');
    }
}
