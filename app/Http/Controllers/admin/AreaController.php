<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller {
    public function index(Request $request){
        $areas = Area::latest();

        if(!empty($request->get('keyword'))){
            $areas = $areas->where('name', 'like', '%'.$request->get('keyword').'%');
        }

        $areas = $areas->paginate(10);
        return view('admin.areas.list', compact('areas'));
    }

   


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',            
        ]);

        if ($validator->passes()) {
            $area = new Area();
            $area->name = $request->name;            
            $area->save();

            $request->session()->flash('success', 'Category added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category added successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    public function cart_store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',            
        ]);

        if ($validator->passes()) {
            $area = new Area();
            $area->name = $request->name;            
            $area->save();

            $request->session()->flash('success', 'Category added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category added successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }



    public function edit($areaId, Request $request){
        $area = Area::find($areaId);

        if (empty($area)) {
            return redirect()->route('areas.index');
        }

        return view('admin.areas.edit', compact('area'));
    }



    public function update($areaId, Request $request){
        $area = Area::find($areaId);
        if (empty($area)) {
            $request->session()->flash('error', 'area not found');
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'area not found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',            
        ]);

        if ($validator->passes()) {
            $area->name = $request->name;            
            $area->save();

            $request->session()->flash('success', 'Area updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Area updated successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($areaId, Request $request){
        $area = Area::find($areaId);

        if(empty($area)){
            $request->session()->flash('error', 'Area not found');
            return response()->json([
                'status' => true,
                'message' => 'Area not found'
            ]);            
        }

        $area->delete();
        $request->session()->flash('success', 'Area deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Area deleted successfully'
        ]);
    }
}
