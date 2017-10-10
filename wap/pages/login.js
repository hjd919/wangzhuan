import { Button, NavBar } from 'antd-mobile';
import { connect } from 'dva-no-router';
import { createForm } from 'rc-form';
import Link from 'next/link';
import React from 'react';

import Layout from 'components/Layout'
import dva from 'dva';
import globalStyles from 'styles/globalStyles';
import loginModel from 'models/loginModel';
import loginStyles from 'styles/loginStyles';
import util from 'utils/util';

import LoginByPhone from './login/LoginByPhone';
import LoginByWechat from './login/LoginByWechat';

class Page extends React.Component {  

  constructor(props) {
    super(props)

    // console.log(navigator.userAgent)
    this.state = {
      isWeiXinBrowser: util.isWeiXinBrowser(props.userAgent)
    }
  }

  componentWillMount() {
  }

  render(){
    const { loginModel, form } = this.props
    const { getFieldProps } = form;

    return (
      <Layout>
        {/*top*/}
        <NavBar 
          mode="light"
          leftContent={<span style={{fontSize: "18px",color: '#ef3a3a'}}>万读</span>}
          iconName={<img src="https://img.wandu.cn/novel/icon/20170808/181854_5989900ee6abc.png" style={{width:28,height:28}} alt="万读"/>}
          rightContent={[
            <Link key="1" href={{ pathname: '/' }} passHref>
              <Button type="default" size="small">首页</Button>
            </Link>,
          ]}
        ></NavBar>

        {this.state.isWeiXinBrowser ? <LoginByWechat/> : <LoginByPhone/>}

        <style jsx>{loginStyles}</style>
        <style jsx global>{globalStyles}</style>
      </Layout>
    );
  }
}

Page = createForm()(Page)
Page = connect(({loginModel}) => ({loginModel}))(Page);


// export default () => {
//   const app = dva();
//   app.model(loginModel);
//   app.router(() => <Page/>);
//   const Component = app.start();
//   return (
//     <Component />
//   );
// }

const app = dva();
app.model(loginModel);

const LoginPage = (props) => {
  app.router(() => <Page {...props}/>);
  const Component = app.start();
  return (
    <Component />
  );
}
LoginPage.getInitialProps = async ({ req }) => {
    return req
      ? { userAgent: req.headers['user-agent'] }
      : { userAgent: navigator.userAgent }
}
export default LoginPage