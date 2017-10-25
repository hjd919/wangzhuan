import { Accordion, Button, List } from 'antd-mobile';

import { routerRedux } from 'dva/router';

const Item = List.Item;
const Brief = Item.Brief;
import { Link } from 'dva/router';
import { connect } from 'dva';
import React from 'react';

import Header from 'components/MainLayout/Header';
import MainLayout from 'components/MainLayout/MainLayout';

import Base from 'routes/Base';

class Page extends Base {
	constructor(props) {
	    super(props)
	    const {dispatch} = props
	    // 获取页面数据
	    dispatch({type:'helpModel/getUserinfo'});
  	}

	render(){
		const {helpinfo} = this.props.helpModel
		
		return (
	    	<MainLayout>
		        <Header 
		        leftContent={<div onClick={this.toPage.bind(this, "/my")}>返回</div>}
		        rightContent={[
	          		<Button key="1" onClick={this.toPage.bind(this,'/')} type="default" size="small">首页</Button>,
		        ]}/>
		       	{/*手风琴*/}
		        <Accordion defaultActiveKey="0" className="my-accordion" onChange={this.onChange}>
		          <Accordion.Panel header="Title 1">
		            <List className="my-list">
		              <List.Item>Content 1</List.Item>
		              <List.Item>Content 2</List.Item>
		              <List.Item>Content 3</List.Item>
		            </List>
		          </Accordion.Panel>
		          <Accordion.Panel header="Title 2" className="pad">this is panel content2 or other</Accordion.Panel>
		          <Accordion.Panel header="Title 3" className="pad">
		            Text text text text text text text text text text text text text text text
		          </Accordion.Panel>
		        </Accordion>
			</MainLayout>
		)
	}
}
export default connect(({helpModel}) => ({helpModel}))(Page);
