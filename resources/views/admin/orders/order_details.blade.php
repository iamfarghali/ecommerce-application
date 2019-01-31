@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="{{url('admin/')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    	<a href="{{url('admin/orders')}}">Orders</a> 
    	<a href="#" class="current"># {{$orderDetails->id}}</a> 
    </div>
    <h1>Order #{{$orderDetails->id}}</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
	    <div class="span6">
	        <div class="widget-box">
	          <div class="widget-title">
	            <h5>Order Details</h5>
	          </div>
	          <div class="widget-content nopadding">
	            <table class="table table-striped table-bordered">
	              <tbody>
	                <tr>
	                  <td>Order Date</td>
	                  <td>{{$orderDetails->created_at}}</td>
	                </tr>
	                <tr>
	                  <td>Order Total</td>
	                  <td>$ {{$orderDetails->grand_total}}</td>
	                </tr>
	                <tr>
	                  <td>Shipping Charges</td>
	                  <td>$ {{$orderDetails->shipping_charges}}</td>
	                </tr>
	                <tr>
	                  <td>Coupon Code</td>
	                  <td>{{$orderDetails->coupon_code}}</td>
	                </tr>
	                <tr>
	                  <td>Coupon Amount</td>
	                  <td>$ {{$orderDetails->coupon_amount}}</td>
	                </tr>
	                <tr>
	                  <td>Payment Method</td>
	                  <td>{{$orderDetails->payment_method}}</td>
	                </tr>
	              </tbody>
	            </table>
	          </div>
	        </div>

	        {{-- billing information --}}
	        <div class="widget-box">
	          <div class="widget-title"> 
	             <h5>Billing Address</h5>
	          </div>
	          <div class="widget-content nopadding">
	            <table class="table table-striped table-bordered">
	              <tbody>
	              	<tr><td> {{$userDetails->name}} </td> </tr>
	              	<tr><td> {{$userDetails->address}} </td> </tr>
	              	<tr><td> {{$userDetails->city}} </td> </tr>
	              	<tr><td> {{$userDetails->state}} </td> </tr>
	              	<tr><td> {{$userDetails->country}} </td> </tr>
	              	<tr><td> {{$userDetails->pincode}} </td> </tr>
	              	<tr><td> {{$userDetails->mobile}} </td> </tr>
	              </tbody>
	            </table>
	          </div>
	        </div>
	    </div>

	    <div class="span6">
	    	{{-- customer information --}}
	        <div class="widget-box">
	          <div class="widget-title">
	            <h5>Customer Details</h5>
	          </div>
	          <div class="widget-content nopadding">
	            <table class="table table-striped table-bordered">
	              <tbody>
	                <tr>
	                  <td>Customer Name</td>
	                  <td>{{$orderDetails->name}}</td>
	                </tr>
	                <tr>
	                  <td>Email</td>
	                  <td>{{$orderDetails->user_email}}</td>
	                </tr>
	              </tbody>
	            </table>
	          </div>
	        </div>

	        {{-- order status --}}
	        <div class="widget-box">
	          <div class="widget-title">
	            <h5>Update Order Status</h5>
	          </div>
	          <div class="widget-content nopadding">
	            <table class="table table-striped table-bordered">
	              <tbody>
	                <tr>
	                  <td>Coming Soon.</td>
	                </tr>
	              </tbody>
	            </table>
	          </div>
	        </div>

	        {{-- shipping information --}}
	        <div class="widget-box">
	          <div class="widget-title"> 
	             <h5>Shipping Address</h5>
	          </div>
	          <div class="widget-content nopadding">
	            <table class="table table-striped table-bordered">
	              <tbody>
	              	<tr><td> {{$orderDetails->name}} </td> </tr>
	              	<tr><td> {{$orderDetails->address}} </td> </tr>
	              	<tr><td> {{$orderDetails->city}} </td> </tr>
	              	<tr><td> {{$orderDetails->state}} </td> </tr>
	              	<tr><td> {{$orderDetails->country}} </td> </tr>
	              	<tr><td> {{$orderDetails->pincode}} </td> </tr>
	              	<tr><td> {{$orderDetails->mobile}} </td> </tr>
	              </tbody>
	            </table>
	          </div>
	        </div>
	    </div>

		<table id="example" class="table table-striped table-bordered" style="width:100%">
	        <thead>
	            <tr>
	                <th>Product Code</th>
	                <th>Product Name</th>
	                <th>Product Price</th>
	                <th>Product Size</th>
	                <th>Product Color</th>
	                <th>Product Quantity</th>
	            </tr>
	        </thead>
	        <tbody>
	        	@foreach($orderDetails->orders as $pro)
		            <tr>
		                <td>{{$pro->product_code}}</td>
		                <td>{{$pro->product_name}}</td>
		                <td>$ {{$pro->product_price}}</td>
		                <td>{{$pro->product_size}}</td>
		                <td>{{$pro->product_color}}</td>
		                <td>{{$pro->product_qty}}</td>
		            </tr>
	            @endforeach
	        </tbody>
	    </table>
    </div>
  </div>
</div>
@endsection