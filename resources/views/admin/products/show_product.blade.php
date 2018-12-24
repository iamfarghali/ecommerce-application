@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
     <a href="{{route('admin.show-products')}}" title="Go to Products" class="tip-bottom">
     	<i class="icon-home"></i>Products
     </a>
     <a href="{{route('admin.show-product', ['id' => $product->id])}}" class="current">{{$product->product_name}}</a>
     </div>
  </div>
  <div class="container-fluid">
	    <div class="row-fluid">
	      <div class="span12">
	        <div class="widget-box">
	          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
	            <h5>{{$product->product_name}}</h5>
	          </div>
	          <div class="widget-content nopadding">
	            <table class="table table-bordered table-striped">
	              <thead>
	                <tr>
	                  <th>ID</th>
	                  <th>Name</th>
	                  <th>Category</th>
	                  <th>Price</th>
	                  <th>Color</th>
	                  <th>Code</th>
                    <th>Description</th>
	                  <th>Care</th>
	                  <th>Image</th>
	                </tr>
	              </thead>
	              <tbody>
	                <tr class="odd gradeX">
	                  <td class="center">{{$product->id}}</td>
	                  <td>{{$product->product_name}}</td>
	                  <td>{{$product->category_name}}</td>
	                   <td>{{$product->product_price}}</td>
	                   <td>{{$product->product_color}}</td>
	                   <td>{{$product->product_code}}</td>
                     <td>{{$product->product_description}}</td>
	                   <td>{{$product->care}}</td>
	                   <td>
	                   	<img src="{{asset('images/backend_images/products/sm/'.$product->product_image)}}" width="100" alt="{{$product->product_name}}">
	                   </td>
	                </tr>
	              </tbody>
	            </table>
	          </div>
	        </div>
          <a class="pull-right btn btn-primary" href="{{url('admin/add-attribute', $product->id)}}" > Add Attributes </a>
	      </div>
	    </div>
	          <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>View Attributes</h5>
            </div>
            <div class="widget-content nopadding">
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
  	                  <td>{{$attribute->id}}</td>
  	                  <td>{{$attribute->sku}}</td>
  	                  <td>{{$attribute->size}}</td>
  	                  <td>{{$attribute->price}}</td>
  	                  <td>{{$attribute->stock}}</td>
  	
  	                  <td style="text-align: center">
  	                  	<a href="{{url('admin/delete-attribute', $attribute->id)}}" class="btn btn-danger"><i class="fa fa-close"></i></a>
                        <a href="{{url('admin/edit-attribute', $attribute->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
  	                  </td>
  	                </tr>
                	@endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
@endsection