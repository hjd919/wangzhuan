@extends('layouts/home')

{{-- 面包屑 --}}
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{url('/home/config/index')}}">配置列表</a></li>
  <li class="active">添加配置</li>
</ol>
@endsection

{{-- 内容 --}}
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">添加配置</div>
    <div class="panel-body">
	    {{-- 表单 --}}
	    @include('home/config/_form')
    </div>
</div>
@endsection
