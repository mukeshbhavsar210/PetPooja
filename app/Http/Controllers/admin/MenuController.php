<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Menu;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Drivers\Gd\Driver;

class MenuController extends Controller
{
    public function index(Request $request){
        $categories = Category::orderBy('name','ASC')->get();
        $menus = Menu::orderBy('name','ASC')->get();

        $menuCount = DB::table('menus')
                    ->select(DB::raw('count(*) as total_menu'))
                    ->get()[0]->total_menu;

        // $subCategories = SubCategory::select('sub_categories.*','categories.name as categoryName')
        //     ->latest('sub_categories.id')
        //     ->leftJoin('categories', 'categories.id', 'sub_categories.category_id');

        // if(!empty($request->get('keyword'))){
        //     $subCategories = $subCategories->where('sub_categories.name', 'like', '%'.$request->get('keyword').'%');
        //     $subCategories = $subCategories->orWhere('categories.name', 'like', '%'.$request->get('keyword').'%');
        // }

        $data = [];
        $data['categories'] = $categories;
        $data['menus'] = $menus;
        $data['menuCount'] = $menuCount;
        
        //dd($menuCount);

        return view('admin.menu.list', $data);      
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',           
        ]);

        if ($validator->passes()) {
            $menu = new Menu();
            $menu->name = $request->name;
            $menu->slug = $request->slug;
            $menu->category_id = $request->category;
            $menu->save();

            // Save image here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $menu->id.'_'.$menu->name.'.'.$ext;                
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/menu/'.$newImageName;                
                File::copy($sPath,$dPath);

                //Generate thumbnail
                $dPath = public_path().'/uploads/menu/thumb/'.$newImageName;
                $manager = new ImageManager(new Driver());
                $image = $manager->read($sPath);
                $image->cover(300,300);
                $image->save($dPath);
                $image->save($dPath);                                  
                $menu->image = $newImageName;
                $menu->save();
            }

            $request->session()->flash('success', 'Menu added successfully');

            return response([
                'status' => true,
                'message' => 'Menu added successfully',
            ]);

        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    public function edit($id, Request $request){

        $subCategory = Menu::find($id);
        if(empty($subCategory)){
            $request->session()->flash('error','Record not found');
            return redirect()->route('menu.index');
        }

        $categories = Category::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        $data['subCategory'] = $subCategory;
        return view("admin.sub_category.edit", $data);
    }

    public function update($id, Request $request){

        $subCategory = SubCategory::find($id);

        if(empty($subCategory)){
            $request->session()->flash('error','Record not found');
            return response([
                'status' => false,
                'notFound' => true,
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,'.$subCategory->id.',id',
            'category' => 'required',
            'status' => 'required',
        ]);

        if ($validator->passes()) {

            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->showHome = $request->showHome;
            $subCategory->category_id = $request->category;
            $subCategory->save();

            $request->session()->flash('success', 'Sub Category updated successfully');

            return response([
                'status' => true,
                'message' => 'Sub Category updated successfully',
            ]);

        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    

    public function destroy($id, Request $request){
        $subCategory = Menu::find($id);

        if(empty($subCategory)){
            $request->session()->flash('error','Record not found');
            return response([
                'status' => false,
                'notFound' => true,
            ]);
        }

        $subCategory->delete();

        $request->session()->flash('success', 'Sub Category deleted successfully');

        return response([
            'status' => true,
            'message' => 'Sub Category deleted successfully',
        ]);
    }
}
