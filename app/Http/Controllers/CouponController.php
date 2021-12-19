<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $result['data'] = Coupon::all();
        
        return view('admin/coupons/coupon',$result);
    }

    public function create($id='')
    {   
        if($id>0){
            $model = Coupon::where(['id'=>$id])->get();
            $result['coupon_title'] = $model[0]->coupon_title;
            $result['coupon_code'] = $model[0]->coupon_code;            
            $result['coupon_value'] = $model[0]->coupon_value;            
            $result['coupon_type'] = $model[0]->coupon_type;
            $result['coupon_min_order'] = $model[0]->coupon_min_order;
            $result['is_one_time'] = $model[0]->is_one_time;
            $result['coupon_id'] = $model[0]->id;
            
        }else{            
            $result['coupon_title'] = '';
            $result['coupon_code'] = '';
            $result['coupon_value'] = '';            
            $result['coupon_id'] = '';
            $result['coupon_type'] = '';
            $result['coupon_min_order'] = '';
            $result['is_one_time'] = '';
            
        }
        return view('admin/coupons/create',$result);
    }

    public function store(Request $request)
    {        
        
        $request->validate([
            'coupon_title' => 'required',            
            'coupon_code' => 'required|unique:coupons,coupon_code,'.$request->post('coupon_id'),            
            'coupon_value'=> 'required',
            'coupon_type' => 'required',
        ]);
                        
        if($request->post('coupon_id') > 0){
            $model = Coupon::where(['id'=>$request->post('coupon_id')])->first();
            $message = 'Coupon updated!';
        }else{
            $model = new Coupon();
            $message = 'Coupon inserted!';
        }
       
        $model->coupon_title = $request->post('coupon_title');
        $model->coupon_code = $request->post('coupon_code');
        $model->coupon_value = $request->post('coupon_value');
        $model->coupon_type  = $request->post('coupon_type');
        $model->coupon_min_order = $request->post('coupon_min_order');
        $model->is_one_time = $request->post('is_one_time');            
        $model->save();
        $request->session()->flash('message',$message);

        return redirect('admin/coupon');        
    }

    public function destroy(Request $request, $id)//coupon $coupon)
    {
        $model = Coupon::where(['id'=>$id]);
        $model->delete();
        $request->session()->flash('message','Coupon Deleted!');
        return redirect('admin/coupon');        
    }
}
