@extends('admin.layouts');
@section('title','Create Product')
@section('content')
 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- DataTales Example -->
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Coupon</h6>                        
             @if(session()->has('message'))
                 {{ session('message') }}   
             @endif
        </div>
        <div class="card-body">           
            <form class="user" action="{{ route('product.add') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">         
                <input type="hidden" class="form-control" id="product_id" name="product_id" value="{{ $product_id }}">
                <label for="product_name"> Name </label>
                    <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product_name }}" required>
                    @error('product_name')
                        <span class="alert alert-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="product_brand"> Brand </label>
                    <input type="text" class="form-control" id="product_brand" name="product_brand" value="{{ $product_brand }}" required>
                    @error('product_code')
                        <span class="alert alert-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="product_model"> Model </label>
                    <input type="text" class="form-control" id="product_model" name="product_model" value="{{ $product_model }}" required>
                    @error('product_model')
                        <span class="alert alert-danger"> {{ $message }} </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="product_short_description"> Short Description </label>
                    <input type="text" class="form-control" id="product_short_description" name="product_short_description" value="{{ $product_short_description }}" required>
                    @error('product_short_description')
                        <span class="alert alert-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="product_description"> Desciption </label>
                    <input type="text" class="form-control" id="product_description" name="product_description" value="{{ $product_description }}" required>
                    @error('product_description')
                        <span class="alert alert-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="product_keywords"> Keywords </label>
                    <input type="text" class="form-control" id="product_keywords" name="product_keywords" value="{{ $product_keywords }}" required>
                    @error('product_keywords')
                        <span class="alert alert-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="category_id"> Category </label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <option value="">Select Categories</option>
                        @foreach($category as $list)                            
                            @if($category_id ==  $list->id)
                                <option value="{{ $list->id }}" selected>{{$list->categories_name}}</option>
                            @else
                                <option value="{{ $list->id }}">{{$list->categories_name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <!-- <input type="text"  value="{{ $category_id }}" > -->
                    @error('category_id')
                        <span class="alert alert-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="product_image"> Image </label>
                    <?php $isRequired = ($product_id > 0)?"":"required"; ?>
                    <input type="file" class="form-control" id="product_image" name="product_image" value="{{ $product_image }}" {{ $isRequired }}>
                    @error('product_image')
                        <span class="alert alert-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <input type="submit" class="btn btn-primary" value="Save">   <a href="/admin/coupon" class="btn btn-success">Back</a>
            </form>             
        </div>
    </div>
</div>
@endsection