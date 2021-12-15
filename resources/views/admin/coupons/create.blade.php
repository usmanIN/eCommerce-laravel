@extends('admin.layouts');
@section('title','Create Coupon')
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
            <form class="user" action="{{ route('coupon.add') }}" method="post">
                @csrf
                <div class="form-group">         
                <input type="hidden" class="form-control" id="coupon_id" name="coupon_id" value="{{ $coupon_id }}">
                <label for="coupon_title"> Name </label>
                    <input type="text" class="form-control" id="coupon_title" name="coupon_title" value="{{ $coupon_title }}" required>
                    @error('coupon_title')
                        <span class="alert alert-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="coupon_code"> Code </label>
                    <input type="text" class="form-control" id="coupon_code" name="coupon_code" value="{{ $coupon_code }}" required>
                    @error('coupon_code')
                        <span class="alert alert-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="coupon_value"> Value </label>
                    <input type="text" class="form-control" id="coupon_value" name="coupon_value" value="{{ $coupon_value }}" required>
                    @error('coupon_value')
                        <span class="alert alert-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <input type="submit" class="btn btn-primary" value="Save">   <a href="/admin/coupon" class="btn btn-success">Back</a>
            </form>             
        </div>
    </div>
</div>
@endsection