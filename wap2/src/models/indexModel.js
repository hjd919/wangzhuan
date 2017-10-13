import { getIndexPage } from '../services/indexService';

export default {

  namespace: 'indexModel',

  state: {
    channels:[],
    menus:[],
    carousels: [],
  },

  subscriptions: {
    setup({ dispatch, history }) {  // eslint-disable-line
      // history.listen((location) => {
      //   console.log(1, location);
      // });
    },
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
