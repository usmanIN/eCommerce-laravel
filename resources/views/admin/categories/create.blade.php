@extends('admin.layouts')
@section('title','Create Categories')
@section('content')
 <!-- Begin Page Content -->
 <div class="container-fluid">
    <!-- DataTales Example -->
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Categories</h6>                        
             {{ session('message') }} 
        </div>
        <div class="card-body">           
            <form class="user" action="{{ route('category.add') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">         
                            <input type="hidden" class="form-control" id="categories_id" name="categories_id" value="{{ $categories_id }}">
                            <label for="categories_name"> Name </label>
                            <input type="text" class="form-control" id="categories_name" name="categories_name" value="{{ $categories_name }}" required>
                            @error('categories_name')
                                <span class="alert alert-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="categories_slug"> Slug </label>
                            <input type="text" class="form-control" id="categories_slug" name="categories_slug" value="{{ $categories_slug }}" required>
                            @error('categories_slug')
                                <span class="alert alert-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                           <label for="category_parent"> Parent </label>
                           <select class="form-control" id="category_parent" name="category_parent" required>
                              <option value="">Select Categories</option>
                              @foreach($categories_list as $list)                            
                              @if($categories_parent ==  $list->id)
                              <option value="{{ $list->id }}" selected>{{$list->categories_name}}</option>
                              @else
                              <option value="{{ $list->id }}">{{$list->categories_name}}</option>
                              @endif
                              @endforeach
                           </select>
                  
                           @error('category_parent')
                           <span class="alert alert-danger"> {{ $message }} </span>
                           @enderror
                        </div>
                     </div>
                  
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <input type="submit" class="btn btn-primary" value="Save">   
                        <a href="/admin/category" class="btn btn-success">Back</a>
                    </div>
                </div>
                
            </form>             
        </div>
    </div>
</div>
@endsection