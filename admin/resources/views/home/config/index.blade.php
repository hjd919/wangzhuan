@extends('layouts/home')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">配置管理</div>
    <div class="panel-body">
		{{-- 添加 --}}
		@shield('config.create')
		<p class="list-actions">
			<div class="btn-group">
				<a href="{{route('config.create')}}" class="btn btn-primary">添加配置</a>
			</div>
		</p>
		@endshield
		{{-- 列表 --}}
		<div class="list table-responsive">
			<table class="table table-bordered table-hover">
				<caption>配置列表</caption>
				<thead>
					<tr>
						<th width="5%">id</th>
						<th width="50">配置名称</th>
						<th width="5%">配置值</th>
						<th width="10%">配置含义</th>
						<th width="10%">创建时间</th>
						<th width="10%">最后修改</th>
						<th width="10%">操作</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($configs as $config)
					<tr>
						<td>{{$config->id}}</td>
						<td>{{$config->config_name}}</td>
						<td>{{$config->value}}</td>
						<td>{{$config->description}}</td>
						<td>{{$config->created_at}}</td>
						<td>{{$config->updated_at}}</td>
						<td>
							@shield('config.update')
							<a href="{{route('config.update',['id' => $config->id])}}">修改</a>
							@endshield
							{{-- <a href="{{url('home/config/delete',['id' => $config->id])}}" onclick="if(confirm('是否确定删除？')===false) return false;">删除</a> --}}
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="pull-right">
			{{$configs->links()}}
		</div>
    </div>
</div>
@endsection
