@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">{{$product->product_name}} Attributes</a>
    </div>
    <h1>{{ucfirst($product->product_name)}} Attributes</h1>
      @if(session()->has('success_message'))
        <br>
          <div class="alert alert-success fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <p>{{session()->get('success_message')}}</p>
          </div>
      @elseif(session()->has('error_message'))
        <br>
          <div class="alert alert-error fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <p>{{session()->get('error_message')}}</p>
          </div>
      @endif
  </div>
  <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Add Product Attributes</h5>
            </div>
            <div class="widget-content nopadding">
              <form  class="form-horizontal" method="post" action="{{ url('admin/add-attribute', $product->id) }}" name="add_attributes" id="add_attributes" >
              	{{csrf_field()}}
                <div class="control-group">
                  <label class="control-label"> Product Name </label>
                  <label class="control-label"><strong>{{$product->product_name}}</strong></label>
                </div>
         				<div class="control-group">
                  <label class="control-label"> Product Code </label>
                  <label class="control-label"><strong>{{$product->product_code}}</strong></label>
                </div>
                <div class="control-group">
                  <label class="control-label"> Product Color </label>
                  <label class="control-label"><strong>{{$product->product_color}}</strong></label>
                </div>
                <div class="control-group">
            			<div class="field_wrapper">
      					    <div  style="margin-left: 80px;">
      					        <input type="text" id ="sku" name="sku[]" value="" placeholder="SKU" required  />
      					        <input type="text" id ="size" name="size[]" value="" placeholder="Size"  required />
      					        <input type="text" id ="price" name="price[]" value="" placeholder="Price"  required />
      					        <input type="text" id ="stock" name="stock[]" value="" placeholder="Stock"  required />
      					        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
      					    </div>
        					</div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Add Attributes" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <hr>

      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>View Attributes</h5>
            </div>
            <div class="widget-content nopadding">
              <form  class="form-horizontal" method="post" action="{{ url('admin/edit-attribute') }}" name="edit_attributes" id="edit_attributes" >
                {{csrf_field()}}
                <table class="table table-bordered data-table">
                  <thead>
                    <tr>
                      <th>Attribute ID</th>
                      <th>SKU</th>
                      <th>Size</th>
                      <th>Price</th>
                      <th>Stock</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  	@foreach ( $product['attributes'] as $attribute )
    	              	 <tr class="gradeC">
    	                  <td><input type="hidden" name="attributeIDs[]" value="{{$attribute->id}}">{{$attribute->id}}</td>
    	                  <td>{{$attribute->sku}}</td>
    	                  <td>{{$attribute->size}}</td>
    	                  <td><input type="text" name="attributePrices[]" value="{{$attribute->price}}"></td>
    	                  <td><input type="text" name="attributeStocks[]" value="{{$attribute->stock}}"></td>
    	                  <td style="text-align: center">
                          <input type="submit" name="editAttribute" class="btn btn-primary" value="Edit">
                          <a href="{{url('admin/delete-attribute', $attribute->id)}}" class="btn btn-danger"><i class="fa fa-close"></i></a>
    	                  </td>
    	                </tr>
                  	@endforeach
                  </tbody>
                </table>
             </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
	$(document).ready(function(){
	    var maxField = 10; //Input fields increment limitation
	    var addButton = $('.add_button'); //Add button selector
	    var wrapper = $('.field_wrapper'); //Input field wrapper
	    var fieldHTML = `
	    			<div  style="margin-left: 80px; margin-top:5px">
				    	<input type="text" id ="sku" name="sku[]" value="" placeholder="SKU"  />
				        <input type="text" id ="size" name="size[]" value="" placeholder="Size" />
				        <input type="text" id ="price" name="price[]" value="" placeholder="Price" />
				        <input type="text" id ="stock" name="stock[]" value="" placeholder="Stock" />
				        <a href="javascript:void(0);" class="remove_button" title="Remove field">Remove</a>
				    </div>
				    `; //New input field html 

	    var x = 1; //Initial field counter is 1
	    
	    //Once add button is clicked
	    $(addButton).click(function(){
	        //Check maximum number of input fields
	        if(x < maxField){ 
	            x++; //Increment field counter
	            $(wrapper).append(fieldHTML); //Add field html
	        }
	    });
	    
	    //Once remove button is clicked
	    $(wrapper).on('click', '.remove_button', function(e){
	        e.preventDefault();
	        $(this).parent('div').remove(); //Remove field html
	        x--; //Decrement field counter
	    });
	});
</script>
@endsection