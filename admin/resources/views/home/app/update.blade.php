@extends('layouts/home')

{{-- 面包屑 --}}
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{url('/home/app/index')}}" id="breadcrumbList">应用列表</a></li>
  <li class="active">修改/复制 应用</li>
</ol>
@endsection

{{-- 内容 --}}
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">修改/复制 应用</div>
    <div class="panel-body">

    {{-- 表单 --}}
    @include('home/app/_form')

    </div>
</div>
@endsection

{{-- script --}}
@section('script')
<script>
	var breadcrumbListHref = document.getElementById('breadcrumbList').href
	if (localStorage.localSearch) {
		var returnBackUrl = breadcrumbListHref
		+ localStorage.localSearch
		document.getElementById('breadcrumbList').href = returnBackUrl
		document.getElementById('returnBack').href = returnBackUrl
	}

</script>
@endsection
