@extends('admin.layouts');
@section('title','Coupons')
@section('content')


<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Coupons</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <h6 class="m-0 font-weight-bold text-primary">Categories</h6> -->
            
            <a href="coupon/create">
                <button class="btn btn-success">Add Coupons</button>
            </a>    
            {{ session('message') }} 
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Value</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Value</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>    
                        @foreach($data as $list)
                        <tr>
                            <th>{{$list->coupon_title}}</th>
                            <th>{{$list->coupon_code}}</th>      
                            <th>{{$list->coupon_value}}</th>      
                            <th>
                                <a href="coupon/create/{{ $list->id }}" class="btn btn-primary">Edit</a>
                                <a href="coupon/delete/{{ $list->id }}" class="btn btn-danger" >Delete</a>                     
                            </th>
                        </tr>
                        @endforeach                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End of Main Content -->
@endsection