<form class="form-horizontal" method="post">

	{{csrf_field()}}

	 <div class="form-group">
	   <label for="name" class="col-sm-2 require">权限点</label>
	   <div class="col-sm-8">
	   	<input type="text" class="form-control" id="name"
	   	name="name"
	   	value="{{old('name') ? old('name') : isset($permission)?$permission->name:''}}" placeholder="请输入角色名" required>
	   </div>
	 </div>

	 <div class="form-group">
	   <label for="readable_name" class="col-sm-2 require">描述</label>
	   <div class="col-sm-8">
	   	<input type="text" class="form-control" id="readable_name"
	   	name="readable_name"
	   	value="{{old('readable_name') ? old('readable_name') : isset($permission)?$permission->readable_name:''}}" placeholder="请输入描述" required>
	   </div>
	 </div>

	 <div class="form-group">
	   <div class="col-sm-1 col-sm-offset-2">
	 	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> 提 交</button>
	   </div>
	   <div class="col-sm-1">
	 	<a href="{{url('home/permission/index')}}" class="btn btn-default" id="returnBack"><span class="glyphicon glyphicon-arrow-left"></span> 返 回</a>
	   </div>
	 </div>
</form>
