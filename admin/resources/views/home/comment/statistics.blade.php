@extends('layouts/home')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
    	刷评论统计-app名:{{$app_name}}
    </div>
    <div class="panel-body">
		{{-- 搜索 --}}
		<div class="rows clearfix">
			<div class="col-md-12">
				<form class="form-inline">

			  	  <div class="form-group">
				    <label for="appid">appid</label>
				    <input type="text" class="form-control" style="width:80px" id="appid" name="appid" placeholder="appid" value="{{$searchParams['appid']}}">
				  </div>

				  <div class="form-group">
				    <label for="status">状态</label>
					<label class="radio-inline">
					  <input type="radio" name="status" value=""
					  {{empty($searchParams['status']) ? 'checked' : ''}}
					  > 全部
					</label>
			    	@foreach ($comment->status as $key => $value)
					<label class="radio-inline">
					  <input type="radio" name="status" value="{{$key}}"
					  {{$searchParams['status'] === (string)$key ? 'checked' : ''}}
					  > {{$value}}
					</label>
					@endforeach
				  </div>

				  <button type="submit" class="btn btn-default">
				  	<span class="glyphicon glyphicon-search"></span> 搜索
				  </button>
				  &nbsp;&nbsp;

				</form>
			</div>
		</div>

		<hr/>
		{{-- 列表 --}}
		<div class="list table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="8%">日期</th>
						<th width="8%">appid</th>
						<th width="8%">名称</th>
						<th width="5%">状态</th>
						<th width="10%">评论数</th>
					</tr>
				</thead>
				<tbody id="list">
					@foreach ($statistics as $row)
					<tr>
						<td>{{$row->create_date}}</td>
						<td>{{$row->appid}}</td>
						<td>{{$row->app_name}}</td>
						<td>{{$comment->status($row->status)}}</td>
						<td>{{$row->comment_count}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="check_actions rows">
			<div class="col-md-4" style="display: flex;align-items: center;">
				{{$statistics->links()}}
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
