<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->query('sort', 'created_at');
        $sortDirection = $request->query('dir', 'desc');

        // Fetch orders from the database with sorting applied
        $orders = Order::orderBy($sortField, $sortDirection)->paginate(10);

        // Pass data to the view
        return view('admin.order.index', [
            'orders' => $orders,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }
    public function search(Request $request)
    {
        $sortField = $request->query('sort', 'created_at');
        $sortDirection = $request->query('dir', 'desc');
        $keyword = $request->input('keyword');

        $orders = Order::orderBy($sortField, $sortDirection)
            ->where('id', 'like', '%' . $keyword . '%')
            ->orWhere('first_name', 'like', '%' . $keyword . '%')
            ->orWhere('last_name', 'like', '%' . $keyword . '%')
            ->orWhere('email', 'like', '%' . $keyword . '%')
            ->orWhere('mobile', 'like', '%' . $keyword . '%')
            ->paginate(10);

        // Pass the search results to your view
        return view('admin.order.index', [
            'orders' => $orders,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $orderItems = OrderItem::where('order_id', $id)->get();

        return view('admin.order.show',compact('order','orderItems'));
    }

}
