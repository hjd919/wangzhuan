import { Button } from 'antd-mobile';
import { Link } from 'dva/router';
import { connect } from 'dva';
import React from 'react';

import MainLayout from 'components/MainLayout/MainLayout';
import globalStyles from 'styles/globalStyles';
import loginModel from 'models/loginModel';
import loginStyles from 'styles/loginStyles';
import util from 'utils/util';

import Header from 'components/MainLayout/Header';
import LoginByPhone from './login/LoginByPhone';
import LoginByWechat from './login/LoginByWechat';

class Page extends React.Component {  

  constructor(props) {
    super(props)

    this.state = {
      isWeiXinBrowser: util.isWeiXinBrowser(navigator.userAgent)
    }
  }

  render(){
    const { loginModel } = this.props

    return (
      <MainLayout>
        {/*top*/}
        <Header rightContent={[
          <Link key="1" to={{ pathname: '/' }}>
            <Button type="default" size="small">首页</Button>
          </Link>,
        ]}/>

        {this.state.isWeiXinBrowser ? <LoginByWechat/> : <LoginByPhone/>}

        <style jsx>{loginStyles}</style>
        <style jsx global>{globalStyles}</style>
      </MainLayout>
    );
  }
}

export default connect(({loginModel}) => ({loginModel}))(Page);