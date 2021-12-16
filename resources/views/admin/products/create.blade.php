@extends('admin.layouts')
@section('title','Create Product')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
   <!-- DataTales Example -->
   @if(session()->has('message'))
   <h1>  {{ session('message') }}   </h1>
   @endif
   <form class="user" action="{{ route('product.add') }}" method="post" enctype="multipart/form-data">
      @csrf            
      <div class="row">
         <div class="col-lg-6">
            <div class="card shadow mb-4">
               <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Product</h6>
               </div>
               <div class="card-body">
                  <div class="form-group">         
                     <input type="hidden" class="form-control" id="product_id" name="product_id" value="{{ $product_id }}">
                     <label for="product_name"> Name </label>
                     <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product_name }}" required>
                     @error('product_name')
                     <span class="alert alert-danger"> {{ $message }} </span>
                     @enderror
                  </div>
                  <div class="row">
                     <div class="col">
                        <div class="form-group">
                           <label for="product_brand"> Brand </label>
                           <input type="text" class="form-control" id="product_brand" name="product_brand" value="{{ $product_brand }}" required>
                           @error('product_code')
                           <span class="alert alert-danger"> {{ $message }} </span>
                           @enderror
                        </div>
                     </div>
                     <div class="col">
                        <div class="form-group">
                           <label for="product_model"> Model </label>
                           <input type="text" class="form-control" id="product_model" name="product_model" value="{{ $product_model }}" required>
                           @error('product_model')
                           <span class="alert alert-danger"> {{ $message }} </span>
                           @enderror
                        </div>
                     </div>
                     <div class="col">
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
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="product_image"> Image </label>
                     <?php $isRequired = ($product_id > 0)?"":"required"; ?>
                     <input type="file" class="form-control" id="product_image" name="product_image" value="{{ $product_image }}" {{ $isRequired }}>
                     @error('product_image')
                     <span class="alert alert-danger"> {{ $message }} </span>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="product_short_description"> Short Description </label>
                     <textarea class="form-control" id="product_short_description" name="product_short_description" required>{{ $product_short_description }}</textarea>
                     @error('product_short_description')
                     <span class="alert alert-danger"> {{ $message }} </span>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="product_description"> Desciption </label>
                     <textarea class="form-control" id="product_description" name="product_description" required>{{ $product_description }}</textarea>
                     @error('product_description')
                     <span class="alert alert-danger"> {{ $message }} </span>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="product_keywords"> Keywords </label>
                     <textarea class="form-control" id="product_keywords" name="product_keywords" required>{{ $product_keywords }}</textarea>
                     @error('product_keywords')
                     <span class="alert alert-danger"> {{ $message }} </span>
                     @enderror
                  </div>
                  <div class="form-group">
                     <div class="row">
                        <div class="col">
                           <input type="submit" class="btn btn-primary btn-block" value="Save">   
                        </div>
                        <div class="col">
                           <a href="/admin/coupon" class="btn btn-success btn-block">Back</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-6"  id="product_attribute">             
             @if(sizeof($product_attr_array)>0)
                @foreach($product_attr_array as $list)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class="col">
                                <h6 class="m-0 font-weight-bold text-primary">Product Attributes</h6>
                            </div>
                            <div class="col">                        
                                <span class="float-right btn btn-success btn-sm" onclick="addBox()"><i class="fas fa-plus"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                                <input type="hidden" value="{{ $list->id }}" name="product_attr_id[]" > 
                            <div class="row">
                                <div class="col">                            
                                <label for="product_attr_image">Image</labe>
                                <input type="file" class="form-control" id="product_attr_image" name="product_attr_image[]">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                <label for="product_attr_sku">SKU</labe>
                                <input type="text" class="form-control" id="product_attr_sku" name="product_attr_sku[]" value="{{ $list->SKU}}">
                                </div>
                                <div class="col">
                                <label for="product_attr_price">Price</labe>
                                <input type="text" class="form-control" id="product_attr_price" name="product_attr_price[]" value="{{ $list->Price}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                <label for="product_attr_qunatity">Quantity</labe>
                                <input type="text" class="form-control" id="product_attr_qunatity" name="product_attr_qunatity[]" value="{{ $list->Quantity}}">
                                </div>
                                <div class="col">
                                <label for="product_attr_mrp">MRP</labe>
                                <input type="text" class="form-control" id="product_attr_mrp" name="product_attr_mrp[]" value="{{ $list->MRP}}">                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else    
            <div class="card shadow mb-4">
               <div class="card-header py-3">
                  <div class="row">
                     <div class="col">
                        <h6 class="m-0 font-weight-bold text-primary">Product Attributes</h6>
                     </div>
                     <div class="col">                        
                        <span class="float-right btn btn-success btn-sm" onclick="addBox()"><i class="fas fa-plus"></i></span>
                     </div>
                  </div>
               </div>
               <div class="card-body">
                  <div class="form-group">
                     <div class="row">
                        <div class="col">                            
                           <label for="product_attr_image">Image</labe>
                           <input type="file" class="form-control" id="product_attr_image" name="product_attr_image[]">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col">
                           <label for="product_attr_sku">SKU</labe>
                           <input type="text" class="form-control" id="product_attr_sku" name="product_attr_sku[]">
                        </div>
                        <div class="col">
                           <label for="product_attr_price">Price</labe>
                           <input type="text" class="form-control" id="product_attr_price" name="product_attr_price[]">
                        </div>
                     </div>
                     <div class="row">
                        <div class="col">
                           <label for="product_attr_qunatity">Quantity</labe>
                           <input type="text" class="form-control" id="product_attr_qunatity" name="product_attr_qunatity[]">
                        </div>
                        <div class="col">
                           <label for="product_attr_mrp">MRP</labe>
                           <input type="text" class="form-control" id="product_attr_mrp" name="product_attr_mrp[]">                                
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endif
         </div>
      </div>
   </form>
</div>
@endsection

@section('footer')

<script type="text/javascript" >
    
    let product_box = document.getElementById("product_attribute").firstElementChild.cloneNode(true);    
    let parent = document.getElementById("product_attribute");
    function addBox(){
        let div = document.createElement("div");
        div.classList = "card shadow mb-4";
        button = product_box.children[0].getElementsByTagName("span")[0];
        button.setAttribute("onclick","removeBox(this)");
        button.className = "float-right btn btn-danger btn-sm";
        button.innerHTML = '<i class="fas fa-times"></i>' ;
        div.innerHTML = product_box.innerHTML;    
        parent.appendChild(div);
    }

function removeBox(element){
    element.parentNode.parentNode.parentNode.parentNode.remove();
}
    
</script>    
  

@endsection