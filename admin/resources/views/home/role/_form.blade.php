<form class="form-horizontal" method="post">

	{{csrf_field()}}

	 <div class="form-group">
	   <label for="role_name" class="col-sm-2 require">角色名</label>
	   <div class="col-sm-8">
	   	<input type="text" class="form-control" id="role_name"
	   	name="role_name"
	   	value="{{old('role_name') ? old('role_name') : isset($role)?$role->role_name:''}}" placeholder="请输入角色名" required>
	   </div>
	 </div>

	 <div class="form-group">
	   <label for="name" class="col-sm-2 require">英文简称</label>
	   <div class="col-sm-8">
	   	<input type="text" class="form-control" id="name"
	   	name="name"
	   	value="{{old('name') ? old('name') : isset($role)?$role->name:''}}" placeholder="请输入用户名" required>
	   </div>
	 </div>

	 <div class="form-group">
	   <label for="name" class="col-sm-2 require">权限</label>
	   <div class="col-sm-10">
			@foreach ($permissions->chunk(3) as $chunk)
			    <div class="row">
			        @foreach ($chunk as $permission)
			            <div class="col-md-4">
						<label class="checkbox-inline">
						  <input type="checkbox" name="permission_ids[]" value="{{$permission->id}}"
							{{isset($role_permissions) && $role_permissions->contains('id',$permission->id) ? 'checked' : ''}}
						  > {{$permission->readable_name}}
						</label>
			            </div>
			        @endforeach
			    </div>
			@endforeach
	   </div>
	 </div>

	 <div class="form-group">
	   <div class="col-sm-1 col-sm-offset-2">
	 	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> 提 交</button>
	   </div>
	   <div class="col-sm-1">
	 	<a href="{{url('home/role/index')}}" class="btn btn-default" id="returnBack"><span class="glyphicon glyphicon-arrow-left"></span> 返 回</a>
	   </div>
	 </div>
</form>
