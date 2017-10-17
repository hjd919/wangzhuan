import { submitFeedback } from 'services/feedbackService';

export default {

  namespace: 'feedbackModel',

  state: {
    helpinfo:{
    }
  },

  effects: {
    *submitFeedback({ payload }, { call, put }) {  // eslint-disable-line
      const data = yield call(submitFeedback, payload)
    },
  },

  reducers: {
    getHelpPageSuccess(state, action) {
      return { ...state, ...action.payload };
    },
  },

};
