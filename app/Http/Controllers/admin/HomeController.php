<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
       $totalOrders =  Order::where('status','!=','canceled')->count();
       $totalProducts = Product::count();
        $totalUsers =  User::where('role','!=',2)->where('status', 1)->count();
        $totalSells =  Order::where('status','!=','canceled')->sum('grand_total');

        //This month Revenue
        $thisMonthName = Carbon::now()->format('M');
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d ');
        $currentDate = Carbon::now()->format('Y-m-d ');
        $thisMonthRevenue = Order::where('status','!=','canceled')
                            ->whereDate('created_at','>=',$startOfMonth)
                            ->whereDate('created_at','<=',$currentDate)
                              ->sum('grand_total');

        //Last month Revenue
        $lastMonthStartDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d ');
        $lastMonthEndDare = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d ');
        $lastMonthName = Carbon::now()->subMonth()->format('M');
        $lastMonthRevenue = Order::where('status','!=','canceled')
                            ->whereDate('created_at','>=',$lastMonthStartDate)
                            ->whereDate('created_at','<=',$lastMonthEndDare)
                            ->sum('grand_total');

        //Last 30 Days Revenue
        $lastThirtyDayStartDay = Carbon::now()->subDays(30)->format('Y-m-d ');
        $lastThirtyDaysRevenue = Order::where('status','!=','canceled')
                                ->whereDate('created_at','>=',$lastThirtyDayStartDay)
                                ->whereDate('created_at','<=',$currentDate)
                                ->sum('grand_total');


        return view('admin.dashboard',compact('totalOrders','totalProducts','totalUsers','totalSells','thisMonthRevenue','lastMonthRevenue','lastThirtyDaysRevenue','lastMonthName','thisMonthName'));
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
