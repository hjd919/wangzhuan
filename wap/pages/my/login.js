import { Button, Carousel, Flex, NavBar } from 'antd-mobile';
import Link from 'next/link';
import React from 'react';

import Layout from 'components/Layout'
import dva from 'dva';
import exampleModel from 'models/example';
import globalStyles from 'styles/global';
import indexStyles from 'styles/index';

export default class Index extends React.Component {
  state = {
  }
  componentDidMount() {

  }
  render() {
    const app = dva();
    app.model(exampleModel);

    app.router(() => {
      return (
        <Layout>
          {/*导航条*/}
          <NavBar 
            mode="light"
            leftContent="万读2"
            iconName={<img src="https://img.wandu.cn/novel/icon/20170808/181854_5989900ee6abc.png" style={{width:28,height:28}} alt="万读"/>}
            rightContent={[
              <Link key="1" href={{ pathname: '/users', query: { name: 'Zeit' } }} passHref>
                <Button  type="default" size="small">注册2</Button>
              </Link>,
              <Link key="2" href={{ pathname: '/my/login' }} passHref>
                <Button type="default" size="small">登录2</Button>
              </Link>
            ]}
          ></NavBar>
          <style jsx>{indexStyles}</style>
          <style jsx global>{globalStyles}</style>
        </Layout>
      );
    });

    const Component = app.start();
    return (
      <Component />
    );
  }
}