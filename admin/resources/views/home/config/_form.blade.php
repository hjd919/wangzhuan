	<form class="form-horizontal" method="post">

		{{csrf_field()}}
		 <div class="form-group">
		   <label for="配置名称" class="col-sm-2 require">配置名称</label>
		   <div class="col-sm-8">
		   	<input type="text" class="form-control" id="配置名称"
		   	name="Config[config_name]"
		   	value="{{old('Config')['config_name'] ? old('Config')['config_name']
		   	: isset($config) ? $config->config_name : ''}}" placeholder="请输入配置名称">
		   </div>
		 </div>
		 <div class="form-group">
		   <label for="value" class="col-sm-2 require">配置值</label>
		   <div class="col-sm-8">
			   	<textarea class="form-control" name="Config[value]" rows="3" id="value"
			   	placeholder="请输入配置值">{{old('Config')['value'] ? old('Config')['value']
			   	: isset($config) ? $config->value : ''}}</textarea>
		   </div>
		 </div>
		 <div class="form-group">
		   <label for="description" class="col-sm-2 require">配置含义</label>
		   <div class="col-sm-8">
		   	<input type="text" class="form-control" id="description"
		   	name="Config[description]" value="{{old('Config')['description'] ? old('Config')['description']
		   	: isset($config) ?  $config->description : ''}}"
		   	placeholder="请输入配置含义">
		   </div>
		 </div>
		 <div class="form-group">
		   <div class="col-sm-8 col-sm-offset-2">
		 	<button type="submit" class="btn btn-primary">提 交</button>
		   </div>
		 </div>
	</form>
