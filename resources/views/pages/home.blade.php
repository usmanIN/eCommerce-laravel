@extends('layouts.master')
@section('title','Home')
@section('content')



<div class="container">
  <div class="d-flex justify-content-between">
    @foreach($products as $list)
      <div class="card">
        <img class="card-img-top img-thumbnail" src="{{ asset('storage/media/'.$list->product_image)}}" alt="{{$list->product_name}}">
        <div class="card-body">
          <h4 class="card-title">{{$list->product_name}}</h4>
          @if(isset($product_attributes[$list->id]))
            <p class="card-text">Rs {{ $product_attributes[$list->id][0]->Price }} <span class="text-danger"><del> {{ $product_attributes[$list->id][0]->MRP }} </del></span></p>
          @endif        
          <a href="/product/{{$list->product_slug}}" class="btn btn-primary">Click Here</a>
        </div>
      </div>
    @endforeach
  </div>
</div>  

@endsection

<pre>
<?php //print_r($product_attributes[$list->id][0]->MRP); ?>
  </pre>
  