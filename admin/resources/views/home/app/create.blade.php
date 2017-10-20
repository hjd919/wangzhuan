@extends('layouts/home')

{{-- 面包屑 --}}
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{url('/home/app/index')}}">应用列表</a></li>
  <li class="active">添加应用</li>
</ol>
@endsection

{{-- 内容 --}}
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">添加应用</div>
    <div class="panel-body">
	    {{-- 表单 --}}
	    @include('home/app/_form')
    </div>
</div>
@endsection
