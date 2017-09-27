import {
  getChannelList,
} from 'services/indexService';

export default {

  namespace: 'example',

  state: {
    test:'1234'
  },

  subscriptions: {
    setup({ dispatch, history }) {  // eslint-disable-line
      // history.listen((location) => {
      //   console.log(1, location);
      // });
    },
  },

  effects: {
    *getChannelList({ }, { call, put }) {  // eslint-disable-line
      console.log('data')
      const data = yield call(getChannelList)
      console.log(data)
    },
  },

  reducers: {
    save(state, action) {
      return { ...state, ...action.payload };
    },
  },

};
