@extends('layouts/home')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
    	准备队列列表
    	<a href="{{route('app.index')}}" class="btn btn-default">&lt;返回应用列表</a>
    </div>
    <div class="panel-body">
		{{-- 列表 --}}
		<div class="list table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">id</th>
						<th width="10%">app表id</th>
						<th width="10%">app名称</th>
						<th width="10%">app关键词</th>
						<th width="10%">app数量</th>
						<th width="15%">ssid</th>
						<th width="10%">优先级</th>
						<th width="10%">创建时间</th>
					</tr>
				</thead>
				<tbody id="list">
					@foreach ($rows as $row)
					<tr>
						<td>{{$row->id}}</td>
						<td>{{$row->app_id}}</td>
						<td>{{$row->app->app_name}}</td>
						<td>{{$row->app->keyword}}</td>
						<td>{{$row->app->brush_num}}</td>
						<td>{{$row->ssid}}</td>
						<td>{{$row->ord}}</td>
						<td>{{$row->created_at}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="check_actions rows">
			<div class="col-md-4" style="display: flex;align-items: center;">
				<span>总共{{$rows->total()}}条记录</span> &nbsp;
				{{$rows->links()}}
			</div>
		</div>
    </div>
</div>
@endsection
