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
				<h3>Your order has been placed</h3>
				<p>Your order number is {{session()->get('order_id')}} and total payable about is $ {{session()->get('grand_total')}}</p>
				<p>Please make payment by clicking blow </p>
				<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
				  <!-- Saved buttons use the "secure click" command -->
				  <input type="hidden" name="cmd" value="_xclick">

	  			  <input type="hidden" name="business" value="mo7meda7med14-facilitator@gmail.com">

				  <input type="hidden" name="item_name" value="{{session()->get('order_id')}}">
				  <input type="hidden" name="currency_code" value="USD">
				  <input type="hidden" name="amount" value="{{session()->get('grand_total')}}">

				  <!-- Saved buttons display an appropriate button image. -->
				  <input type="image" name="submit"
				    src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
				    alt="PayPal - The safer, easier way to pay online">
				  <img alt="" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
				</form>
			</div>


		</div>
	</section>
@endsection

<?php
session()->forget(['order_id', 'grand_total']);
?>