@extends('admin.layouts')
@section('title','Create Brands')
@section('content')
 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- DataTales Example -->
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">brands</h6>                        
             {{ session('message') }} 
        </div>
        <div class="card-body">           
            <form class="user" action="{{ route('brand.add') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">         
                <input type="hidden" class="form-control" id="brands_id" name="brands_id" value="{{ $brands_id }}">
                <label for="brands_name"> Name </label>
                    <input type="text" class="form-control" id="brands_name" name="brands_name" value="{{ $brands_name }}" required>
                    @error('brands_name')
                        <span class="alert alert-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="brands_slug"> Image </label>
                    <input type="file" class="form-control" id="brands_image" name="brands_image">
                
                    @error('brands_image')
                        <span class="alert alert-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <input type="submit" class="btn btn-primary" value="Save">   <a href="/admin/brand" class="btn btn-success">Back</a>
            </form>             
        </div>
    </div>
</div>
@endsection