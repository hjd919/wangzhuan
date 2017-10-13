import { Button, NavBar } from 'antd-mobile';
import { connect } from 'dva';
import React from 'react';

import globalStyles from 'styles/globalStyles';
import loginModel from 'models/loginModel';
import loginStyles from 'styles/loginStyles';
import util from 'utils/util';
import { Link } from 'dva/router';

import LoginByPhone from './login/LoginByPhone';
import LoginByWechat from './login/LoginByWechat';
import MainLayout from 'components/MainLayout/MainLayout';

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
        <NavBar 
          mode="light"
          leftContent={<span style={{fontSize: "18px",color: '#ef3a3a'}}>万读</span>}
          iconName={<img src="https://img.wandu.cn/novel/icon/20170808/181854_5989900ee6abc.png" style={{width:28,height:28}} alt="万读"/>}
          rightContent={[
            <Link key="1" to={{ pathname: '/' }}>
              <Button type="default" size="small">首页</Button>
            </Link>,
          ]}
        ></NavBar>

        {this.state.isWeiXinBrowser ? <LoginByWechat/> : <LoginByPhone/>}

        <style jsx>{loginStyles}</style>
        <style jsx global>{globalStyles}</style>
      </MainLayout>
    );
  }
}

export default connect(({loginModel}) => ({loginModel}))(Page);