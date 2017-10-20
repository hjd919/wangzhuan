@extends('layouts/home')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
    	应用管理
    	@shield('app.ready_list')
    	<a href="{{route('app.ready_list')}}" class="btn btn-default">查看准备队列</a>
    	@endshield
    	<a href="{{route('app.stat_brush')}}" class="btn btn-default">刷任务统计</a>
    	<a href="{{route('comment.statistics')}}" class="btn btn-default">刷评论统计</a>
    </div>
    <div class="panel-body">
		{{-- 添加 --}}
		<div class="rows clearfix">
			<div class="col-md-2">
				@shield('app.create')
				<a href="{{route('app.create')}}" class="btn btn-primary">添加应用
				</a>
				@endshield


			</div>
			<div class="col-md-10">
				@shield('app.import')
				<form class="form-inline" action="{{route('app.import')}}" method="post" enctype="multipart/form-data">
					{{csrf_field()}}
				  <div class="form-group">
				    <label class="control-label">
				    	<a href="{{asset('storage/import/app.xlsx')}}" title="">下载导入模版</a>
				    </label>
				    <input type="file" class="form-control" name="file" id="file">
				  </div>
				  <button type="submit" class="btn btn-default">导入应用</button>
				</form>
				@endshield
			</div>
		</div>

		<hr/>

		{{-- 搜索 --}}
		<div class="rows clearfix">
			<div class="col-md-12">
				<form class="form-inline">

				  <div class="form-group">
				    <label for="id">id</label>
				    <input type="text" class="form-control" style="width:80px" id="id" name="id" placeholder="请输入id" value="{{$searchParams['id']}}">
				  </div>

				  <div class="form-group">
				    <label for="appid">appid</label>
				    <input type="text" class="form-control" id="appid" style="width:150px" name="appid" placeholder="请输入应用名" value="{{$searchParams['appid']}}">
				  </div>

				  <div class="form-group">
				    <label for="app_name">应用名</label>
				    <input type="text" class="form-control" id="app_name" style="width:150px" name="app_name" placeholder="请输入应用名" value="{{$searchParams['app_name']}}">
				  </div>

				  <div class="form-group">
				    <label for="keyword">关键词</label>
				    <input type="text" class="form-control" id="keyword" style="width:150px" name="keyword" placeholder="请输入关键词" value="{{$searchParams['keyword']}}">
				  </div>

				  <div class="form-group">
				    <label for="ssid">ssid</label>
				    <input type="text" class="form-control" id="ssid" style="width:100px" name="ssid" placeholder="请输入ssid" value="{{$searchParams['ssid']}}">
			    	{{-- @foreach ($app->ssids as $ssid_val)
					<label class="checkbox-inline">
					  <input type="checkbox" name="ssid[]" value="{{$ssid_val}}"
					  {{$ssid_val === $searchParams['ssid'] ? 'checked' : ''}}
					  > {{$ssid_val}}
					</label>
					@endforeach --}}
				  </div>

				  <div class="form-group">
				    <label for="ord">优先</label>
				    <input type="number" min="1" max="999" class="form-control" id="ord" style="width:80px" name="ord" placeholder="请输入优先" value="{{$searchParams['ord']}}">
				  </div>

				  <div class="form-group">
				    <label for="has_brush_num">数量大于0</label>
				    <input type="checkbox" name="has_brush_num" id="has_brush_num" value="1" {{$searchParams['has_brush_num'] ? 'checked' : ''}}>
				    {{-- <input type="number" min="0" max="999999" class="form-control" id="brush_num_over" style="width:80px" name="brush_num_over" placeholder="请输入优先" value="{{$searchParams['brush_num_over']}}"> --}}
				  </div>

				  <div class="form-group">
				    <label for="is_brushing">是否在刷</label>
			    	@foreach ($app->is_brushing() as $is_brushing_key => $is_brushing_val)
					<label class="radio-inline">
					  <input type="radio" name="is_brushing" value="{{$is_brushing_key}}"
					  {{$searchParams['is_brushing'] === (string)$is_brushing_key ? 'checked' : ''}}
					  > {{$is_brushing_val}}
					</label>
					@endforeach
				  </div>

				  <button type="submit" class="btn btn-default">
				  	<span class="glyphicon glyphicon-search"></span> 搜索
				  </button>
				  &nbsp;&nbsp;
				  <a href="{{url('home/app/index')}}" class="btn btn-default">
				  	<span class="glyphicon glyphicon-refresh"></span> 重置
				  </a>

				</form>
			</div>
		</div>

		<hr/>
		{{-- 列表 --}}
		<div class="list table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%" class="text-center">
							<input type="checkbox" name="selected[]" id="check_all" title="全选／反选"/>
						</th>
						<th width="10%">操作</th>
						<th width="15%">评论</th>
						<th width="5%">

							<a href="{{url()->current()}}?{{http_build_query($searchParams)}}&sort=id&order={{$sort_order == 'id|asc' ? 'desc' : 'asc'}}">id</a>
						</th>
						<th width="8%">appid</th>
						<th width="10%">应用名称</th>
						<th width="5%">
							<a href="{{url()->current()}}?{{http_build_query($searchParams)}}&sort_order=brush_num|{{$sort_order == 'brush_num|asc' ? 'desc' : 'asc'}}">下载数量</a>
						</th>
						<th width="5%">
							<a href="{{url()->current()}}?{{http_build_query($searchParams)}}&sort_order=comment_brush_num|{{$sort_order == 'comment_brush_num|asc' ? 'desc' : 'asc'}}">评论数量</a>
						</th>
						<th width="5%">

							<a href="{{url()->current()}}?{{http_build_query($searchParams)}}&sort_order=ord|{{$sort_order == 'ord|asc' ? 'desc' : 'asc'}}">优先</a>
						</th>
						<th width="5%">在刷下载</th>
						<th width="5%">在刷评论</th>
						<th width="5%">ssid</th>
						<th width="10%">创建时间</th>
						<!-- <th width="10%">
							<a href="{{url()->current()}}?{{http_build_query($searchParams)}}&sort_order=update_time|{{$sort_order == 'update_time|asc' ? 'desc' : 'asc'}}">最后修改</a>
						</th> -->
					</tr>
				</thead>
				<tbody id="list">
					@foreach ($apps as $app)
					<tr>
						<td class="text-center">
							<input type="checkbox" name="selected[]" class="multi_checkbox" value="{{$app->id}}"/>
						</td>
						<td>
    						@shield('app.update')
							<a href="{{route('app.update',[$app->id])}}"	onclick="saveSearch()"
							>修改</a>
							@endshield

    						@shield('app.copy')
							<a href="{{route('app.copy',[$app->id])}}" onclick="saveSearch()"
							>复制</a>
							@endshield

    						@shield('app.delete')
							<a href="{{route('app.delete',[$app->id])}}" onclick="if(confirm('是否确定删除？')===false) return false;">删除</a>
							@endshield
							<!--
							<br>
    						@shield('app.update_is_brushing')
							<a href="{{route('app.update_is_brushing',[1, $app->id])}}">
							加入队列
							</a>
							<a href="{{route('app.update_is_brushing',[0, $app->id])}}">
							停止刷
							</a>
							@endshield
						-->
						</td>
						<td>
							@shield('comment.index')
   							<a href="{{route('comment.index',[$app->id])}}" onclick="saveSearch()"
							>评论列表</a>
							@endshield

   							<a href="{{route('comment.statistics',['appid' => $app->appid])}}" onclick="saveSearch()"
							>评论统计</a>
							<br>
							评论库量({{$app->comment_total}})
							已评论数({{$app->commented_count}})
							可评论数({{$app->useful_count}})
						</td>
						<td>{{$app->id}}</td>
						<td>{{$app->appid}}</td>
						<td>{{$app->app_name}}</td>
						<td>{{$app->brush_num}}</td>
						<td>{{$app->comment_brush_num}}</td>
						<td>{{$app->ord}}</td>
						<td>{{$app->is_brushing($app->is_brushing)}}</td>
						<td>{{$app->is_brushing($app->comment_is_brushing)}}</td>
						<td>{{$app->ssid}}</td>
						<td>{{$app->create_time}}</td>
						<!-- <td>{{$app->update_time}}</td> -->
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="check_actions rows">
			<div class="col-md-8">
				<label>选中项：</label>
				<span class="mr10">
    				@shield('app.update_is_brushing')
					<a href="{{route('app.update_is_brushing',['is_brushing' => 1])}}" class="check_action">
					加入队列
					</a>
					&nbsp;&nbsp;
					<a href="{{route('app.update_is_brushing',['is_brushing' => 0])}}" class="check_action">
					停止刷
					</a>
					@endshield
				</span>
			</div>
			<div class="col-md-4" style="display: flex;align-items: center;">
				<span>总共{{$apps->total()}}条记录</span> &nbsp;
				{{$apps->appends(array_merge($searchParams,['sort_order' => $sort_order]))->links()}}
			</div>
		</div>
    </div>
</div>
@endsection

{{-- script --}}
@section('script')
<script>

</script>
@endsection
