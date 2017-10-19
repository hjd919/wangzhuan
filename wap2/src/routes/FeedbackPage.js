import { Button, List, TextareaItem, WhiteSpace, WingBlank } from 'antd-mobile';

const Item = List.Item;
const Brief = Item.Brief;
import { Link } from 'dva/router';
import { connect } from 'dva';
import React from 'react';
import { createForm } from 'rc-form';
import Header from 'components/MainLayout/Header';
import MainLayout from 'components/MainLayout/MainLayout';
import globalStyles from 'styles/globalStyles';

class Page extends React.Component {
  submit = () => {
  	const {form, dispatch} = this.props
    form.validateFields((error, value) => {
      dispatch({type:'feedbackModel/submitFeedback', payload:value})
    });
  }
  render(){
  	const { getFieldProps } = this.props.form;
  	return (
      	<MainLayout>
	        <Header 
	        leftContent={<Link key="1" to={{ pathname: '/my' }}>返回</Link>}
	        rightContent={[
	          <Link key="1" to={{ pathname: '/' }}>
	            <Button type="default" size="small">首页</Button>
	          </Link>,
	        ]}/>
	       	{/*手风琴*/}
	        <List renderHeader={() => '意见反馈'}>
	          <TextareaItem
	          	placeholder='说说吧，我的意见是...'
	            {...getFieldProps('feedback', {
	              rules: [{required: true}],
	            })}
	            rows={5}
	            count={100}
	          />
        	</List>
        	<WhiteSpace />
	        <WingBlank>
        		<Button type="primary" onClick={this.submit}>提 交</Button>
        	</WingBlank>
  		</MainLayout>
  	)
  }
}

export default connect(({feedbackModel}) => ({feedbackModel}))(createForm()(Page));
