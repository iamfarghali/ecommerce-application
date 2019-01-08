@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Banners</a> <a href="#" class="current">Delete banner</a>
    </div>
    <h1>Banners</h1>
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
            <h5>Delete Banner</h5>
            </div>
            <div class="widget-content">
                <div class="alert alert-danger">
                  <p> You'll Delete <b>{{$banner->title}}</b> Banner, Are You Sure ?</p>
                </div>
             </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="{{ route('admin.delete-banner', ['id' => $banner->id]) }}" name="delete_banner" id="delete_banner" novalidate="novalidate">
                {{csrf_field()}}
                <div class="form-actions">
                  <input type="submit" value="Delete banner" class="btn btn-success">
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