@extends('layouts/home')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
    	准备队列列表
    	<a href="{{route('app.index')}}" class="btn btn-default">&lt;返回应用列表</a>
    </div>
    <div class="panel-body">
    	<div class="rows">
			<p class="col-md-12">
				<form class="form-inline">

				  <div class="form-group">
				    最近3天
				  </div>

				  <div class="form-group">
				    <label for="app_name">应用名称</label>
				    <input type="text" class="form-control" id="app_name" name="app_name" value="{{isset($searchParams['app_name'])?$searchParams['app_name']:''}}">
				  </div>

				  <div class="form-group">
				    <label for="keyword">关键词</label>
				    <input type="text" class="form-control" id="keyword" name="keyword" value="{{isset($searchParams['keyword'])?$searchParams['keyword']:''}}">
				  </div>

				  <button type="submit" class="btn btn-default">
				  	<span class="glyphicon glyphicon-search"></span> 统计
				  </button>
				  &nbsp;&nbsp;
				  <a href="{{route('app.stat_brush')}}" class="btn btn-default">
				  	<span class="glyphicon glyphicon-refresh"></span> 重置
				  </a>
				</form>
			</p>
    	</div>
		{{-- 列表 --}}
		<div class="list table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="10%">apps表id</th>
						<th width="10%">应用名称</th>
						<th width="10%">关键词</th>
						<th width="10%">统计时间</th>
						<th width="10%">数量</th>
					</tr>
				</thead>
				<tbody id="list">
					@foreach ($stat_hour_brush_list as $row)
					<tr>
						<td>{{$row->app_id}}</td>
						<td>{{$row->app_name}}</td>
						<td>{{$row->keyword}}</td>
						<td>{{$row->hour_time}}时</td>
						<td>{{$row->total}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="check_actions rows">
			<div class="col-md-12" style="display: flex;align-items: center;justify-content: flex-end">
				{{$stat_hour_brush_list->appends($searchParams)->links()}}
			</div>
		</div>
    </div>
</div>
@endsection
