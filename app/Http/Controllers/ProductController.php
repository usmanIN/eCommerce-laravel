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
            $result['product_attr_array'] = DB::table('products_attribute')->where(['product_id'=>$id])->get();
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
            $result['product_attr_array'] = '';
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

        $title = $request->post('product_name');
        $model->product_name = $request->post('product_name');
        $model->product_brand = $request->post('product_brand');
        $model->product_slug = Str::slug($title);
        $model->product_model = $request->post('product_model');
        $model->product_short_description = $request->post('product_short_description');
        $model->product_description = $request->post('product_description');
        $model->product_keywords = $request->post('product_keywords');
        $model->category_id = $request->post('category_id');
        $model->save();

        //Product Attributes Started
        if($request->post('product_id')>0){
            $product_attr_array['product_id'] = $request->post('product_id'); // Product Id        
        }else{
            $product_attr_array['product_id'] = $model->id; // Product Id 
        }
       
        for($i = 0 ; $i < sizeof($request->post('product_attr_sku')) ; $i++){

            $product_attr_array['SKU'] = $request->post('product_attr_sku')[$i]; // Product Attribute SKU            

            if($request->hasfile('product_attr_image')){                                
                $image = $request->file('product_attr_image')[$i]; // Product Attributes Image
                $extenstion = $image->extension();
                $image_name = time().".".$extenstion;
                $image->storeAs('/public/media',$image_name);
                $product_attr_array['image'] = $image_name;
            }

            $product_attr_array['MRP'] = $request->post('product_attr_mrp')[$i]; // Product Attributes MRP
            $product_attr_array['Price'] = $request->post('product_attr_price')[$i]; // Product Attributes Price
            $product_attr_array['Quantity'] = $request->post('product_attr_qunatity')[$i]; // Product Attributes Quantity

            if($request->post('product_attr_id')[$i]!=''){
                DB::table('products_attribute')->where(['id'=>$request->post('product_attr_id')[$i]])->update($product_attr_array);                
            }else{
                DB::table('products_attribute')->insert($product_attr_array);
            }
            
        }

        //Product Attributes ended
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
