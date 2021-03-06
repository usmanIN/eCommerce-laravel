@extends('admin.layouts')
@section('title','Colors')
@section('content')


<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Color</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <h6 class="m-0 font-weight-bold text-primary">color</h6> -->
            
            <a href="color/create">
                <button class="btn btn-success">Add Color</button>
            </a>    
            {{ session('message') }} 
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>    
                        @foreach($data as $list)
                        <tr>
                            <th>{{$list->color_name}}</th>
                            <th>
                                <a href="color/create/{{ $list->id }}" class="btn btn-primary">Edit</a>
                                @if($list->color_status == 1)
                                    <a href="color/status/0/{{ $list->id }}" class="btn btn-danger" >Activate</a>                     
                                @else    
                                   <a href="color/status/1/{{ $list->id }}" class="btn btn-danger" >Deactivate</a>                       
                                @endif
                                <a href="color/delete/{{ $list->id }}" class="btn btn-danger" >Delete</a>                     
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