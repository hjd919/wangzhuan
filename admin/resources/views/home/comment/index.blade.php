@extends('layouts/home')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
    	评论管理--应用名：{{$app->app_name}}
    	<!-- 增加量和任务 -->
<!-- 		@shield('comment.import')
		<form class="form-inline" action="{{route('comment.import')}}" method="post" enctype="multipart/form-data">
			{{csrf_field()}}
		  <div class="form-group">
		    <label class="control-label">
		    	<a href="{{asset('storage/import/comment.xlsx')}}" title="">下载模版</a>
		    </label>
		    <input type="file" class="form-control" name="file" id="file">
		  </div>
		  <button type="submit" class="btn btn-default">导入评论</button>
		</form>
		@endshield -->
    	<!-- <a href="{{route('app.stat_brush')}}" class="btn btn-default">刷任务统计</a> -->
    </div>
    <div class="panel-body">
		{{-- 添加 --}}
		<div class="rows clearfix">
			<div class="col-md-10">
				@shield('comment.import')
				<form class="form-inline" action="{{route('comment.import')}}" method="post" enctype="multipart/form-data">
					{{csrf_field()}}
				  <div class="form-group">
				    <label class="control-label">
				    	<a href="{{asset('storage/import/comment.xlsx')}}" title="">下载模版</a>
				    </label>
				    <input type="file" class="form-control" name="file" id="file">
				    <input type="hidden" class="form-control" name="app_id" value="{{$app->id}}">
				  </div>
				  <button type="submit" class="btn btn-default">导入评论</button>
				</form>
				@endshield
			</div>
		</div>

		<hr/>
		{{-- 搜索 --}}

		<hr/>
		{{-- 列表 --}}
		<div class="list table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%" class="text-center">
							<input type="checkbox" name="selected[]" id="check_all" title="全选／反选"/>
						</th>
						<th width="5%">操作</th>
						<th width="5%">

							<a href="{{url()->current()}}?{{http_build_query($searchParams)}}&sort=id&order={{$sort_order == 'id|asc' ? 'desc' : 'asc'}}">id</a>
						</th>
						<th width="10%">标题</th>
						<th width="25%">内容</th>
						<th width="10%">创建时间</th>
						<th width="10%">
							<a href="{{url()->current()}}?{{http_build_query($searchParams)}}&sort_order=update_time|{{$sort_order == 'update_time|asc' ? 'desc' : 'asc'}}">最后修改</a>
						</th>
					</tr>
				</thead>
				<tbody id="list">
					@foreach ($comments as $row)
					<tr>
						<td class="text-center">
							<input type="checkbox" name="selected[]" class="multi_checkbox" value="{{$row->id}}"/>
						</td>
						<td>

						</td>
						<td>{{$row->id}}</td>
						<td>{{$row->title}}</td>
						<td>{{$row->content}}</td>
						<td>{{$row->created_at}}</td>
						<td>{{$row->updated_at}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="check_actions rows">
			<div class="col-md-8">

			</div>
			<div class="col-md-4" style="display: flex;align-items: center;">
				<span>总共{{$comments->total()}}条记录</span> &nbsp;
				{{$comments->appends(array_merge($searchParams,['sort_order' => $sort_order]))->links()}}
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
