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
	getIdfa: () => {
		return 'abcd'
	},
	formatToPrice: (amount) => {
		return Number(amount).toFixed(2);
	},
} 