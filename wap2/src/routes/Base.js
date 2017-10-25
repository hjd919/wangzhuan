import React from 'react';
import { routerRedux } from 'dva/router';

class Base extends React.Component {
	constructor(props) {
	  	super(props);

	    // // 绑定页面事件
	    // this.toPage = this.toPage.bind(this);
	}

  	toPage(uri) {
	    const {dispatch} = this.props
	    dispatch(routerRedux.push(uri))
  	}
}
export default Base;
