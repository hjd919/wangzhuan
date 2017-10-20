<form class="form-horizontal" method="post">

	{{csrf_field()}}

	 <div class="form-group">
	   <label for="username" class="col-sm-2 require">用户名</label>
	   <div class="col-sm-8">
	   	<input type="text" class="form-control" id="username"
	   	name="username"
	   	value="{{old('username') ? old('username') : ''}}" placeholder="请输入用户名" required>
	   </div>
	 </div>

	 <div class="form-group">
	   <label for="password" class="col-sm-2 require">密码</label>
	   <div class="col-sm-8">
	   	<input type="password" class="form-control" id="password"
	   	name="password" placeholder="请输入密码" required>
	   </div>
	 </div>

	{{-- TODO添加角色 --}}
	 <div class="form-group">
	   <label for="password_confirmation" class="col-sm-2 require">确认密码</label>
	   <div class="col-sm-8">
	   	<input type="password" class="form-control" id="password_confirmation"
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
