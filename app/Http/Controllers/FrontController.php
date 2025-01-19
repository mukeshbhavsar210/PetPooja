<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Seating;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller {

    public function show() {
        $products = Product::orderBy('id','DESC')->get();
        $areas = Area::orderBy('id','DESC')->with('seating')->orderBy('id','DESC')->get();
        $seat_number = Seating::orderBy('id','DESC')->get();
        $data = [
            'products'=> $products,
            'areas'=> $areas,
            'seat_number'=> $seat_number,
        ];
        return view('front.home.index', $data);        
    }

    public function index(Request $request, $areaSlug = null,) {
        $areaSlug = ' ';

        $products = Product::orderBy('id','DESC')->get();
        $areas = Area::orderBy('id','DESC')->with('seating')->orderBy('id','DESC')->get();
        $seat_number = Seating::orderBy('id','DESC')->get();

        $products = Product::where('status',1);

        // if(!empty($areaSlug)) {
        //     $areas = Area::where('slug',$areaSlug)->first();
        //     $seat_number = $seat_number->where('area_id',$areas->id);
        //     $areaSlug = $areas->id;
        // }

        $products = $products->paginate(10);

        $data['products'] = $products;
        $data['areaSlug'] = $areaSlug;

        return view('front.shop.index',$data);
    }

    
    public function addToCart($id){
        $product = Product::with('product_images')->find($id);
        
        if (!$product) {
            abort(404);
        }

        $cart = session()->get('cart');

        if (!$cart) {
            $cart = [
                $id => [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,                    
                ]
            ];

            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }

        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,                        
        ];

        session()->put('cart', $cart);

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Product added to cart successfully!']);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    
    public function removeCartItem(Request $request) {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }

            session()->flash('success', 'Product removed successfully');
        }
    }

    public function clearCart(){
        session()->forget('cart');
        return redirect()->back();
    }



    public function dinening_store (Request $request){
        $validator = Validator::make($request->all(), [
                   
        ]);

        $session_id = mt_rand(1000000000, 9999999999);        
        Session::put('session_id',$session_id);

        $cart = Session::get('cart');

        if ($validator->passes()) {
            $dinein = new Order();
            $dinein->session_id = session('session_id'); 
            $dinein->order_type = $request->order_type;
            $dinein->notes = $request->notes;
            $dinein->ready_time = $request->ready_time;
            $dinein->table_number = $request->table_number;            
            $dinein->save();

            foreach ($cart as $data) {     
                $order = new OrderItem;
                $order->order_id = $dinein->id;
                $order->name = $data['name'];
                $order->price = $data['price'];
                $order->qty = $data['quantity'];
                $order->save();
            }

            Session::forget('cart');

            $request->session()->flash('success', 'Dinening Order placed successfully');

            return response()->json([
                'status' => true,
                'message' => 'Dinening Order added successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    public function takeaway_store (Request $request){
        $validator = Validator::make($request->all(), [
                   
        ]);

        $session_id = Str::random(10);
        Session::put('session_id',$session_id);

        if ($validator->passes()) {
            $takeway = new Order();
            $takeway->session_id = session('session_id'); 
            $takeway->order_type = $request->order_type;                   
            $takeway->notes = $request->notes;
            $takeway->ready_time = $request->ready_time;
            $takeway->takeaway_name = $request->takeaway_name;
            $takeway->takeaway_phone = $request->takeaway_phone;
            $takeway->takeaway_email = $request->takeaway_email;
            $takeway->save();

            $order = new OrderItem();
            $order->order_id = $takeway->id;
            $order->product_id = $request->id;
            $order->name = $request->name;
            $order->qty = $request->qty;
            $order->price = $request->price;
            $order->total = $request->total;
            $order->save();

            $request->session()->flash('success', 'Takeaway placed successfully');

            return response()->json([
                'status' => true,
                'message' => 'Takeaway added successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function delivery_store (Request $request){
        //dd($request->all());
        $validator = Validator::make($request->all(), [
                   
        ]);

        $session_id = Str::random(10);
        Session::put('session_id',$session_id);

        if ($validator->passes()) {
            $delivery = new Order();
            $delivery->session_id = session('session_id'); 
            $delivery->order_type = $request->order_type;                   
            $delivery->notes = $request->notes;
            $delivery->ready_time = $request->ready_time;
            $delivery->address = $request->address;
            $delivery->delivery_name = $request->delivery_name;
            $delivery->delivery_phone = $request->delivery_phone;
            $delivery->delivery_email = $request->delivery_email;
            $delivery->save();

            $order = new OrderItem();
            $order->order_id = $delivery->id;
            $order->product_id = $request->id;
            $order->name = $request->name;
            $order->qty = $request->qty;
            $order->price = $request->price;
            $order->total = $request->total;
            $order->save();

            $request->session()->flash('success', 'Delivery placed successfully');

            return response()->json([
                'status' => true,
                'message' => 'Delivery added successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
