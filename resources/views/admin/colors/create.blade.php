@extends('admin.layouts')
@section('title','Create Color')
@section('content')
 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- DataTales Example -->
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Colors</h6>                        
             {{ session('message') }} 
        </div>
        <div class="card-body">           
            <form class="user" action="{{ route('color.add') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">         
                            <input type="hidden" class="form-control" id="colors_id" name="colors_id" value="{{ $color_id }}">
                            <label for="colors_name"> Name </label>
                            <input type="text" class="form-control" id="colors_name" name="colors_name" value="{{ $color_name }}" required>
                            @error('colors_name')
                                <span class="alert alert-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>                  
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <input type="submit" class="btn btn-primary" value="Save">   
                        <a href="/admin/color" class="btn btn-success">Back</a>
                    </div>
                </div>
                
            </form>             
        </div>
    </div>
</div>
@endsection