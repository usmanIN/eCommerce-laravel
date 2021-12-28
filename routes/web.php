<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ColorController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/',[HomeController::class,'index']);
Route::get('/about',[HomeController::class,'about']);
Route::get('/contact',[HomeController::class,'contact']);
Route::get('/product/{slug}',[HomeController::class,'display']);
Route::post('/cart_add',[HomeController::class,'store']);


Route::get('/login',[AdminController::class,'index']);
Route::post('/login', [AdminController::class,'login']);
Route::get('/register',[AdminController::class,'signup']);
Route::post('/register', [AdminController::class,'register']);



Route::group(['middleware'=>'admin_auth','prefix'=>'admin'],function(){

     Route::get('dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');     

     Route::prefix('category')->group(function(){
        Route::get('/',[CategoriesController::class,'index']);
        Route::get('/create',[CategoriesController::class,'create']);
        Route::get('/create/{id}',[CategoriesController::class,'create']);
        Route::post('/add', [CategoriesController::class,'store'])->name('category.add');  
        Route::get('delete/{id}',[CategoriesController::class,'destroy']);        
     });

     Route::prefix('color')->group(function(){
      Route::get('/',[ColorController::class,'index']);
      Route::get('/create',[ColorController::class,'create']);
      Route::get('/create/{id}',[ColorController::class,'create']);
      Route::post('/add', [ColorController::class,'store'])->name('color.add');  
      Route::get('/delete/{id}',[ColorController::class,'destroy']);        
      Route::get('/status/{type}/{id}',[ColorController::class,'status']);    
   });


     Route::prefix('brand')->group(function(){
      Route::get('/',[BrandController::class,'index']);
      Route::get('/create',[BrandController::class,'create']);
      Route::get('/create/{id}',[BrandController::class,'create']);
      Route::post('/add', [BrandController::class,'store'])->name('brand.add');  
      Route::get('delete/{id}',[BrandController::class,'destroy']);        
   });

     Route::prefix('coupon')->group(function(){
        Route::get('/',[CouponController::class,'index']);
        Route::get('/create',[CouponController::class,'create']);
        Route::get('/create/{id}',[CouponController::class,'create']);
        Route::post('/add', [CouponController::class,'store'])->name('coupon.add');  
        Route::get('delete/{id}',[CouponController::class,'destroy']);        
     });

     Route::prefix('product')->group(function(){
        Route::get('/',[ProductController::class,'index']);
        Route::get('/create',[ProductController::class,'create']);
        Route::get('/create/{id}',[ProductController::class,'create']);
        Route::post('/add', [ProductController::class,'store'])->name('product.add');  
        Route::get('delete/{id}',[ProductController::class,'delete']);    
        Route::get("deleteAttribute/{id}",[ProductController::class,'deleteAttribute']);    
        Route::get("deleteExtraImage/{id}",[ProductController::class,'deleteExtraImage']);    
        Route::get('/status/{type}/{id}',[ProductController::class,'status']);    
     });
});

Route::get('logout',function(){        
    session()->forget('isLogin'); 
    session()->forget('email');
    session()->forget('ADMIN_ID');
    return redirect('login');
 });