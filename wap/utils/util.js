export default {
	isWeiXinBrowser: (ua) => {
	    ua = ua.toLowerCase()
	    if (ua.match(/MicroMessenger/i) == 'micromessenger') {
	        return true;
	    } else {
	        return false;
	    }
	}
} 