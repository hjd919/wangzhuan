import { Button } from 'antd-mobile';
import Link from 'next/link';
import React from 'react';

import HeadNavBar from 'components/HeadNavBar'
import Layout from 'components/Layout'
import dva,{connect} from 'dva';
import globalModel from 'models/globalModel';
import globalStyles from 'styles/globalStyles';
import indexStyles from 'styles/indexStyles';

import util from 'utils/util';

class Page extends React.Component {
  constructor(props) {
    super(props);
    console.log(props)
    const {dispatch} = props

    this.state = {
    };

  }

  render(){
    // const {isLoggedIn} = this.props.globalModel
    
    // 导航条右边按钮组
    let rightContent = [<Link key="1" href={{ pathname: '/' }} passHref>
            <Button  type="default" size="small">首页</Button>
          </Link>]

    return (
      <Layout>
        {/*top*/}
        <HeadNavBar rightContent={rightContent}/> 
        {/*菜单栏*/}
        <div>aaa</div>
        <style jsx>{indexStyles}</style>
        <style jsx global>{globalStyles}</style>
      </Layout>
    );
  }
}
Page = connect(({globalModel}) => ({globalModel}))(Page);

const MyPage = (props) => {
  let app = dva();
  app = util.registerModel(app,globalModel)
  app.router(() => <Page {...props}/>);
  const Component = app.start();
  return (
    <Component />
  );
}

export default MyPage
