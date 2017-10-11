import {
  loginByWechat,
} from 'services/loginService';

export default {

  namespace: 'globalModel',

  state: {
    isLoggedIn:false,
  },

  effects: {
    *loginByWechat({ }, { call, put }) {  // eslint-disable-line
      const data = yield call(loginByWechat)
      if (data.error_code == 0) {
        yield put({ type: 'getIndexPageSuccess', payload:data.data})
      }
    },
  },

  reducers: {
    isLoggedIn(state, action) {
      localStorage.isLoggedIn = action.payload.isLoggedIn
      localStorage.api_token = action.payload.api_token
      
      return { ...state, ...action.payload };
    },
  },

};
