import { Accordion, Button, List } from 'antd-mobile';

const Item = List.Item;
const Brief = Item.Brief;
import { Link } from 'dva/router';
import { connect } from 'dva';
import React from 'react';

import Header from 'components/MainLayout/Header';
import MainLayout from 'components/MainLayout/MainLayout';
// import globalStyles from 'styles/globalStyles';

class Page extends React.Component {
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
	        leftContent={<Link key="1" to="/my">返回</Link>}
	        rightContent={[
	          <Link key="1" to={{ pathname: '/' }}>
	            <Button type="default" size="small">首页</Button>
	          </Link>,
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
