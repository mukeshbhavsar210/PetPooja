<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
//use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Cart;

class FrontController extends Controller {

    public function show() {
        $products = Product::orderBy('id','DESC')->get();
        return view('front.home.index', compact('products'));        
    }


    // public function showCartTable(){
    //     $products = Product::all();
    //     return view('cart', compact('products'));
    // }


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








    // public function index(){        
    //     $products = Product::orderBy('id','DESC')->take(4)->get();
    //     $cartContent = Cart::content();
    //     //$countries = Country::orderBy('name','ASC')->get();

    //     $data['cartContent'] = $cartContent;
    //     $data['products'] = $products;      
    //     //$data['countries'] = $countries;          
                
    //     return view("front.home.index",$data);
    // }


    public function updateCart(Request $request){
        $rowId = $request->rowId;
        $qty = $request->qty;

        $itemInfo = Cart::get($rowId);
        $product = Product::find($itemInfo->id);

        //check qty available in stock
        if($product->track_qty == "Yes"){
            if($qty <= $product->qty ){
                Cart::update($rowId, $qty);
                $message = 'Cart updated successfully';
                $state = true;
                session()->flash('success',$message);
            } else {
                $message = 'Requested qty('.$qty.') not available in stock.';
                $state = false;
                session()->flash('error',$message);
            }
        } else {
            Cart::update($rowId, $qty);
            $message = 'Cart updated successfully';
            $state = true;
            session()->flash('success',$message);
        }

        return response()->json([
            "status"=> $state,
            "message"=> $message
        ]);
    }


  
    public function addToWishlist(Request $request){
        // if(Auth::check() == false){
        //     session(['url.intended' => url()->previous() ]);
        //     return response()->json([
        //         'status' => false,
        //     ]);
        // }


        
        session(['url.intended' => url()->previous() ]);
        return response()->json([
            'status' => false,
        ]);
        

        //Product add in wishlist
        $product = Product::where('id', $request->id)->first();

        if ($product == null){
            return response()->json([
                'status' => true,
                'message' => '<div class="alert alert-danger">Product not found.</div>'
            ]);
        }


        Wishlist::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->id,
            ],
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->id,
            ],
        );

        //$wishlist = new Wishlist;
        //$wishlist->user_id = Auth::user()->id;
        //$wishlist->product_id = $request->id;
        //$wishlist->save();

        return response()->json([
            'status' => true,
            'message' => '<div class="alert alert-success"><strong>"'.$product->title.'"</strong> added in yout wishlist!</div>'
        ]);
    }

    public function page($slug){
        $page = Page::where('slug', $slug)->first();

        if($page == null){
            abort(404);
        }

        return view('front.page', [
            'page' => $page
        ]);
    }

    public function sendContactEmail(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required|min:10',
        ]);

        if($validator->passes()){

        } else {
            return response()->json([
                'status'=> false,
                'errors' => $validator->errors()
            ]);
        }
    }



    public function dinening_store (Request $request){
        $validator = Validator::make($request->all(), [
                   
        ]);

        if ($validator->passes()) {
            $customer = new Cart();
            $customer->order_type = $request->order_type;
            $customer->notes = $request->notes;
            $customer->ready_time = $request->ready_time;
            $customer->table_number = $request->table_number;
            $customer->save();

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

        //dd($request->all());
        $validator = Validator::make($request->all(), [
                   
        ]);

        if ($validator->passes()) {
            $customer = new Cart();
            $customer->order_type = $request->order_type;                   
            $customer->notes = $request->notes;
            $customer->ready_time = $request->ready_time;
            $customer->takeaway_name = $request->takeaway_name;
            $customer->takeaway_phone = $request->takeaway_phone;
            $customer->takeaway_email = $request->takeaway_email;
            $customer->save();

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

        if ($validator->passes()) {
            $customer = new Cart();
            $customer->order_type = $request->order_type;                   
            $customer->notes = $request->notes;
            $customer->ready_time = $request->ready_time;
            $customer->address = $request->address;
            $customer->delivery_name = $request->delivery_name;
            $customer->delivery_phone = $request->delivery_phone;
            $customer->delivery_email = $request->delivery_email;
            $customer->save();

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
