@extends('layouts/home')

@section('content')
{{-- 列表 --}}
<div class="panel panel-default">
    <div class="panel-heading">appleid管理</div>
    <div class="panel-body">
		{{-- 搜索 --}}
		{{-- 列表 --}}
		<div class="list table-responsive">
			<table class="table table-bordered">
				<tbody id="list">
					<tr>
						<td class="active" width="150">可注册的email数</td>
						<td>{{$reg_count}}</td>
						<td class="active" width="150">可用的appleid数</td>
						<td>{{$appleid_count}}</td>
					</tr>
				</tbody>
			</table>
		</div>

		@shield('appleid.export_appleids')
		<hr/>

		<div class="rows clearfix">
			<div class="col-md-6">
				<form class="form-inline" action="{{route('appleid.export_appleids')}}">
				  <div class="form-group">
				    <label class="sr-only" for="export_num">export_num</label>
					<input type="number" class="form-control" name="export_num" id="export_num" value="" placeholder="导出数量" min="0" max="100000" />
				  </div>

				  <button type="submit" class="btn btn-default">导出appleids</button>
				</form>
			</div>
			<div class="col-md-6">
				已导出appleids统计：
				<span>{{$export_appleids}}</span>&nbsp;
			</div>
		</div>
		@endshield

		@shield('appleid.add_jishua_appleids')
		<hr/>

		{{-- 增加机刷appleid账号 --}}
		<div class="rows clearfix">
			<div class="col-md-6">
				<form class="form-inline" action="{{route('appleid.add_jishua_appleids')}}">

				  <div class="form-group">
				    <label class="sr-only" for="ssid">ssid</label>
					@foreach($app->ssids as $ssid)
						<label>
					  		<input type="radio" name="ssid" class="ssid" value="{{$ssid}}"> {{$ssid}}
					  	</label>
					@endforeach
				  </div>

				  <div class="form-group">
				    <label class="sr-only" for="add_number">增加数量</label>
					<input type="number" class="form-control" name="add_number" id="add_number" value="" placeholder="增加数量" min="0" max="100000" />
				  </div>

				  <button type="submit" class="btn btn-default">增加机刷appleid账号</button>
				</form>
			</div>
			<div class="col-md-6">
				机刷账号统计：
				@foreach($jishua_appleids as $ssid => $jishua_appleid)
				<span>{{$ssid}}--{{$jishua_appleid}}</span>&nbsp;
				@endforeach
			</div>
		</div>
		@endshield


		@shield('appleid.import_emails')
		<hr/>

		{{-- 导入邮箱 --}}
		<div class="rows clearfix">
			<div class="col-md-12">
				<form class="form-inline" action="{{route('appleid.import_emails')}}" method="post" enctype="multipart/form-data">
					{{csrf_field()}}
				<label class="control-label">
			    	<a href="{{asset('storage/import/appleid.xlsx')}}" title="">下载导入模版</a>
			    </label>
				  <div class="form-group">
				    <label for="email_file" class="control-label sr-only">请选择导入的email文件</label>
				    <input type="file" class="form-control" name="email_file" id="email_file" placeholder="Password">
				  </div>
				  <div class="form-group">
				    <label for="email_file" class="control-label sr-only">emails状态</label>
				  	<label class="radio-inline">
				  	  <input type="radio" name="is_valid" value="0"> 待注册
				  	</label>
				  	<label class="radio-inline">
				  	  <input type="radio" name="is_valid" value="200" checked="checked"> 评论
				  	</label>
				  </div>

				  <button type="submit" class="btn btn-default">导入appleid</button>
				</form>
			</div>
		</div>
		@endshield
		<hr/>
		{{-- 统计每个is_valid的状态 --}}
		<div class="rows">
			<p class="col-md-12">
				<form class="form-inline">

				  <div class="form-group">
				    最近7天
				  </div>
				  <div class="form-group">
				    <label for="is_valids">邮箱状态</label>
				    <input type="text" class="form-control" id="is_valids" name="is_valids" value="{{isset($searchParams['is_valids'])?$searchParams['is_valids']:''}}" placeholder="多个状态间用空格分割，如：1 2">
				  </div>

				  <div class="form-group">
				    <label for="is_valid">时间粒度</label>
			    	@foreach ($time_units as $time_unit)
					<label class="radio-inline">
					  <input type="radio" name="time_unit" value="{{$time_unit}}"
					  {{$searchParams['time_unit'] === $time_unit ? 'checked' : ''}}
					  > {{$time_unit}}
					</label>
					@endforeach
				  </div>

				  <button type="submit" class="btn btn-default">
				  	<span class="glyphicon glyphicon-search"></span> 统计
				  </button>
				  &nbsp;&nbsp;
				  <a href="{{route('appleid.index')}}" class="btn btn-default">
				  	<span class="glyphicon glyphicon-refresh"></span> 重置
				  </a>
				</form>
			</p>
		</div>
		<div class="rows clearfix">
			<div class="col-md-12">
				<div class="list table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th width="10%" title="0 未注册 1 注册成功 2待邮箱验证 3验证失败 4注册失败 70 原来6的">邮箱状态</th>
								<th width="15%">数量</th>
								<th width="10%">时间</th>
							</tr>
						</thead>
						<tbody id="list">
							@foreach ($stat_hour_email_list as $row)
							<tr>
								<td>{{$row->is_valid}}</td>
								<td>{{$row->total}}</td>
								<td>{{$row->hour_time}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-12 pagination-wrap">
				<span>总共{{$stat_hour_email_list->total()}}条记录</span> &nbsp;
				{{$stat_hour_email_list->appends($searchParams)->links()}}
			</div>
		</div>
	</div>
</div>
@endsection

{{-- script --}}
@section('script')
<script>
	// set location.search to localStorage; get from localStorage to index
	function saveSearch() {
		localStorage.localSearch = location.search
	}
</script>
@endsection
