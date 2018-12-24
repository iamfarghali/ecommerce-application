@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
     <a href="{{route('admin.show-categories')}}" title="Go to Categories" class="tip-bottom">
     	<i class="icon-home"></i>Categories
     </a>
     <a href="{{route('admin.show-category', ['id' => $category->id])}}" class="current">{{$category->name}}</a>
     </div>
  </div>
  <div class="container-fluid">
	    <div class="row-fluid">
	      <div class="span12">
	        <div class="widget-box">
	          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
	            <h5>{{$category->name}}</h5>
	          </div>
	          <div class="widget-content nopadding">
	            <table class="table table-bordered table-striped">
	              <thead>
	                <tr>
	                  <th>ID</th>
	                  <th>Name</th>
	                  <th>Parent Category</th>
	                  <th>Description</th>
	                  <th>URL</th>
	                  <th>Sub-Categories</th>
	                </tr>
	              </thead>
	              <tbody>
	                <tr class="odd gradeX">
	                  <td class="center">{{$category->id}}</td>
	                  <td>{{$category->name}}</td>
	                  <td>
	                  @if($category->parent_id != 0)
	                  	<a href="{{route('admin.show-category', ['id'=>$category->parent_id])}}">
	                  		{{getParentCategoryName($category->parent_id)}}
	                  	</a>
	                  @else
	                  	{{getParentCategoryName($category->parent_id)}}
	                  @endif
	                  </td>
	                  <td>{{$category->description}}</td>
	                  <td>{{$category->url}}</td>
	                  <td>
	                  	@if($subCategory != null)
	                  		<ul>
	                  			@foreach($subCategory as $cat)
	                  				<li><a href="{{route('admin.show-category', ['id'=>$cat->id])}}" >{{$cat->name}}</a></li>
	                  			@endforeach
	                  		</ul>
	                  	@else
	                  		<p>No Sub-Categories</p>
	                  	@endif
	                  </td>
	                </tr>
	              </tbody>
	            </table>
	          </div>
	        </div>
	      </div>
	    </div>
  </div>
</div>
@endsection