@extends('layouts/home')

{{-- 面包屑 --}}
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{url('/home/role/index')}}">角色列表</a></li>
  <li class="active">添加角色</li>
</ol>
@endsection

{{-- 内容 --}}
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">添加角色</div>
    <div class="panel-body">
	    {{-- 表单 --}}
	    @include('home/role/_form')
    </div>
</div>
@endsection
