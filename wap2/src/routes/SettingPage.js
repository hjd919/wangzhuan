import { Button, WhiteSpace } from 'antd-mobile';

import { connect } from 'dva';
import React from 'react';

import Header from 'components/MainLayout/Header';
import MainLayout from 'components/MainLayout/MainLayout';

import Base from 'routes/Base';

class Page extends Base {
	constructor(props) {
	    super(props)
  	}

  	logout(){
		const {dispatch} = this.props
		console.log('111')
		// 退出登录
  		dispatch({type:'loginModel/logout'})

      	this.toPage('/')
  	}

	render(){

		return (
	    	<MainLayout>
		        <Header 
		        leftContent={<div onClick={this.toPage.bind(this, "/my")}>返回</div>}
		        rightContent={[
	          		<Button key="1" onClick={this.toPage.bind(this,'/')} type="default" size="small">首页</Button>,
		        ]}/>

		       	<WhiteSpace/>
		        <Button onClick={this.logout.bind(this)} type="warning">退出登录</Button><WhiteSpace />

			</MainLayout>
		)
	}
}
export default connect(({loginModel,settingModel}) => ({loginModel,settingModel}))(Page);
