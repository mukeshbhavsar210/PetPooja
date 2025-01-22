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


    public function wishlist() {
        $products = Product::orderBy('id','DESC')->get();        
        $data = [
            'products'=> $products,            
        ];

        dd($products);
        return view('front.home.wishlist', $data);        
    }

    public function index(Request $request, $areaSlug = null,) {
        $areaSlug = ' ';


    public function restaurant(Request $request, $areaSlug = null) {       
        $areaSelected = ' ';

        $products = Product::orderBy('id','DESC')->get();
        $seatings = Seating::orderBy("name","ASC")->with('area')->get(); 
        $areas = Area::where('status',1);

        if(!empty($areaSlug)) {
            $restaurant = Area::where('slug',$areaSlug)->first();
            $seatings = $seatings->where('area_id',$restaurant->id);
            $areaSelected = $restaurant->id;
        }

        //$seatings = $seatings->paginate(10);
        
        $data['seatings'] = $seatings;  
        $data['products'] = $products;  
        $data['areas'] = $areas;        
        $data['areaSelected'] = $areaSelected;
        
        //dd($seatings);

        return view('front.shop.test',$data);
    }


    public function restaurant(Request $request, $areaSlug = null) {       
        $areaSelected = ' ';

        $products = Product::orderBy('id','DESC')->get();
        $seatings = Seating::orderBy("name","ASC")->with('area')->get(); 
        $areas = Area::where('status',1);

        // if(!empty($areaSlug)) {
        //     $restaurant = Area::where('slug',$areaSlug)->first();
        //     $seatings = $seatings->where('area_id',$restaurant->id);
        //     $areaSelected = $restaurant->id;
        // }

        $data['seatings'] = $seatings;  
        $data['products'] = $products;  
        $data['areas'] = $areas;        
        $data['areaSelected'] = $areaSelected;
        
        return view('front.shop.test',$data);
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



    public function addToWish($id){
        $product = Product::with('product_images')->find($id);
        
        if (!$product) {
            abort(404);
        }

        $cart = session()->get('wishlist');

        if (!$cart) {
            $cart = [
                $id => [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,                    
                ]
            ];

            session()->put('wishlist', $cart);
            return redirect()->back()->with('success', 'Product added to wishlist successfully!');
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('wishlist', $cart);
            return redirect()->back()->with('success', 'Product added to wishlist successfully!');
        }

        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,                        
        ];

        session()->put('wishlist', $cart);

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Product added to wishlist successfully!']);
        }
        return redirect()->back()->with('success', 'Product added to wishlist successfully!');
    }


    public function removeWishlistItem(Request $request) {
        if ($request->id) {
            $cart = session()->get('wishlist');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('wishlist', $cart);
            }

            session()->flash('success', 'Product removed successfully');
        }
    }

    public function clearWishlist(){
        session()->forget('wishlist');
        return redirect()->back();
    }


    // public function addToWishlist(Request $request){
    //     if(Auth::check() == false){
    //         session(['url.intended' => url()->previous() ]);
    //         return response()->json([
    //             'status' => false,
    //         ]);
    //     }

    //     // if(Auth::check() == false){
    //     //     session(['url.intended' => url()->previous() ]);
    //     //     return response()->json([
    //     //         'status' => false,
    //     //     ]);
    //     // }

    //     //Product add in wishlist
    //     $product = Product::where('id', $request->id)->first();

    //     if ($product == null){
    //         return response()->json([
    //             'status' => true,
    //             'message' => '<div class="alert alert-danger">Product not found.</div>'
    //         ]);
    //     }


    //     Wishlist::updateOrCreate(
    //         [
    //             'user_id' => Auth::user()->id,
    //             'product_id' => $request->id,
    //         ],
    //         [
    //             'user_id' => Auth::user()->id,
    //             'product_id' => $request->id,
    //         ],
    //     );

    //     //$wishlist = new Wishlist;
    //     //$wishlist->user_id = Auth::user()->id;
    //     //$wishlist->product_id = $request->id;
    //     //$wishlist->save();

    //     return response()->json([
    //         'status' => true,
    //         'message' => '<div class="alert alert-success"><strong>"'.$product->title.'"</strong> added in yout wishlist!</div>'
    //     ]);
    // }



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
            $dinein->total = $request->total;
            $dinein->save();

            $order_id = DB::getPdo()->lastInsertId();

            foreach ($cart as $data) {     
                $order = new OrderItem;
                $order->order_id = $dinein->id;
                $order->name = $data['name'];
                $order->price = $data['price'];
                $order->qty = $data['quantity'];
                $order->total = $data['price']*$data['quantity'];
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

        $cart = Session::get('cart');

        if ($validator->passes()) {
            $takeway = new Order();
            $takeway->session_id = session('session_id'); 
            $takeway->order_type = $request->order_type;                   
            $takeway->notes = $request->notes;
            $takeway->ready_time = $request->ready_time;
            $takeway->takeaway_name = $request->takeaway_name;
            $takeway->takeaway_phone = $request->takeaway_phone;
            $takeway->takeaway_email = $request->takeaway_email;
            $takeway->total = $request->total;
            $takeway->save();

            foreach ($cart as $data) {     
                $order = new OrderItem;
                $order->order_id = $takeway->id;
                $order->name = $data['name'];
                $order->price = $data['price'];
                $order->qty = $data['quantity'];
                $order->total = $data['price']*$data['quantity'];
                $order->save();
            }

            Session::forget('cart');

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

        $cart = Session::get('cart');

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
            $delivery->total = $request->total;
            $delivery->save();

            foreach ($cart as $data) {     
                $order = new OrderItem;
                $order->order_id = $delivery->id;
                $order->name = $data['name'];
                $order->price = $data['price'];
                $order->qty = $data['quantity'];
                $order->total = $data['price']*$data['quantity'];
                $order->save();
            }

            Session::forget('cart');
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
