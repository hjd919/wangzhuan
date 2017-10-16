import querystring from 'querystring';

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
      const search = querystring.parse(action.payload.search.replace('?',''))
      let isLoggedIn,api_token
      if(search.api_token){
        isLoggedIn = localStorage.isLoggedIn = true
        api_token = localStorage.api_token = search.api_token  
      }else{
        if(!localStorage.isLoggedIn){
          // 如果本地也没有token，则判断为没登录
          isLoggedIn = false
          api_token = ''
        }else{
          isLoggedIn = localStorage.isLoggedIn
          api_token = localStorage.api_token
        }  
      }

      return { ...state, isLoggedIn, api_token };
    },
  },

};
