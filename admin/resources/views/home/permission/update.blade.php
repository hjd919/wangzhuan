@extends('layouts/home')

{{-- 面包屑 --}}
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{url('/home/permission/index')}}">权限列表</a></li>
  <li class="active">修改权限</li>
</ol>
@endsection

{{-- 内容 --}}
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">修改权限</div>
    <div class="panel-body">
	    {{-- 表单 --}}
	    @include('home/permission/_form')
    </div>
</div>
@endsection
