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
        $result['product_attr_array'][0] =  (object)['id' => '','SKU' => '','image' => '','MRP' => '','Price' => '','Quantity' => '','product_id' => ''];
        $result['product_extra_images'][0] = (object)['id' => '','product_id' => '','product_images' => ''];

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
            // product_attributes
            $temp = DB::table('products_attribute')->where(['product_id'=>$id])->get();
            if($temp->count() > 0) { $result['product_attr_array'] = $temp; }
            // product_extra_images    
            $temp = DB::table('products_images')->where(['product_id'=>$id])->get();
            if($temp->count() > 0) { $result['product_extra_images'] = $temp; }
                
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
        $result['brand'] =  DB::table('brands')->get();
        
        return view('admin/products/create',$result);
    }

    
    public function store(Request $request)
    {       
    
        $request->validate([
            'product_name' => 'required',
            'product_image' => ($request->post('product_id') > 0)?'mimes:jpeg,jpg,png':'required|mimes:jpeg,jpg,png',
            'product_attr_image.*' => 'mimes:jpeg,jpg,png'
        ]);
                        
        if($request->post('product_id') > 0){
            $model = Product::where(['id'=>$request->post('product_id')])->first();
            $message = 'product updated!';
        }else{
            $model = new Product();
            $message = 'product inserted!';
        }   

        if($request->hasfile('product_image')){
            $model->product_image = $this->getFile($request->file('product_image'));
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


        if($request->post('product_id')>0){
            $product_attr_array['product_id'] = $request->post('product_id'); // Product Id       
            $product_extra_images['product_id'] = $request->post('product_id'); // Product Id 
        }else{
            $product_attr_array['product_id'] = $model->id; // Product Id 
            $product_extra_images['product_id'] = $model->id; // Product Id 
        }

        //Product Extra Images Started
        if($request->hasfile('product_extra_image')){            
            foreach($request->file('product_extra_image') as $key=> $value){
                $product_extra_images['product_images'] = $this->getFile($value);                
                
                if($request->post('product_extra_id')[$key]!=''){
                    DB::table('products_images')->where(['id'=>$request->post('product_extra_id')[$key]])->update($product_extra_images);                            
                }else{
                    DB::table('products_images')->insert($product_extra_images);
                }
            }
        }
        //Product Extra Images Ended
        
        //Product Attributes Started
        foreach($request->post('product_attr_sku') as $key => $value){
            $product_attr_array['SKU'] = $value; // Product Attribute SKU                        
            $product_attr_array['MRP'] = $request->post('product_attr_mrp')[$key]; // Product Attributes MRP
            $product_attr_array['Price'] = $request->post('product_attr_price')[$key]; // Product Attributes Price
            $product_attr_array['Quantity'] = $request->post('product_attr_qunatity')[$key]; // Product Attributes Quantity
            if(isset($request->file('product_attr_image')[$key])){                                
                $product_attr_array['image'] = $this->getFile($request->file('product_attr_image')[$key]); // Product Attributes Image                )
            }                                
            if($request->post('product_attr_id')[$key]!=''){
                DB::table('products_attribute')->where(['id'=>$request->post('product_attr_id')[$key]])->update($product_attr_array);                            
            }else{
                DB::table('products_attribute')->insert($product_attr_array);
            }

        }        
        //Product Attributes ended
        $request->session()->flash('message',$message);
        return redirect('admin/product');        
    }

    public function delete(Request $request, $id)//product $product)
    {
        $model = Product::where(['id'=>$id]);
        $model->delete();
        $request->session()->flash('message','product Deleted!');
        return redirect('admin/product');        
    }
    
    public function deleteAttribute($id){

        if(DB::table("products_attribute")->delete($id)){
            return response()->json(["success"=>true]);
        }
        return response()->json(["success"=>false]);
    }
    public function deleteExtraImage($id){

        if(DB::table("products_images")->delete($id)){
            return response()->json(["success"=>true]);
        }
        return response()->json(["success"=>false]);
    }

    public function status(Request $request, $status, $id){
        $model = Product::find($id);
        $model->product_status = $status;
        $model->save();
        $request->session()->flash('message','Product Status Updated!');
        return redirect('admin/product');         
    }

    private function getFile($image, $location=''){        
        $extenstion = $image->extension();
        $image_name = pathinfo($image->getClientOriginalName(),PATHINFO_FILENAME).uniqid().time().".".$extenstion;
        if($location!='')
            $image->storeAs('/public'.$location ,$image_name);
        else    
            $image->storeAs('/public/media' ,$image_name);
        return $image_name;
    }

}
