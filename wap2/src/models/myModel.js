import { getUserinfo } from 'services/myService';

export default {

  namespace: 'myModel',

  state: {
    userinfo: {},
  },

  subscriptions: {
    setup({ dispatch, history }) {  // eslint-disable-line
      history.listen((location) => {
      });
    },
  },

  effects: {
    *getUserinfo({ payload }, { call, put }) {  // eslint-disable-line
      const data = yield call(getUserinfo)
      if (data.error_code == 0) {
        yield put({ type: 'getUserinfoSuccess', payload:data.data})
      }
    },
  },

  reducers: {
    getUserinfoSuccess(state, action) {
      return { ...state, ...action.payload };
    },
  },

};
