import { Button, Carousel, Flex, NavBar } from 'antd-mobile';
import Link from 'next/link';
import React from 'react';

import Layout from 'components/Layout'
import dva,{connect} from 'dva';
import indexModel from 'models/indexModel';

import globalStyles from 'styles/globalStyles';
import indexStyles from 'styles/indexStyles';

class Page extends React.Component {
  constructor(props) {
    super(props);
    console.log('constructor')
  
    this.state = {
      initialHeight: null,
    };
  }
  componentWillMount() {
    console.log('componentWillMount')
  }
  componentDidMount() {
    console.log('componentDidMount')
    // simulate img loading
    const {dispatch} = this.props
    dispatch({type:'indexModel/getIndexPage'});
  }
  componentWillReceiveProps(nextProps) {
    console.log('componentWillReceiveProps')
  }
  shouldComponentUpdate(nextProps, nextState) {
    console.log('shouldComponentUpdate')
    return true
  }
  componentWillUpdate(nextProps, nextState) {
    console.log('componentWillUpdate')
  }
  componentWillUnmount() {
    console.log('componentWillUnmount')
  }
  render(){
    const hProp = this.state.initialHeight ? { height: this.state.initialHeight,width: '100%' } : {};
    
    const {channels, menus, carousels} = this.props.indexModel

    return (
      <Layout>
        {/*top*/}
        <NavBar 
          mode="light"
          leftContent={<span style={{fontSize: "18px",color: '#ef3a3a'}}>万读</span>}
          iconName={<img src="https://img.wandu.cn/novel/icon/20170808/181854_5989900ee6abc.png" style={{width:28,height:28}} alt="万读"/>}
          rightContent={[
            <Link key="1" href={{ pathname: '/users', query: { name: 'Zeit' } }} passHref>
              <Button  type="default" size="small">注册</Button>
            </Link>,
            <Link key="2" href={{ pathname: '/login' }} passHref>
              <Button type="default" size="small">登录</Button>
            </Link>
          ]}
        ></NavBar>
        {/*菜单栏*/}
        <Flex className="nav">
          {
            channels.map((row,key) => {
              return (
                <Flex.Item className="nav-item" key={key}>
                  <Link href={row.href ? row.href : `/channel/${row.id}`}>
                    <a className="nav-a">{row.channel_name}</a>
                  </Link>
                </Flex.Item>
                )
            })
          }
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
          {carousels.map((row,key) => (
            <Link key={key} href={row.href}>
            <a>
              <img
                src={row.image}
                alt={key}
              />
            </a>
            </Link>
          ))}
        </Carousel>
        {/*功能列表*/}
        <Flex className="func-list">
          {
            menus.map((row,key) => {
              return (
              <Flex.Item key={key}>
                <Link href={row.href}>
                  <a className="">
                    <p className="func-p">
                      <img className="func-img" src={row.icon}/>
                    </p>
                    <p className="func-p">{row.menu_name}</p>
                  </a>
                </Link>
              </Flex.Item>
              )            
            })
          }
        </Flex>
        <style jsx>{indexStyles}</style>
        <style jsx global>{globalStyles}</style>
      </Layout>
    );
  }
}
Page = connect(({indexModel}) => ({indexModel}))(Page);

const app = dva();
app.model(indexModel);

export default () => {
  app.router(() => <Page/>);
  const Component = app.start();
  return (
    <Component />
  );
}
