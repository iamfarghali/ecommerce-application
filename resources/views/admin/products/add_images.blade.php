@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Add Images</a>
    </div>
    <h1>Add Images</h1>
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
              <h5>Add Product Images</h5>
            </div>
            <div class="widget-content nopadding">
              <form  enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('admin/add-images', $product->id) }}" name="add_iamges" id="add_images" >
              	{{csrf_field()}}
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <div class="control-group">
                  <label class="control-label"> Product Name </label>
                  <label class="control-label"> {{ucfirst($product->product_name)}} </label>
                </div>

                <div class="control-group">
                  <label class="control-label"> Image(s) </label>
                  <div class="controls">
                    <input type="file" name="product_image[]" multiple="multiple">
                  </div>
                </div>

                <div class="form-actions">
                  <input type="submit" value="Add Images" class="btn btn-success">
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
              <h5>View Images</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($productImages->count() > 0 )
                  	@foreach ( $productImages as $img )
    	              	 <tr class="gradeC">
    	                  <td>{{$img->id}}</td>
                        <td>{{ucfirst($product->product_name)}}</td>
    	                  <td style="text-align: center">
                          <img width="90px" height="90px" src="{{asset('images/backend_images/products/sm/'.$img->image)}}" alt="#"> 
                        </td>
    	                  <td style="text-align: center">
    	                  	<a href="{{url('admin/delete-alt-image/'.$img->id)}}" class="btn btn-danger"><i class="fa fa-close"></i></a>
    	                  </td>
    	                </tr>
                  	@endforeach
                  @else
                    <tr>
                      <td colspan="4" style="text-align: center">No images till now.</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</div>
@endsection
