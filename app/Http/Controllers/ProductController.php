<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $result['data'] = Product::all();
        return view('admin/products/product',$result);
    }

    public function create($id='')
    {   
        if($id>0){
            $model = Product::where(['id'=>$id])->get();
            $result['product_id'] = $model[0]->id;
            $result['product_name'] = $model[0]->product_name;
            $result['product_brand'] = $model[0]->product_brand;            
            $result['product_model'] = $model[0]->product_model;            
            $result['product_short_description'] = $model[0]->product_short_description;
            $result['product_description'] = $model[0]->product_description;
            $result['product_keywords'] = $model[0]->product_keywords;
            $result['category_id'] = $model[0]->category_id;
            $result['product_image'] = $model[0]->product_image;
        }else{            
            $result['product_id'] = '';
            $result['product_name'] = '';
            $result['product_brand'] = '';
            $result['product_model'] = '';
            $result['product_short_description'] = '';
            $result['product_description'] = '';
            $result['product_keywords'] = '';
            $result['category_id'] = '';
            $result['product_image'] = '';
        }

        $result['category'] =  DB::table('categories')->get();
        
        return view('admin/products/create',$result);
    }

    
    public function store(Request $request)
    {               
        $request->validate([
            'product_name' => 'required',
            'product_image' => ($request->post('product_id') > 0)?'mimes:jpeg,jpg,png':'required|mimes:jpeg,jpg,png'
        ]);
                        
        if($request->post('product_id') > 0){
            $model = Product::where(['id'=>$request->post('product_id')])->first();
            $message = 'product updated!';
        }else{
            $model = new Product();
            $message = 'product inserted!';
        }   

        if($request->hasfile('product_image')){
            $image = $request->file('product_image');
            $extenstion = $image->extension();
            $image_name = time().".".$extenstion;
            $image->storeAs('/public/media',$image_name);
            $model->product_image = $image_name;
        }


        $title  = $request->post('product_name');
        $model->product_name = $request->post('product_name');
        $model->product_brand = $request->post('product_brand');
        $model->product_slug = Str::slug($title);
        $model->product_model = $request->post('product_model');
        $model->product_short_description = $request->post('product_short_description');
        $model->product_description = $request->post('product_description');
        $model->product_keywords = $request->post('product_keywords');
        
        $model->category_id = $request->post('category_id');
        
        $model->save();
        $request->session()->flash('message',$message);

        return redirect('admin/product');        
    }

    public function destroy(Request $request, $id)//product $product)
    {
        $model = Product::where(['id'=>$id]);
        $model->delete();
        $request->session()->flash('message','product Deleted!');
        return redirect('admin/product');        
    }

    public function status(Request $request, $status, $id){
        $model = Product::find($id);
        $model->product_status = $status;
        $model->save();
        $request->session()->flash('message','Product Status Updated!');
        return redirect('admin/product');
         
    }

}
