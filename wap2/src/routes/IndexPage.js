import { Button, Carousel, Flex, NavBar } from 'antd-mobile';
import { connect } from 'dva';
import React from 'react';
import { Link } from 'dva/router';

import MainLayout from 'components/MainLayout/MainLayout';
import globalModel from 'models/globalModel';
import globalStyles from 'styles/globalStyles';
import indexModel from 'models/indexModel';
import indexStyles from 'styles/indexStyles';
import util from 'utils/util';

class Page extends React.Component {
  constructor(props) {
    super(props);

    const {dispatch, location} = props
    console.log(location)
    this.state = {
      initialHeight: null,
      isWeiXinBrowser: util.isWeiXinBrowser(navigator.userAgent)
    };

    // 获取页面数据
    dispatch({type:'indexModel/getIndexPage'});
  }

  componentDidMount() {
    const {dispatch,location} = this.props
    const search = location.search
    dispatch({type:'globalModel/isLoggedIn', payload:{ search }});
  }

  render(){
    const hProp = this.state.initialHeight ? { height: this.state.initialHeight,width: '100%' } : {};

    const {channels, menus, carousels} = this.props.indexModel
    const {isLoggedIn} = this.props.globalModel
    const {isWeiXinBrowser} = this.state
    // 导航条右边按钮组
    let rightContent = []
    if (isLoggedIn) {
      rightContent.push(<Link key="1" to={{ pathname: '/my' }}>
            <Button  type="default" size="small">我的</Button>
          </Link>)
    } else{
      // 没有登录
      if(!isWeiXinBrowser) {
        rightContent.push(<Link key="1" to={{ pathname: '/register' }}>
            <Button type="default" size="small">注册</Button>
          </Link>)
      }
      rightContent.push(<Link key="2" to={{ pathname: '/login' }}>
            <Button type="default" size="small">登录</Button>
          </Link>)
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
        <style jsx global>{globalStyles}</style>
      </MainLayout>
    );
  }
}


export default connect(({indexModel,globalModel}) => ({indexModel,globalModel}))(Page);

