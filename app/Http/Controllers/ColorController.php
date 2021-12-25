<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ColorController extends Controller
{
    public function index()
    {
        $result['data'] = Color::all();
        
        return view('admin/colors/color',$result);
    }

    public function create($id='')
    {   
        if($id>0){
            $model = Color::where(['id'=>$id])->get();
            $result['color_name'] = $model[0]->color_name;            
            $result['color_id'] = $model[0]->id;
        }else{            
            $result['color_name'] = '';
            $result['color_id'] = '';
        }
        $result['color_list'] = DB::table('colors')->select('color_name','id')->get();
        return view('admin/colors/create',$result);
    }

    public function store(Request $request)
    {        
        $request->validate([            
            'colors_name' => ($request->post('colors_id') > 0)?'required':'required|unique:colors,color_name,'.$request->post('colors_name'),            
        ]);
             
        
        if($request->post('colors_id') > 0){
            $model = Color::where(['id'=>$request->post('colors_id')])->first();
            $message = 'Color updated!';
        }else{
            $model = new Color();
            $message = 'Color inserted!';
        }
       
        $model->color_name = $request->post('colors_name');         
        $model->save();
        $request->session()->flash('message',$message);

        return redirect('admin/color');        
    }

    
    public function status(Request $request, $status, $id){
        $model = Color::find($id);
        $model->color_status = $status;
        $model->save();
        $request->session()->flash('message','Color Status Updated!');
        return redirect('admin/color');         
    }

    public function destroy(Request $request, $id)//color $color)
    {
        $model = Color::where(['id'=>$id]);
        $model->delete();
        $request->session()->flash('message','color Deleted!');
        return redirect('admin/color');        
    }
}
