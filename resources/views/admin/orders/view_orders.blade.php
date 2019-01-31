@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Orders</a> <a href="#" class="current">View Orders</a> </div>
    <h1>Orders</h1>
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
              <h5>View Orders</h5>
            </div>
            <div class="widget-content nopadding">
              <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Ordered Products</th>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Order Amount</th>
                        <th>Order Status</th>
                        <th>Payment Method</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($orders as $order)
                      <tr>
                          <td class="center">{{$order->id}}</td>
                          <td class="center">{{$order->created_at}}</td>
                          <td class="center">
                            @foreach($order->orders as $pro)
                              <a href="{{url('/orders/'.$order->id)}}">{{$pro->product_code}}</a><br>
                            @endforeach
                          </td>
                          <td class="center">{{$order->name}}</td>
                          <td class="center">{{$order->user_email}}</td>
                          <td class="center">{{$order->grand_total}}</td>
                          <td class="center">{{$order->order_status}}</td>
                          <td class="center">{{$order->payment_method}}</td>
                          <td class="center">
                              <a target="_blank" href="{{url('/admin/view-order/'.$order->id)}}" class="btn btn-success btn-mini">View Details</a>
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