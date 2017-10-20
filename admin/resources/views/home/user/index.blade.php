@extends('layouts/home')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
    	用户列表
    </div>
    <div class="panel-body">
		{{-- 添加 --}}
		<div class="rows clearfix">
			<div class="col-md-12">
				<p class="btn-group pull-right">
					<a href="{{route('user.create')}}" class="btn btn-primary">添加用户
					</a>
				</p>
			</div>
		</div>
		{{-- 列表 --}}
		<div class="list table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="10%">操作</th>
						<th width="5%">id</th>
						<th width="10%">用户名</th>
						{{-- <th width="10%">邮箱</th> --}}
						<th width="10%">名字</th>
						<th width="10%">角色</th>
						<th width="10%">创建时间</th>
						<th width="10%">修改时间</th>
					</tr>
				</thead>
				<tbody id="list">
					@foreach ($list as $row)
					<tr>
						<td>

							<a href="{{route('user.attach_role',[$row->id])}}"	onclick="saveSearch()"
							>角色授予</a>

							<a href="{{route('user.update_password',[$row->id])}}"	onclick="saveSearch()"
							>修改密码</a>

							<a href="{{route('user.delete',[$row->id])}}" onclick="if(confirm('是否确定删除？')===false) return false;">删除</a>

						</td>
						<td>{{$row->id}}</td>
						<td>{{$row->username}}</td>
						{{-- <td>{{$row->email}}</td> --}}
						<td>{{$row->name}}</td>
						<td>
						@foreach ($row->roles->pluck('role_name') as $r_name)
						{{$r_name}}
						@endforeach
						</td>
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
