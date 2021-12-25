@extends('layouts.master')
@section('title',$products[0]->product_name)
@section('content')

 <div class="container">
    <div class="row">
        <div class="col-4">
            <div class="row">
                <div class="col-lg-12">
                    <img src="{{ asset('storage/media/'.$products[0]->product_image)}}" alt="{{$products[0]->product_name}}" class="img-thumbnail" style="width:100%; border:none;">
                </div>
                @if(isset($products_extra_images))
                <div class="col-lg-12">
                    <div class="d-flex">                        
                        @foreach($products_extra_images as $list)
                            <div class="pr-2 pt-2">
                                <img src="{{ asset('storage/media/'.$list->product_images) }}" class="img-thumbnail" style="width:100px; border:none;"/>
                            </div>
                        @endforeach                        
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="col-8">
            <h3>{{ $products[0]->product_name }} </h3>
            <hr/>
            @if(isset($products_attributes))
            <p>
                <label class="font-weight-bold">Price: </label>
                <span class="text-danger">  <del>Rs {{$products_attributes[0]->Price }} </del> </span><span class="text-success">Rs {{$products_attributes[0]->Price }}</span> 
            </p>
            @endif
            <p>
                <label class="font-weight-bold">Model: </label>
                <span class="text-success"> {{$products[0]->product_model }}</span>
            </p>
            <p>
                <label class="font-weight-bold">Description: </label>
                {{ $products[0]->product_short_description }}
            </p>                    
            @if(isset($colors))
            <p><label class="font-weight-bold">Color: </label>
                <div class="d-flex justify-content-start">
                @foreach($products_attributes as $key => $list)                        
                    @foreach($colors as $value)
                        @if($value[$key]->id==$list->color)
                            <a href="javscript:void(0)" class="p-3" style="background-color:{{ strtolower($value[$key]->color_name) }};"></a>                            
                        @endif    
                    @endforeach                    
                @endforeach
                </div>
            </p>    
            @endif                
            <p>
                <label class="font-weight-bold">Categories: </label>
                <a  href="/categories/{{ $categories[0]->categories_slug }} " class="btn btn-link btn-sm">{{ $categories[0]->categories_name }} </a>
            </p>
            <a  href="#" class="btn btn-outline-primary btn-sm"> Add to Cart </a>
        </div>
    </div>           
    <p>
        <h6 class="font-weight-bold">Full Description: </h6>
        {{ $products[0]->product_description }}
    </p>
</div>  
<p></p><p></p>
@if(isset($related_products))
<div class="container">
    <h5>Related Product</h5>
    <hr/>
    <div class="d-flex justify-content-start">
        @foreach($related_products as $list)
            @if($list->id!=$products[0]->id)
                <div class="mr-2 card">
                    <div class="card-body">
                        <p>{{ $list->product_name }}</p>
                        <a href="/product/{{$list->product_slug}}" class="btn btn-primary btn-sm btn-block">Click Here</a>
                    </div>
                </div>
            @endif    

        @endforeach
    </div>
</div>
@endif
@endsection
