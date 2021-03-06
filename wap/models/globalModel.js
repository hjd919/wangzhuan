export default {

  namespace: 'globalModel',

  state: {
    isLoggedIn:false,
    api_token: '',
  },

  effects: {
    *loginByWechat({ }, { call, put }) {  // eslint-disable-line
   
    },
  },

  reducers: {
    isLoggedIn(state, action) {
      let isLoggedIn = action.payload.isLoggedIn
      let api_token = action.payload.api_token
      // 如果没有url的token，则判断本地是否存在有效token
      if (!isLoggedIn){
        if(!localStorage.isLoggedIn){
          isLoggedIn = false
          api_token = ''
        }else{
          isLoggedIn = localStorage.isLoggedIn
          api_token = localStorage.api_token
        }
      } else {
        localStorage.isLoggedIn = isLoggedIn
        localStorage.api_token = api_token        
      }

      return { ...state, isLoggedIn, api_token };
    },
  },

};
