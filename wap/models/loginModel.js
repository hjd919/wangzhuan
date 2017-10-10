import {
  getIndexPage,
} from 'services/indexService';

export default {

  namespace: 'loginModel',

  state: {
    channels:[],
    menus:[],
    carousels: [],
  },

  effects: {
    *getIndexPage({ }, { call, put }) {  // eslint-disable-line
      const data = yield call(getIndexPage)
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
