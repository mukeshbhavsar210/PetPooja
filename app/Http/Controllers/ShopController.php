<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug = null) {
        $categorySelected = ' ';
        $menuSelected = ' ';

        $categories = Category::orderBy("name","ASC")->with('menu')->get();        
        $products = Product::where('status',1);

        //Apply filters here
        if(!empty($categorySlug)) {
            $category = Category::where('slug',$categorySlug)->first();
            $products = $products->where('category_id',$category->id);
            $categorySelected = $category->id;
        }

        //Search main header
        if (!empty($request->get('search'))){
            $products = $products->where('title','like','%'.$request->get('search').'%');
        }
        //$products = $products->paginate(10);

        $data['categories'] = $categories;
        $data['products'] = $products;
        $data['categorySelected'] = $categorySelected;
        $data['menuSelected'] = $menuSelected;
        // $data['priceMax'] = (intval($request->get('price_max')) == 0 ? 1000 : $request->get('price_max'));
        // $data['priceMin'] = intval($request->get('price_min'));
        // $data['sort'] = $request->get('sort');

        return view('front.shop.index',$data);
    }




    public function product($slug){
        $product = Product::where('slug',$slug)->with('product_images')->first();

        if($product == null){
            abort(404);
        }

        //Fetch Related products
        $relatedProducts = [];
        if ($product->related_products != '') {
            $productArray = explode(',',$product->related_products);
            $relatedProducts = Product::whereIn('id',$productArray)->where('status',1)->with('product_images')->get();
        }

        $data['product'] = $product;
        $data['relatedProducts'] = $relatedProducts;


        return view('front.products.index',$data);
    }
}
