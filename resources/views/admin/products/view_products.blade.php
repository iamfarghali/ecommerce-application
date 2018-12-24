@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Products</a> <a href="#" class="current">View Products</a> </div>
    <h1>Products</h1>
      @if(session()->has('success_message'))
	      <br>
	      <div class="alert alert-success fade in">
	          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	          <p>{{session()->get('success_message')}}</p>
	      </div>
      @endif
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>View Products</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Image</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                	@foreach ( $products as $product )
  	              	 <tr class="gradeC">
  	                  <td>{{$product->id}}</td>
  	                  <td>{{$product->product_name}}</td>
                      <td>{{$product->product_price}}</td>
  	                  <td style="text-align: center">
                       <img src="{{asset('images/backend_images/products/sm/'.$product->product_image)}}" alt="{{$product->product_name}}" width="80px"> 
                      </td>
  	                  <td style="text-align: center">
                        <a href="{{route('admin.show-product', ['id' => $product->id]) }}" class="btn btn-primary" title="Show Product"><i class="fa fa-eye"></i></a>
                        <a href="{{route('admin.edit-product', ['id' => $product->id]) }}" class="btn btn-info" title="Edit Product"><i class="fa fa-pencil"></i></a>
  	                  	<a href="{{route('admin.add-images', ['id' => $product->id]) }}" class="btn btn-success" title="Add Images"><i class="fa fa-plus"></i></a>
  	                  	<a href="{{route('admin.delete-product', ['id' => $product->id])}}" class="btn btn-danger" title="Delete Product"><i class="fa fa-close"></i></a>
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