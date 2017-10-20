@extends('layouts/home')

{{-- 面包屑 --}}
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{url('/home/user/index')}}">用户列表</a></li>
  <li class="active">修改用户的角色</li>
</ol>
@endsection

{{-- 内容 --}}
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">修改用户的角色</div>
    <div class="panel-body">
	    {{-- 表单 --}}
		<form class="form-horizontal" method="post">

			{{csrf_field()}}

			<div class="form-group">
			  <label for="ssid" class="col-sm-2 require">角色</label>
			  <div class="col-sm-8">
				   	@foreach ($roles as $role)
					<label class="checkbox-inline">
					  <input type="checkbox" name="role_ids[]" value="{{$role->id}}"
					  {{isset($user_roles) && in_array($role->id,$user_roles) ? 'checked' : ''}}
					  > {{$role->role_name}}
					</label>
					@endforeach
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
