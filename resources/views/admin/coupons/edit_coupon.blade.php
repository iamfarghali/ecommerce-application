@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Coupons</a> <a href="#" class="current">Edit Coupon</a>
    </div>
    <h1>Coupons</h1>
      @if(session()->has('success_message'))
        <br>
          <div class="alert alert-success fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <p>{{session()->get('success_message')}}</p>
          </div>
      @endif
  </div>
  <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Edit Coupon</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="{{ url('admin/edit-coupon') }}" name="edit_coupon" id="edit_coupon">
              	{{csrf_field()}}
                <input type="hidden" name="couponID" value="{{$coupon->id}}">
                <div class="control-group">
                  <label class="control-label">Coupon Code</label>
                  <div class="controls">
                    <input type="text" name="coupon_code" id="coupon_code" minlength="5" maxlength="15" value="{{$coupon->coupon_code}}" required>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Amount</label>
                  <div class="controls">
                    <input type="number" name="amount" id="amount" min="1" value="{{$coupon->amount}}" required>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Amount Type</label>
                  <div class="controls">
                    <select name="amount_type" id="amount_type">
                      <option value="Percentage" @if($coupon->amount_type == 'Percentage') selected @endif>Percentage</option>
                      <option value="Fixed"  @if($coupon->amount_type == 'Fixed') selected @endif>Fixed</option>
                    </select>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Expiry Date</label>
                  <div class="controls">
                    <input type="text" name="expiry_date" id="expiry_date" value="{{$coupon->expiry_date}}"  autocomplete="off" required>
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Enable Coupon</label>
                    <div class="controls">
                      <label>
                        <input type="checkbox" name="status" value="1"  @if($coupon->status == 1) checked @endif/>
                      </label>
                    </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Edit Coupon" class="btn btn-success">
                </div>
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
@endsection