import { Toast } from 'antd-mobile';
import { routerRedux } from 'dva/router';
import { delay } from 'dva/saga';
import {
  submitFeedback
} from 'services/feedbackService';

export default {

  namespace: 'feedbackModel',

  state: {
    helpinfo: {}
  },

  effects: {
    *submitFeedback({
      payload
    }, {
      take,
      call,
      put
    }) { // eslint-disable-line
      const data = yield call(submitFeedback, payload)
      const { error_code, message } = data
      if (!error_code) {
        Toast.success(message, 1)
        
        yield delay(1001);

        yield put(routerRedux.push('/my'));
      } else {
        Toast.fail(message, 3)
      }
      return data
    },
  },

  reducers: {
    getHelpPageSuccess(state, action) {
      return {...state,
        ...action.payload
      };
    },
  },

};