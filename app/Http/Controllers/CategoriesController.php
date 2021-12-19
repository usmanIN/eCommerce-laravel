<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index()
    {
        $result['data'] = Categories::all();
        
        return view('admin/categories/category',$result);
    }

    public function create($id='')
    {   
        if($id>0){
            $model = Categories::where(['id'=>$id])->get();
            $result['categories_name'] = $model[0]->categories_name;
            $result['categories_slug'] = $model[0]->categories_slug;            
            $result['categories_parent'] = $model[0]->categories_parent;            
            //$result['categories_image'] = $model[0]->categories_image;            
            $result['categories_id'] = $model[0]->id;
        }else{            
            $result['categories_name'] = '';
            $result['categories_slug'] = '';
            $result['categories_parent'] = '';
            $result['categories_id'] = '';
        }
        $result['categories_list'] = DB::table('categories')->select('categories_name','id')->get();
        return view('admin/categories/create',$result);
    }

    public function store(Request $request)
    {        
        
        $request->validate([
            'categories_name' => 'required',
            'categories_slug' => 'required|unique:categories,categories_slug,'.$request->post('categories_id'),            
        ]);
                        
        if($request->post('categories_id') > 0){
            $model = Categories::where(['id'=>$request->post('categories_id')])->first();
            $message = 'Categories updated!';
        }else{
            $model = new Categories();
            $message = 'Categories inserted!';
        }
       
        $model->categories_name = $request->post('categories_name');
        $model->categories_parent = $request->post('categories_parent');            
        $model->categories_slug = Str::slug($request->post('categories_slug'));
        $model->save();
        $request->session()->flash('message',$message);

        return redirect('admin/category');        
    }

    public function destroy(Request $request, $id)//Categories $categories)
    {
        $model = Categories::where(['id'=>$id]);
        $model->delete();
        $request->session()->flash('message','Categories Deleted!');
        return redirect('admin/category');        
    }
}
