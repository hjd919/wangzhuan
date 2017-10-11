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
	}
} 