// 获取idfa
import {
  Decrypt,
  Encrypt
} from 'utils/crypt';

const getIdfa = () => {
  return 'abcd'
}

export default {

  namespace: 'guideModel',

  state: {
    homeLink:'',
  },

  effects: { *fetch({
      payload
    }, {
      call,
      put
    }) { // eslint-disable-line
      yield put({
        type: 'save'
      });
    },
  },

  reducers: {
    setHomeLink(state, action) {
      const homeLink = '/?random=' + action.encryptStr
      return {...state, homeLink};
    },
  },

};