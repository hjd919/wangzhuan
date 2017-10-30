import { getUserinfo } from 'services/userService';

import util from 'utils/util';

export default {

  namespace: 'userModel',

  state: {
    userInfo: {},
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
        let userInfo = data.data.userInfo

        // 格式化金币
        userInfo.balance = util.formatToPrice(userInfo.balance)
        userInfo.today_income = util.formatToPrice(userInfo.today_income)
        userInfo.total_income = util.formatToPrice(userInfo.total_income)
        

        yield put({ type: 'getUserinfoSuccess', payload:{userInfo}})
      }
    },
  },

  reducers: {
    getUserinfoSuccess(state, action) {
      return { ...state, ...action.payload };
    },
  },

};
