@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Users</a> <a href="#" class="current">View Users</a> </div>
    <h1>Users</h1>
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
              <h5>View Users</h5>
            </div>
            <div class="widget-content nopadding">
              <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Counrty</th>
                        <th>Mobile</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                      <tr>
                          <td class="center">{{$user->id}}</td>
                          <td class="center">{{$user->name}}</td>
                          <td class="center">{{$user->email}}</td>
                          <td class="center">{{$user->address}}</td>
                          <td class="center">{{$user->city}}</td>
                          <td class="center">{{$user->country}}</td>
                          <td class="center">{{$user->mobile}}</td>
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