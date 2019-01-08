@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Banners</a> <a href="#" class="current">View Banners</a> </div>
    <h1>Banners</h1>
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
              <h5>View Banners</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                	@foreach ( $banners as $banner )
  	              	 <tr class="gradeC">
  	                  <td>{{$banner->id}}</td>
  	                  <td>{{$banner->title}}</td>
                      <td>{{$banner->link}}</td>
  	                  <td style="text-align: center">
                       <img src="{{asset('images/frontend_images/banners/'.$banner->image)}}" alt="{{$banner->title}}" width="80px"> 
                      </td>
  	                  <td style="text-align: center">
                        <a href="{{route('admin.edit-banner', ['id' => $banner->id]) }}" class="btn btn-info" title="Edit Banner"><i class="fa fa-pencil"></i></a>
  	                  	<a href="{{route('admin.delete-banner', ['id' => $banner->id])}}" class="btn btn-danger" title="Delete Banner"><i class="fa fa-close"></i></a>
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