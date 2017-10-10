import {
  loginByWechat,
} from 'services/loginService';

export default {

  namespace: 'loginModel',

  state: {
    channels:[],
    menus:[],
    carousels: [],
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
    getIndexPageSuccess(state, action) {
      return { ...state, ...action.payload };
    },
  },

};
