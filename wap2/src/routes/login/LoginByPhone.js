import { Button, InputItem, List, WhiteSpace, WingBlank } from 'antd-mobile';
import { createForm } from 'rc-form';
import React from 'react';

import globalStyles from 'styles/globalStyles';
import loginStyles from 'styles/loginStyles';

class LoginByPhone extends React.Component {
  constructor(props) {
    super(props)

    this.state = {}

    this.getCode = this.getCode.bind(this)
  }
  componentDidMount() {
  }
  getCode(){
    console.log(1)
  }
  render(){
    const { loginModel, form } = this.props
    const { getFieldProps } = form;

    return (
        <div>
          <WhiteSpace />
          <List renderHeader={() => '手机号快捷登录'}>
            <InputItem
              {...getFieldProps('phone')}
              type="phone"
              placeholder="+86"
              clear
            >手机号</InputItem>
            <div className="" style={{position:'relative'}}>
              <InputItem
                {...getFieldProps('code')}
                type='number'
                placeholder=""
              >验证码</InputItem>
              <div className="code" onClick={this.getCode}>获取验证码</div>
            </div>
          </List>
          <WhiteSpace />
          <WhiteSpace />
          <WingBlank>
            <Button type="primary" disabled>登录</Button>
          </WingBlank>
          <style jsx>{loginStyles}</style>
          <style jsx global>{globalStyles}</style>
        </div>
    );
  }
}
export default createForm()(LoginByPhone)
