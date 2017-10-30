import { Button, Carousel, Flex, NavBar } from 'antd-mobile';
import { Link } from 'dva/router';
import { connect } from 'dva';
import React from 'react';

import MainLayout from 'components/MainLayout/MainLayout';
import indexStyles from 'styles/indexStyles';
import util from 'utils/util';

import Base from 'routes/Base';

class Page extends Base {
  constructor(props) {
    super(props);

    this.state = {
      initialHeight: null,
      isWeiXinBrowser: util.isWeiXinBrowser(navigator.userAgent)
    };
  }

  componentDidMount() {
    const {dispatch, location} = this.props
    
    // 获取页面数据
    dispatch({type:'indexModel/getIndexPage'});

    // 判断是否需要重定向
    dispatch({type:'indexModel/isRedirect', payload:{search: location.search}});
  }

  render(){
    const hProp = this.state.initialHeight ? { height: this.state.initialHeight,width: '100%' } : {};

    const {channels, menus, carousels} = this.props.indexModel
    const {isLoggedIn} = this.props.loginModel
    const {isWeiXinBrowser} = this.state
    // 导航条右边按钮组
    let rightContent
    if (isLoggedIn) {
      rightContent = [<Button key="1" type="default" size="small" onClick={this.toPage.bind(this,'/my')}>我的</Button>]
    } else{
      // 没有登录
      if(!isWeiXinBrowser) {
        rightContent = [
          <Button key="1" type="default" onClick={this.toPage.bind(this, '/register')} size="small">注册</Button>,
          <Button key="2" type="default" onClick={this.toPage.bind(this, '/login')} size="small">登录</Button>
        ]
      }
    }

    return (
      <MainLayout>
        {/*top*/}
        <NavBar 
          mode="light"
          leftContent={<span style={{fontSize: "18px",color: '#ef3a3a'}}>万读</span>}
          iconName={<img src="https://img.wandu.cn/novel/icon/20170808/181854_5989900ee6abc.png" style={{width:28,height:28}} alt="万读"/>}
          rightContent={rightContent}
        ></NavBar>
        {/*菜单栏*/}
        <Flex className="nav">
          {
            channels.map((row,key) => {
              return (
                <Flex.Item className="nav-item" key={key}>
                <Link to={row.href ? row.href : `/channel/${row.id}`} className="nav-a">{row.channel_name}</Link>
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
            <a href={row.href} key={key}>
              <img
                src={row.image}
                alt={key}
              />
            </a>
          ))}
        </Carousel>
        {/*功能列表*/}
        <Flex className="func-list">
          {
            menus.map((row,key) => {
              return (
              <Flex.Item key={key}>
                  <a className="" href={row.href}>
                    <p className="func-p">
                      <img className="func-img" src={row.icon}/>
                    </p>
                    <p className="func-p">{row.menu_name}</p>
                  </a>
              </Flex.Item>
              )            
            })
          }
        </Flex>
        <style jsx>{indexStyles}</style>
      </MainLayout>
    );
  }
}


export default connect(({indexModel,loginModel}) => ({indexModel,loginModel}))(Page);

