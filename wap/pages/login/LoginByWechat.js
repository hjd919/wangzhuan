import { Button, WhiteSpace, WingBlank } from 'antd-mobile';
import { connect } from 'dva-no-router';
import { createForm } from 'rc-form';
import React from 'react';

import globalStyles from 'styles/globalStyles';

class LoginByWechat extends React.Component {
  constructor(props) {
    super(props)

    this.state = {}
  }
  toLogin(e) {
    alert(111)
  }
  render(){
    const { loginModel, form } = this.props
    const { getFieldProps } = form;

    return (
        <div>
          <WhiteSpace />
            <img src="https://img.wandu.cn/novel/icon/20170808/181854_5989900ee6abc.png" className="image1" />
          <WhiteSpace />
          <WhiteSpace />
          <WingBlank>
            <Button type="primary" onClick={this.toLogin.bind(this)}>微信登录</Button>
          <WhiteSpace />
            <Button type="default">手机号快捷登录</Button>
          </WingBlank>
          <style jsx>{`
            .image1{
              width:40px;
              height:40px;
          `}</style>
          <style jsx global>{globalStyles}</style>
        </div>
    );
  }
}

export default connect(({loginModel}) => ({loginModel}))(createForm()(LoginByWechat))
