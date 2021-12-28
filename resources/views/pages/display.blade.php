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
                @foreach($products_attributes as $list)
                    <p class="products_attribute_price">
                        <label class="font-weight-bold">Price: </label>
                        <span class="text-danger">  <del>Rs {{$list->Price }} </del> </span><span class="text-success">Rs {{$list->Price }}</span> 
                    </p>
                @endforeach    
            @endif

            <p>
                <label class="font-weight-bold">Model: </label>
                <span class="text-success"> {{$products[0]->product_model }}</span>
            </p>
            <p>
                <label class="font-weight-bold">Description: </label>
                {{ $products[0]->product_short_description }}
            </p>                    
            <p>
                <div id="button_quantity">
                    <span class="btn btn-primary btn-sm" id="button_quantity_sub"> - </span>
                    <span class="btn btn-link btn-sm" id="button_quantity_text"> 1 </span>
                    <span class="btn btn-primary btn-sm" id="button_quantity_add"> + </span> 
                </div>   
            </p>
            <p><label class="font-weight-bold">Color: </label>
                <div class="d-flex justify-content-start">
                @foreach($products_attributes as $key => $list)                                            
                    <span class="p-3 mr-2 product_attribute_color" style="background-color:{{ strtolower($list->color_name) }};" onClick="produc_attribute_id('{{ $list->id }}','{{$key}}')"></span>                            
                @endforeach
                </div>
            </p>                
            <p>
                <label class="font-weight-bold">Categories: </label>
                <a  href="/categories/{{ $categories[0]->categories_slug }} " class="btn btn-link btn-sm">{{ $categories[0]->categories_name }} </a>
            </p>
            <p>
                <div id="message"></div>
            </p>
            <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm" onClick="add_to_cart()"> Add to Cart </a>
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
    <form id ="formCart">
        @csrf
        <input type="hidden" name="product_id" value="{{ $products[0]->id }}">
        <input type="hidden" name="product_quantity">
        <input type="hidden" name="product_attributes_id">
    </form>
@endsection

@section('footerContent')


<script type="text/javascript">


let formCart = document.getElementById("formCart").getElementsByTagName("input");        
    formCart[2].value = 1;

    let price = document.querySelectorAll(".products_attribute_price");
    price.forEach(element => {element.style.display = 'none';});
    price[0].style.display = 'block';

    // document.querySelectorAll(".product_attribute_color").forEach(function(element ,index){
    //     element.addEventListener("click",function(){
    //         price.forEach(element => { element.style.display = 'none'; });
    //         price[index].style.display = 'block';            
    //     });
    // });

    const produc_attribute_id = (id,key) =>{            
        price.forEach(element => { element.style.display = 'none'; });
        price[key].style.display = 'block';            
        formCart[3].value = id;
    }

    let button = document.getElementById("button_quantity").getElementsByTagName("span");        
    let quantity = 1;

        button[0].addEventListener("click",function(){
            quantity--;
            if(quantity < 1){ quantity = 1; }                    
            button[1].innerText = quantity;
            formCart[2].value = quantity;
        });

        button[2].addEventListener("click",function(){
            quantity++;
            if(quantity > 10){ quantity = 10; }                    
            button[1].innerText = quantity;
            formCart[2].value = quantity;                
        });

    function add_to_cart(){
       let  form = document.getElementById("formCart");
        if(formCart[3].value==''){
            $("#message").text('Select the Color');
        }else{
            $.ajax({
                url:'/cart_add',
                data: $('#formCart').serialize(),
                type: "post",
                success:function(response){
                    if(response.success){
                        $("#message").text(response.message);
                    }else{
                        $("#message").text(response.message);
                    }
                },
                error:function(response){
                    console.error(response);
                }
            });
        }

    }
</script>

@endsection
