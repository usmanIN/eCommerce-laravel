<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;

class BrandController extends Controller
{
    public function index()
    {
        //
        $result['data'] = Brand::all();
        
        return view('admin/brands/brand',$result);
    }

    public function create($id='')
    {        
        if($id>0){
            $model = Brand::where(['id'=>$id])->get();
            $result['brands_name'] = $model[0]->brands_name;
            $result['brands_image'] = $model[0]->brands_image;            
            $result['brands_id'] = $model[0]->id;
        }else{            
            $result['brands_name'] = '';
            $result['brands_image'] = '';
            $result['brands_id'] = '';
        }
        return view('admin/brands/create',$result);
    }

    public function store(Request $request)
    {        
        $request->validate([
            'brands_name' => ($request->post('brands_id') > 0)?'required':'required|unique:brands,brands_name',
            'brands_image' => ($request->post('brands_id') > 0)?'mimes:jpeg,jpg,png':'required|mimes:jpeg,jpg,png',
        ]);
                        
        if($request->post('brands_id') > 0){
            $model = Brand::where(['id'=>$request->post('brands_id')])->first();
            $message = 'Brands updated!';
        }else{
            $model = new Brand();
            $message = 'Brands inserted!';
        }       
        
        $model->brands_name = $request->post('brands_name');

        if($request->hasfile('brands_image')){
            $image = $request->file('brands_image');
            $extenstion = $image->extension();
            $image_name = pathinfo($image->getClientOriginalName(),PATHINFO_FILENAME).uniqid().time().".".$extenstion;
            $image->storeAs('/public/media' ,$image_name);
            $model->brands_image = $image_name;
        }
        $model->save();

        $request->session()->flash('message',$message);
        return redirect('admin/brand');        
    }

    public function destroy(Request $request, $id)//brands $brands)
    {
        $tableImage = DB::table("brands")->where(['id'=>$id]);        
        if(Storage::exists("/public/media/".$tableImage->get()[0]->brands_image)){
            Storage::delete("/public/media/".$tableImage->get()[0]->brands_image);
        }
        $tableImage->delete();
        $request->session()->flash('message','Brands Deleted!');
        return redirect('admin/brand');        
    }


}
