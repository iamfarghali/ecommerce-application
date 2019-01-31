@extends('layouts.frontLayout.front_design')
@section('content')
	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Thanks</li>
				</ol>
			</div>
		</div>
	</section>

	<section id="do_action">
		<div class="container">
			<div class="heading" align="center">
				<h3>Your COD order has been placed</h3>
				<p>Your order number is {{session()->get('order_id')}} and total payable about is $ {{session()->get('grand_total')}}</p>
			</div>
		</div>
	</section>
@endsection

<?php
session()->forget(['order_id', 'grand_total']);
?>