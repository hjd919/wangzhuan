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
    data: ['', '', ''],
    initialHeight: 150,
  }
  componentDidMount() {


    // simulate img loading
    setTimeout(() => {
      this.setState({
        data: ['https://img.wandu.cn/novel/cover/2017-09-18/1D588CBF9EB43C029BEF817ABDD05FC7.jpg', 'https://img.wandu.cn/novel/cover/2017-09-04/3C0E72047CC4DC94629FBB273D3C02CD.jpg'],
      });
    }, 100);
  }
  render() {
    const app = dva();
    app.model(exampleModel);

    const hProp = this.state.initialHeight ? { height: this.state.initialHeight,width: '100%' } : {};

    app.router(() => {
      return (
        <Layout>
          {/*导航条*/}
          <NavBar 
            mode="light"
            leftContent="万读"
            iconName={<img src="https://img.wandu.cn/novel/icon/20170808/181854_5989900ee6abc.png" style={{width:28,height:28}} alt="万读"/>}
            rightContent={[
              <Link key="1" href={{ pathname: '/users', query: { name: 'Zeit' } }} passHref>
                <Button  type="default" size="small">注册</Button>
              </Link>,
              <Link key="2" href={{ pathname: '/my/login' }} passHref>
                <Button type="default" size="small">登录</Button>
              </Link>
            ]}
          ></NavBar>
          {/*菜单栏*/}
          <Flex className="nav">
            <Flex.Item className="nav-item">
              <Link href={{ pathname: '/users', query: { name: 'Zeit' } }}>
                <a className="nav-a">注册</a>
              </Link>
            </Flex.Item>
            <Flex.Item className="nav-item">
              <Link href={{ pathname: '/users', query: { name: 'Zeit' } }}>
                <a className="nav-a">注册</a>
              </Link>
            </Flex.Item>
            <Flex.Item className="nav-item">
              <Link href={{ pathname: '/users', query: { name: 'Zeit' } }}>
                <a className="nav-a">注册</a>
              </Link>
            </Flex.Item>
          </Flex>
          {/*轮播图*/}
          <Carousel
            className="my-carousel"
            autoplay={false}
            infinite
            selectedIndex={1}
            swipeSpeed={35}
            beforeChange={(from, to) => console.log(`slide from ${from} to ${to}`)}
            afterChange={index => console.log('slide to', index)}
          >
            {this.state.data.map((ii,key) => (
              <Link href="http://www.baidu.com">
              <a key={key} style={hProp}>
                <img
                  src={`${ii}`}
                  alt=""
                  onLoad={() => {
                    console.log('aaa')
                    // // fire window resize event to change height
                    // window.dispatchEvent(new Event('resize'));
                    // this.setState({
                    //   initialHeight: null,
                    // });
                  }}
                />
              </a>
              </Link>
            ))}
          </Carousel>
          {/*功能列表*/}
          <Flex className="func-list">
            <Flex.Item>
              <Link href={{ pathname: '/users', query: { name: 'Zeit' } }}>
                <a className="">
                  <p className="func-p">
                    <img className="func-img" src="http://ac.mhxzkhl.com/public/images/signin.png"/>
                  </p>
                  <p className="func-p">签到</p>
                </a>
              </Link>
            </Flex.Item>
            <Flex.Item>
              <Link href={{ pathname: '/users', query: { name: 'Zeit' } }}>
                <a className="">
                  <p className="func-p">
                    <img className="func-img" src="http://ac.mhxzkhl.com/public/images/signin.png"/>
                  </p>
                  <p className="func-p">签到</p>
                </a>
              </Link>
            </Flex.Item>
            <Flex.Item>
              <Link href={{ pathname: '/users', query: { name: 'Zeit' } }}>
                <a className="">
                  <p className="func-p">
                    <img className="func-img" src="http://ac.mhxzkhl.com/public/images/signin.png"/>
                  </p>
                  <p className="func-p">签到</p>
                </a>
              </Link>
            </Flex.Item>
          </Flex>
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