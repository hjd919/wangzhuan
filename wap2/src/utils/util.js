export default {
	isWeiXinBrowser: (ua) => {
		if(!ua){
			return false
		}
	    ua = ua.toLowerCase()
	    if (ua.match(/MicroMessenger/i) == 'micromessenger') {
	        return true;
	    } else {
	        return false;
	    }
	},
	registerModel: (app, model) => {
	  if (!(app._models.filter(m => m.namespace === model.namespace).length === 1)) {
	  	console.log('jiazaile!~!')
	    app.model(model)
	  } else {
	  	console.log('bu jiazaile!')
	  }
	  return app
	}
} 