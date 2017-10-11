import { Button, Carousel, Flex, NavBar } from 'antd-mobile';
import Link from 'next/link';
import React from 'react';
import url from 'url';

import Layout from 'components/Layout'
import dva,{connect} from 'dva';
import globalStyles from 'styles/globalStyles';
import indexModel from 'models/indexModel';
import globalModel from 'models/globalModel';
import indexStyles from 'styles/indexStyles';
import util from 'utils/util';

class Page extends React.Component {
  constructor(props) {
    super(props);
    console.log(props)

    const {dispatch} = props
      
    this.state = {
      initialHeight: null,
      isWeiXinBrowser: util.isWeiXinBrowser(props.userAgent)
    };

    // 判断是否登录
    dispatch({type:'indexModel/getIndexPage'});
  }

  componentDidMount() {
    const {dispatch,isLoggedIn,api_token} = this.props

    dispatch({type:'globalModel/isLoggedIn', payload:{isLoggedIn,api_token}});
  }

  render(){
    console.log('render')
    const hProp = this.state.initialHeight ? { height: this.state.initialHeight,width: '100%' } : {};
    
    const {channels, menus, carousels} = this.props.indexModel
    const {isLoggedIn} = this.props.globalModel
    const {isWeiXinBrowser} = this.state
    
    // 导航条右边按钮组
    let rightContent = []
    if (isLoggedIn) {
      rightContent.push(<Link key="1" href={{ pathname: '/user' }} passHref>
            <Button  type="default" size="small">我的</Button>
          </Link>)
    } else{
      // 没有登录
      if(!isWeiXinBrowser) {
        rightContent.push(<Link key="1" href={{ pathname: '/register' }} passHref>
            <Button  type="default" size="small">注册</Button>
          </Link>)
      }
      rightContent.push(<Link key="2" href={{ pathname: '/login' }} passHref>
            <Button type="default" size="small">登录</Button>
          </Link>)
    }

    return (
      <Layout>
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
Page = connect(({indexModel,globalModel}) => ({indexModel,globalModel}))(Page);

const app = dva();
app.model(indexModel);
app.model(globalModel);

const IndexPage = (props) => {
  app.router(() => <Page {...props}/>);
  const Component = app.start();
  return (
    <Component />
  );
}
IndexPage.getInitialProps = async ({ req }) => {
  const initProps = {
    api_token: '',
    isLoggedIn: false,
  }
  if(req){
    // 判断是否登录
    var urlParse = url.parse(req.url, true);
    if(urlParse.query.api_token){
      initProps.isLoggedIn = true
      initProps.api_token = urlParse.query.api_token
    }

    // ua
    initProps.userAgent = req.headers['user-agent']
  } else {
    // ua
    initProps.userAgent = navigator.userAgent
  }

  return initProps
}

export default IndexPage
