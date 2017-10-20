@extends('layouts/home')

{{-- 面包屑 --}}
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{url('/home/user/index')}}">用户列表</a></li>
  <li class="active">添加用户</li>
</ol>
@endsection

{{-- 内容 --}}
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">添加用户</div>
    <div class="panel-body">
	    {{-- 表单 --}}
	    @include('home/user/_form')
    </div>
</div>
@endsection
