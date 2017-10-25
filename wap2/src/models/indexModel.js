import { getIndexPage } from '../services/indexService';
import { routerRedux } from 'dva/router';
import querystring from 'querystring';

export default {

  namespace: 'indexModel',

  state: {
    channels:[],
    menus:[],
    carousels: [],
  },

  subscriptions: {
    setup({ dispatch, history }) {  // eslint-disable-line

    },
  },

  effects: {
    *getIndexPage({ }, { call, put }) {  // eslint-disable-line
      const data = yield call(getIndexPage)
      if (data.error_code == 0) {
        yield put({ type: 'getIndexPageSuccess', payload:data.data})
      }
    },
    // 微信登录 重定向
    *isRedirect({ payload }, { call, put }) {
      const search = querystring.parse(payload.search.replace('?',''))
      if(search.redirect){
        const redirect = decodeURIComponent(search.redirect)
        yield put(routerRedux.push(redirect))
      }
    },
  },

  reducers: {
    getIndexPageSuccess(state, action) {
      return { ...state, ...action.payload };
    },
  },

};
