<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;


class HomeController extends Controller
{
    public function index()
    {
        $result['products'] = DB::table('products')->where(['product_status'=>1])->get();        
        $result['categories'] = DB::table('categories')->get();
        
        foreach($result['products'] as $list){            
            $temp = DB::table('products_attribute')->where(['product_id'=>$list->id])->get();
            if($temp->count() > 0){
                $result['product_attributes'][$list->id]= $temp;                
            }                        
        }
        return view('pages.home',$result);
    }
    public function about(){
        return view('pages.about');
    }

    public function contact(){
        return view('pages.contact'); 
    }
    
    public function display($slug){
        $result['products'] = DB::table('products')->where(['product_slug'=>$slug])->get();        

        $tempTable = DB::table('products_images')->where(['product_id'=>$result['products'][0]->id])->get();        

        if($tempTable->count() > 0){
            $result['products_extra_images'] = $tempTable;
        }

        $tempTable = DB::table('products_attribute')
        ->leftJoin('colors','colors.id','products_attribute.color')
        ->where(['products_attribute.product_id'=>$result['products'][0]->id])->get();                

        if($tempTable->count() > 0){
            $result['products_attributes'] = $tempTable;
        }

        $tempTable = DB::table('products')->where(['category_id'=>$result['products'][0]->category_id,'product_status'=>1])->get();
        if($tempTable->count() > 0){
            $result['related_products'] = $tempTable;
        }

        $result['categories'] = DB::table('categories')->where(['id'=>$result['products'][0]->category_id])->get();

        
        // echo "<pre>";
        // print_r($result);
        // die();
        return view('pages.display',$result); 
        
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
        $success = false;
        $message = "Failed! Add To Cart";
        $product_id = $request->post('product_id');
        $product_quantity = $request->post('product_quantity');
        $product_attributes_id = $request->post('product_attributes_id');
        
        if($request->session()->has("customerLogin")){
            $getID = $request->session()->get('customerId');
        }else{
            $getID = $this->getRandomId();
        }

        //return response()->json(['success' =>$success,'message'=>$message]);
    }

    public function show(Home $home)
    {
        //
    }

    public function edit(Home $home)
    {
        //
    }

    public function update(Request $request, Home $home)
    {
        //
    }

    public function destroy(Home $home)
    {
        //
    }

    private function getRandomId(){
        if(session()->has('tempRandomId')){
            $random =  session()->get('tempRandomId');            
        }else{
            $random = time();
            session()->put('tempRandomId',$random);
        }
        return $random;
    }
}
