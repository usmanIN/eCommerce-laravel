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
        $tempTable = DB::table('products_attribute')->where(['product_id'=>$result['products'][0]->id])->get();                
        if($tempTable->count() > 0){
            $result['products_attributes'] = $tempTable;
            foreach($tempTable as $key => $list){
                $result['colors'][$key] = DB::table('colors')->where(['id'=>$list->color])->get();
            }
        }
        $tempTable = DB::table('products')->where(['category_id'=>$result['products'][0]->category_id,'product_status'=>1])->get();
        if($tempTable->count() > 0){
            $result['related_products'] = $tempTable;
        }

        $result['categories'] = DB::table('categories')->where(['id'=>$result['products'][0]->category_id])->get();

        
        // echo "<pre>";
        // print_r($result['colors']);
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
}
