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

      if (data && data.error_code == 0) {
        yield put({ type: 'loginByPhoneSuccess', payload:data.data})
      }
    },
    *isLoggedIn({ payload }, { call, put }) {
      const search = querystring.parse(payload.search.replace('?',''))
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
      console.log(isLoggedIn,'---',api_token)
      yield put({ type: 'isLoggedInSuccess', payload:{isLoggedIn, api_token}})
    },
  },

  reducers: {
    logout(state, action) {
      localStorage.isLoggedIn = false
      localStorage.api_token = ''      
      return { ...state, isLoggedIn:false, api_token: '' };
    },
    loginByPhoneSuccess(state, action) {
      localStorage.isLoggedIn = true
      localStorage.api_token = action.payload.api_token
      return { ...state, isLoggedIn: true, ...action.payload };
    },
    isLoggedInSuccess(state, action) {
      console.log(state,'---',action.payload)
      return { ...state, ...action.payload }
    },
  },

};
