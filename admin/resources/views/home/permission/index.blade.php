@extends('layouts/home')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
    	权限列表
    </div>
    <div class="panel-body">
		{{-- 添加、导入 --}}
		<div class="rows clearfix">
			<div class="col-md-12">
				<form class="form-inline" action="{{route('permission.import')}}" method="post" enctype="multipart/form-data">
					{{csrf_field()}}
				  <div class="form-group">
				    <label class="control-label">
				    	<a href="" title="">下载导入模版</a>
				    </label>
				    <input type="file" class="form-control" name="file" id="file">
				  </div>
				  <button type="submit" class="btn btn-default">导入权限</button>
					<a href="{{url('home/permission/create')}}" class="btn btn-primary">添加权限</a>
				</form>
			</div>
		</div>
		<hr/>
		{{-- 列表 --}}
		<div class="list table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="10%">操作</th>
						<th width="5%">id</th>
						<th width="10%">权限点</th>
						<th width="10%">描述</th>
						<th width="10%">创建时间</th>
						<th width="10%">修改时间</th>
					</tr>
				</thead>
				<tbody id="list">
					@foreach ($list as $row)
					<tr>
						<td>

							<a href="{{url('home/permission/update',[$row->id])}}"	onclick="saveSearch()"
							>修改</a>

							<a href="{{url('home/permission/delete',[$row->id])}}" onclick="if(confirm('是否确定删除？')===false) return false;">删除</a>

						</td>
						<td>{{$row->id}}</td>
						<td>{{$row->name}}</td>
						<td>{{$row->readable_name}}</td>
						<td>{{$row->created_at}}</td>
						<td>{{$row->updated_at}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="check_actions rows">
			<div class="col-md-4" style="display: flex;align-items: center;">
				<span>总共{{$list->total()}}条记录</span> &nbsp;
				{{$list->links()}}
			</div>
		</div>
    </div>
</div>
@endsection
