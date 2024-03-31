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
    public function changeOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->shipped_date = $request->shipped_date ?? null;
        $order->save();

        $message = 'Order status updated successfully';



        // Update the value to be returned in the JSON response
        $updatedStatus = '';

        switch ($request->status) {
            case 'pending':
                $updatedStatus = '<span class="badge bg-warning text-black"><i class="fas fa-hourglass-start mr-1"></i> Pending</span>';
                break;
            case 'shipped':
                $updatedStatus = '<span class="badge bg-info"><i class="fas fa-truck mr-1"></i> Shipped</span>';
                break;
            case 'delivered':
                $updatedStatus = '<span class="badge bg-success"><i class="fas fa-check-circle mr-1"></i> Delivered</span>';
                break;
            case 'canceled':
                $updatedStatus = '<span class="badge bg-danger"><i class="fas fa-times-circle mr-1"></i> Canceled</span>';
                break;
            default:
                $updatedStatus = '';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'updated_status' => $updatedStatus
        ]);
    }



}
