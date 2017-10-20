	<form class="form-horizontal" method="post">

		{{csrf_field()}}
		 <div class="form-group">
		   <label for="appid" class="col-sm-2 require">appid</label>
		   <div class="col-sm-8">
		   	<input type="number" class="form-control" id="appid"
		   	name="App[appid]"
		   	value="{{old('App')['appid'] ? old('App')['appid']
		   	: isset($app->appid) ? $app->appid : ''}}" placeholder="请输入appid">
		   </div>
		 </div>
		 <div class="form-group">
		   <label for="app_name" class="col-sm-2 require">应用名称</label>
		   <div class="col-sm-8">
		   	<input type="text" class="form-control" id="app_name"
		   	name="App[app_name]"
		   	value="{{old('App')['app_name'] ? old('App')['app_name']
		   	: isset($app->appid) ? $app->app_name : ''}}"
		   	placeholder="请输入应用名称">
		   </div>
		 </div>

		 <div class="form-group">
		   <label for="appuri" class="col-sm-2 require">下载链接</label>
		   <div class="col-sm-8">
		   	<input type="text" class="form-control" id="appuri"
		   	name="App[appuri]"
		   	value="{{old('App')['appuri'] ? old('App')['appuri']
		   	: isset($app->appid) ? $app->appuri : ''}}"
		   	placeholder="请输入下载链接">
		   </div>
		 </div>

		 <div class="form-group">
		   <label for="bundle_id" class="col-sm-2 require">bundle_id</label>
		   <div class="col-sm-8">
		   	<input type="text" class="form-control" id="bundle_id"
		   	name="App[bundle_id]" value="{{old('App')['bundle_id'] ? old('App')['bundle_id']
		   	: isset($app->appid) ? $app->bundle_id : ''}}"
		   	placeholder="请输入bundle_id">
		   </div>
		 </div>
		 <div class="form-group">
		   <label for="process_name" class="col-sm-2 require">进程名</label>
		   <div class="col-sm-8">
		   	<input type="text" class="form-control" id="process_name"
		   	name="App[process_name]" value="{{old('App')['process_name'] ? old('App')['process_name']
		   	: isset($app->appid) ?  $app->process_name : ''}}"
		   	placeholder="请输入进程名">
		   </div>
		 </div>

		 <div class="form-group">
		   <label for="ssid" class="col-sm-2 require">ssid</label>
		   <div class="col-sm-8">
			   	@foreach ($app->ssids as $ssid_val)
				<label class="checkbox-inline">
				  <input type="checkbox" name="App[ssid][]" value="{{$ssid_val}}"
				  {{isset($app->appid) && strpos($app->ssid, $ssid_val) > -1 ? 'checked' : ''}}
				  > {{$ssid_val}}
				</label>
				@endforeach
		   </div>
		 </div>

		 <div class="form-group">
		   <label for="keyword" class="col-sm-2 require">关键词</label>
		   <div class="col-sm-8">
		   	<input type="text" class="form-control" id="keyword"
		   	name="App[keyword]" value="{{old('App')['keyword'] ? old('App')['keyword']
		   	: isset($app->appid) ? $app->keyword : ''}}"
		   	placeholder="请输入关键词">
		   </div>
		 </div>

		 <div class="form-group">
		   <label for="ord" class="col-sm-2 require">优先级</label>
		   <div class="col-sm-8">
		   	<input type="number" min="1" max="999" class="form-control" id="ord"
		   	name="App[ord]" value="{{old('App')['ord'] ? old('App')['ord']
		   	: isset($app->appid) ? $app->ord : '999'}}"
		   	placeholder="请输入优先级，数字越小越高">
		   </div>
		 </div>

		 <div class="form-group">
		   <label for="brush_num" class="col-sm-2 require">刷下载总量</label>
		   <div class="col-sm-8">
		   	<input type="number" min="100" max="9999999" class="form-control" id="brush_num"
		   	name="App[brush_num]" value="{{old('App')['brush_num'] ? old('App')['brush_num']
		   	: isset($app->appid) ? $app->brush_num : ''}}"
		   	placeholder="请输入数量">
		   </div>
		 </div>

		 <input type="hidden" class="form-control" id="last_start_rank"
		   	name="App[last_start_rank]" value="{{old('App')['last_start_rank'] ? old('App')['last_start_rank']
		   	: isset($app->appid) ? $app->last_start_rank : '999'}}"
		   	placeholder="请输入关键词">
		 <div class="form-group">
		   <label for="is_brushing" class="col-sm-2 require">开始刷下载</label>
		   <div class="col-sm-8">
		   	@foreach ($app->is_brushing() as $key => $val)
			<label class="radio-inline">
			  <input type="radio" name="App[is_brushing]" value="{{$key}}"
			  {{isset($app->appid) && $app->is_brushing === $key ? 'checked' : ''}}
			  > {{$val}}
			</label>
			@endforeach
		   </div>
		 </div>

		 <div class="form-group">
		   <label for="changeip_type" class="col-sm-2 require">切换ip方式</label>
		   <div class="col-sm-8">
		   	@foreach ($app->changeIpTypes() as $key => $val)
			<label class="radio-inline">
			  <input type="radio" name="App[changeip_type]" value="{{$key}}"
			  {{$app->changeip_type === $key ? 'checked' : ''}}
			  > {{$val}}
			</label>
			@endforeach
		   </div>
		 </div>
		 <input type="hidden" class="form-control" id="last_changeip_num"
		   	name="App[last_changeip_num]" value="{{old('App')['last_changeip_num'] ? old('App')['last_changeip_num']
		   	: isset($app->appid) ? $app->last_changeip_num : '20'}}"
		   	placeholder="请输入关键词">

	 	<div class="form-group">
		   <label for="ord" class="col-sm-2 require">ip间隔量</label>
		   <div class="col-sm-8">
		   	<input type="number" min="1" max="999999" class="form-control" id="each_changeip_num"
		   	name="App[each_changeip_num]" value="{{old('App')['each_changeip_num'] ? old('App')['each_changeip_num']
		   	: isset($app->each_changeip_num) ? $app->each_changeip_num : '50'}}"
		   	placeholder="请输入ip间隔量">
		   </div>
		 </div>

	 	<div class="form-group">
		   <label for="ord" class="col-sm-2 require">评论剩余量</label>
		   <div class="col-sm-8">
		   	<input type="number" min="1" max="999999" class="form-control" id="comment_brush_num"
		   	name="App[comment_brush_num]" value="{{old('App')['comment_brush_num'] ? old('App')['comment_brush_num']
		   	: isset($app->comment_brush_num) ? $app->comment_brush_num : '500'}}"
		   	placeholder="请输入评论剩余量">
		   </div>
		 </div>

	 	<div class="form-group">
		   <label for="ord" class="col-sm-2 require">评论成功量</label>
		   <div class="col-sm-8">
		   	<input type="number" min="1" max="999999" class="form-control" id="success_comment_num"
		   	name="App[success_comment_num]" value="{{old('App')['success_comment_num'] ? old('App')['success_comment_num']
		   	: isset($app->success_comment_num) ? $app->success_comment_num : '500'}}"
		   	placeholder="请输入刷评论总量">
		   </div>
		 </div>

	 	<div class="form-group">
		   <label for="ord" class="col-sm-2 require">评论开始时间</label>
		   <div class="col-sm-8">
		   	<input type="text" class="form-control" id="comment_start_time"
		   	name="App[comment_start_time]" value="{{old('App')['comment_start_time'] ? old('App')['comment_start_time']
		   	: isset($app->comment_start_time) ?  $app->comment_start_time : date('Y-m-d H:i:s')}}"
		   	placeholder="请输入评论开始时间">
		   </div>
		 </div>

	 	<div class="form-group">
		   <label for="ord" class="col-sm-2 require">评论结束时间</label>
		   <div class="col-sm-8">
		   	<input type="text" class="form-control" id="comment_end_time"
		   	name="App[comment_end_time]" value="{{old('App')['comment_end_time'] ? old('App')['comment_end_time']
		   	: isset($app->appid) ?  $app->comment_end_time : date('Y-m-d H:i:s',strtotime('+1 days'))}}"
		   	placeholder="请输入评论结束时间">
		   </div>
		 </div>

		 <div class="form-group">
		   <label for="comment_is_brushing" class="col-sm-2 require">开始刷评论</label>
		   <div class="col-sm-8">
		   	@foreach ($app->is_brushing() as $key => $val)
			<label class="radio-inline">
			  <input type="radio" name="App[comment_is_brushing]" value="{{$key}}"
			  {{isset($app->appid) && $app->comment_is_brushing === $key ? 'checked' : ''}}
			  > {{$val}}
			</label>
			@endforeach
		   </div>
		 </div>

		 <div class="form-group">
		   <div class="col-sm-1 col-sm-offset-2">
		 	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> 提 交</button>
		   </div>
		   <div class="col-sm-1">
		 	<a href="{{url('home/app/index')}}" class="btn btn-default" id="returnBack"><span class="glyphicon glyphicon-arrow-left"></span> 返 回</a>
		   </div>
		 </div>
	</form>
