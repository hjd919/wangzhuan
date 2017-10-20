@extends('layouts/home')

{{-- 面包屑 --}}
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{url('/home/user/index')}}">用户列表</a></li>
  <li class="active">修改密码</li>
</ol>
@endsection

{{-- 内容 --}}
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">修改密码</div>
    <div class="panel-body">
	    {{-- 表单 --}}
		<form class="form-horizontal" method="post">

			{{csrf_field()}}

			 <div class="form-group">
			   <label for="password" class="col-sm-2 require">新密码</label>
			   <div class="col-sm-8">
			   	<input type="password" class="form-control" id="password"
			   	name="password" placeholder="请输入新密码" required>
			   </div>
			 </div>

			 <div class="form-group">
			   <label for="passowrd_confirmation" class="col-sm-2 require">确认密码</label>
			   <div class="col-sm-8">
			   	<input type="password" class="form-control" id="passowrd_confirmation"
			   	name="password_confirmation" placeholder="请输入确认密码" required>
			   </div>
			 </div>

			 <div class="form-group">
			   <div class="col-sm-1 col-sm-offset-2">
			 	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> 提 交</button>
			   </div>
			   <div class="col-sm-1">
			 	<a href="{{url('home/user/index')}}" class="btn btn-default" id="returnBack"><span class="glyphicon glyphicon-arrow-left"></span> 返 回</a>
			   </div>
			 </div>
		</form>

    </div>
</div>
@endsection
