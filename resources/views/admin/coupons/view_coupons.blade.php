@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Coupons</a> <a href="#" class="current">View Coupons</a> </div>
    <h1>Coupons</h1>
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
              <h5>View Coupons</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Coupon ID</th>
                    <th>Coupon Code</th>
                    <th>Amount</th>
                    <th>Amount Type</th>
                    <th>Created Date</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                	@foreach ( $coupons as $coupon )
  	              	 <tr class="gradeC">
  	                  <td>{{$coupon->id}}</td>
  	                  <td>{{$coupon->coupon_code}}</td>
                      <td>
                        {{$coupon->amount}} @if ($coupon->amount_type == 'Percentage') % @else USD @endif
                      </td> 
                      <td>{{$coupon->amount_type}}</td>
                      <td>{{$coupon->created_at}}</td>
                      <td>{{$coupon->expiry_date}}</td>
                      <td>
                        @if($coupon->status == 1) Active @else Inactive @endif
                      </td>

  	                  <td style="text-align: center">
                        <a href="#" class="btn btn-primary" title="Show Coupon"><i class="fa fa-eye"></i></a>
                        <a href="{{url('admin/edit-coupon/'.$coupon->id)}}" class="btn btn-info" title="Edit Coupon"><i class="fa fa-pencil"></i></a>
  	                  	<a href="{{url('admin/delete-coupon/'.$coupon->id)}}" class="btn btn-danger" title="Delete Coupon"><i class="fa fa-close"></i></a>
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