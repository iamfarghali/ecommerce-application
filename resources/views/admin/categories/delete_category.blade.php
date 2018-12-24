@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Categories</a> <a href="#" class="current">Delete Category</a>
    </div>
    <h1>Categories</h1>
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
            <div class="widget-title"> <span class="icon"> <i class="icon-list"></i> </span>
            <h5>Delete Category</h5>
            </div>
            <div class="widget-content">
                <div class="alert alert-danger">
                  <p> You'll Delete <b>{{$currentCategoryData->name}}</b> Category, Are You Sure ?</p>
                </div>
             </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="{{ route('admin.delete-category', ['id' => $currentCategoryData->id]) }}" name="delete_category" id="delete_category" novalidate="novalidate">
                {{csrf_field()}}
                <div class="form-actions">
                  <input type="submit" value="Delete Category" class="btn btn-success">
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