<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Seat;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request){
        $orderItems = OrderItem::latest('order_items.created_at')->with('orders')->get();
        $data = [
            'orderItems' => $orderItems,
        ];
        //$orders = $orders->paginate(10);
        return view('admin.orders.list', $data);
    }

    public function detail($orderId){
        $order = Order::with('seat')->findOrFail($orderId);
        $products = Product::latest('id')->with('product_images');
        $orderItems = OrderItem::where('order_id',$orderId)->get();

        //dd($taxes);
        
        return view('admin.orders.detail',[
            'order' => $order,
            'orderItems' => $orderItems,
            'products' => $products,
        ]);
    }


    public function changeOrderStatus(Request $request, $id){
        $order = Order::find($id);
        $order->status = $request->status;
        $order->shipped_date = $request->shipped_date;
        $order->save();

        $message = 'Order status updated successfully';

        session()->flash('success',$message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }

    public function sendInvoiceEmail(Request $request, $orderId){
        orderEmail($orderId, $request->userType);

        $message = 'Order email sent successfully';

        session()->flash('success',$message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }
}
