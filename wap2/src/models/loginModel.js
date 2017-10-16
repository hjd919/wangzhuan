import {
  loginByPhone,
} from 'services/loginService';
import querystring from 'querystring';

export default {

  namespace: 'loginModel',

  state: {
    isLoggedIn:false,
    api_token: '',
  },

  effects: {
    *loginByPhone({ payload }, { call, put }) {  // eslint-disable-line
      const data = yield call(loginByPhone, {...payload})
      if (data.error_code == 0) {
        yield put({ type: 'loginByPhoneSuccess', payload:data.data})

        const api_token = data.data.api_token
        location.href='/?api_token='+api_token
      }
    },
  },

  reducers: {
    loginByPhoneSuccess(state, action) {
      return { ...state, ...action.payload };
    },
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
