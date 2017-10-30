import { getTaskApps } from 'services/taskService';

import util from 'utils/util';

export default {

  namespace: 'taskModel',

  state: {
    taskApps: {
      now_apps: [],
      after_apps: [],
    },
  },

  subscriptions: {
    setup({ dispatch, history }) {  // eslint-disable-line
      history.listen((location) => {
      });
    },
  },

  effects: {
    *getTaskApps({ payload }, { call, put }) {  // eslint-disable-line
      const data = yield call(getTaskApps)
      if (data.error_code == 0) {
        let taskApps = data.data, row
        let now_apps = taskApps.now_apps
        // 格式化
        for (row of now_apps) {

          // 格式化钱
          row.price_user = util.formatToPrice(row.price_user)

          // 格式化标题
          row.title = '搜索:' + row.search_word
        }
        
        yield put({ type: 'getTaskAppsSuccess', payload:{taskApps:{now_apps}}})
      }
    },
  },

  reducers: {
    getTaskAppsSuccess(state, action) {
      return { ...state, ...action.payload };
    },
  },

};
