@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Categories</a> <a href="#" class="current">View Categories</a> </div>
    <h1>Categories</h1>
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
              <h5>View Categories</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Category Parent</th>
                    <th>Category URL</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                	@foreach ( $categories as $category )
  	              	 <tr class="gradeC">
  	                  <td>{{$category->id}}</td>
  	                  <td>{{$category->name}}</td>
  	                  <td>{{getParentCategoryName($category->parent_id)}}</td>
  	                  <td>{{$category->url}}</td>
  	                  <td style="text-align: center" class="center">
                        <a href="{{route('admin.show-category', ['id' => $category->id])}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
  	                  	<a href="{{route('admin.edit-category', ['id' => $category->id])}}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
  	                  	<a href="{{route('admin.delete-category', ['id' => $category->id])}}" class="btn btn-danger"><i class="fa fa-close"></i></a>
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