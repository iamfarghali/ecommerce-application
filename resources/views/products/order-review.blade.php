@extends('layouts.frontLayout.front_design')
@section('content')
	<section id="form" style="margin-top: 20px;">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{url('/')}}">Home</a></li>
				  <li class="active">Order Review</li>
				</ol>
			</div>
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form">
						<h2>Billing Detials</h2>
						<div class="form-group"> {{$user->name}} </div>
						<div class="form-group"> {{$user->address}} </div>
						<div class="form-group"> {{$user->city}} </div>
						<div class="form-group"> {{$user->state}} </div>
						<div class="form-group"> {{$user->country}} </div>
						<div class="form-group"> {{$user->pincode}} </div>
						<div class="form-group"> {{$user->mobile}} </div>
					</div>
				</div>
				<div class="col-sm-1">
					<h2></h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form">
						<h2>Shipping Details</h2>
						<div class="form-group"> {{$shippingAddress->name}} </div>
						<div class="form-group"> {{$shippingAddress->address}} </div>
						<div class="form-group"> {{$shippingAddress->city}} </div>
						<div class="form-group"> {{$shippingAddress->state}} </div>
						<div class="form-group"> {{$shippingAddress->country}} </div>
						<div class="form-group"> {{$shippingAddress->pincode}} </div>
						<div class="form-group"> {{$shippingAddress->mobile}} </div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
