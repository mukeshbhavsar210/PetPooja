<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){

        $orders_count = DB::table('orders')
                    ->select(DB::raw('count(*) as total_tables'))
                    ->get()[0]->total_tables;

        $users_count = DB::table('users')
                    ->select(DB::raw('count(*) as total_tables'))
                    ->get()[0]->total_tables;

        $total_sale = Order::all()->sum('total');

        $sales_count = DB::table('orders')
                    ->select(DB::raw('count(*) as total_tables'))
                    ->get()[0]->total_tables;

        $data['orders_count'] = $orders_count;
        $data['users_count'] = $users_count;
        $data['sales_count'] = $sales_count;
        $data['total_sale'] = $total_sale;

        return view('admin.dashboard', $data);

        //$admin = Auth::guard('admin')->user();
        //echo 'Welcome '.$admin->name.' <a href="'.route('admin.logout').'">Logout</a>';
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
