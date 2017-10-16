import querystring from 'querystring';

export default {

  namespace: 'helpModel',

  state: {
    helpinfo:{
    }
  },

  effects: {
    *getHelpPage({ }, { call, put }) {  // eslint-disable-line
      
    },
  },

  reducers: {
    getHelpPageSuccess(state, action) {
      return { ...state, ...action.payload };
    },
  },

};
