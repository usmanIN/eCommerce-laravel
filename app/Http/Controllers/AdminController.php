<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    //

    function index(Request $request){
        if($request->session()->has('isLogin')){            
            return redirect('admin/dashboard');
        }else{
            
            return view('pages.login');
        }
    }

    function login(Request $request){

        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->post('username');
        $password = $request->post('password');
        $result = Admin::where(['email'=>$username])->first();

        if($result){
            if(Hash::check($password,$result->password)){    
                $request->session()->put('isLogin',true); 
                $request->session()->put('email',$username);
                $request->session()->put('ADMIN_ID',$result->id);
                return redirect('admin/dashboard');
            }else{
                $request->session()->flash("error",'Please Enter Correct Password');    
            }
        }else{
            $request->session()->flash("error",'Please Enter Valid Detials');
        }
        return redirect('login');
    }

    
    function signup(Request $request){
        if($request->session()->has('isLogin')){            
            return redirect('admin/dashboard');
        }else{            
            return view('pages.register');
        }
    }

    function register(Request $request){

        $request->validate([
            'email' => 'required|unique:admins',
            'password' => 'required|min:8'
        ]);

        $username = $request->post('email');
        $password = $request->post('password');
        
        $model = new Admin();
        $model->email =  $username;
        $model->password = Hash::make($password);
        $model->save();

        return redirect('login');
    }

    function dashboard(){
        return view('admin/dashboard');
    }
    
}
