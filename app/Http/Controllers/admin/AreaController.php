<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Cart;
use App\Models\Seating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller {
    public function index(Request $request){
        $areas = Area::orderBy('area_name','ASC')->with('seating')->get();

        // $pic = DB::table('product_images')
        //             ->rightJoin('products','product_images.product_id','=','products.id')
        //             ->select('product_images.*','product_images.product_id')
        //             ->get();

        $seatings = DB::table('seatings')
                    ->join('areas','seatings.area_id','=','areas.id')
                    ->select('seatings.*','areas.area_name')
                    //->where('areas.area_name','=','Chandkheda')
                    ->get();

        $totalTable = DB::table('seatings')
                    ->select(DB::raw('count(*) as total_tables'))
                    ->get()[0]->total_tables;

        $tableIndividual = DB::table('seatings')
                    //->join('areas','seatings.area_id','=','areas.id')
                    ->select(DB::raw('count(*) as number'), 'area_id')
                    ->groupBy('area_id')
                    ->get()[0]->number;

        //$seatings = $seatings->paginate(10);
      
        $data['areas'] = $areas;
        $data['seatings'] = $seatings;
        $data['tableIndividual'] = $tableIndividual;
        $data['totalTable'] = $totalTable;

        return view('admin.areas.list', $data);
    }

    function getAreas(){
        return Area::orderBy('area_name','ASC')->with('seating')->take(4)->orderBy('id','DESC')->get();
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'area_name' => 'required',            
        ]);

        if ($validator->passes()) {
            $area = new Area();
            $area->area_name = $request->area_name;
            $area->area_slug = $request->area_slug;
            $area->save();

            $request->session()->flash('success', 'Restaurant added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Restaurant added successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    public function store_table(Request $request){

        //QR CODE
        $number = mt_rand(1000000000, 9999999999);        
        if($this->productCodeExists($number)){
            $number = mt_rand(1000000000, 9999999999);
        }
        $request['product_code'] = $number;
       
        //Seating::create($request->all());

        //Validation
        $validator = Validator::make($request->all(), [
            'table_name' => 'required',    
            'area_id' => 'uniq',         
        ]);
       
        if ($validator->passes()) {
            $menu = new Seating();
            $menu->area_id = $request->area;
            $menu->table_name = $request->table_name;
            $menu->slug = $request->slug;
            $menu->product_code = $request->qr_generate;            
            $menu->seating_capacity = $request->seating_capacity;
            $menu->save();

            $request->session()->flash('success', 'Table added successfully');

            return response([
                'status' => true,
                'message' => 'Table added successfully',
            ]);

        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function productCodeExists($number){
        return Seating::whereProductCode($number)->exists();
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
