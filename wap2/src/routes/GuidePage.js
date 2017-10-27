import { Button, Carousel, List, WhiteSpace, WingBlank } from 'antd-mobile';
import { connect } from 'dva';
import React from 'react';

import { Encrypt } from 'utils/crypt';
import Base from 'routes/Base';
import MainLayout from 'components/MainLayout/MainLayout';

import util from 'utils/util';

const Item = List.Item;
const Brief = Item.Brief;

class Page extends Base {

  constructor(props) {
    super(props);
  }

  componentWillMount() {
    // 获取idfa，生成加密链接,跳转safari
    const idfa = util.getIdfa()

    const encryptStr = Encrypt({
      idfa: idfa
    })

    const {dispatch} = this.props

    dispatch({'type':'guideModel/setHomeLink', encryptStr})
  }

  toHome() {
    const {homeLink} = this.props.guideModel
    this.toPage(homeLink)
  }

  render(){
    const {homeLink} = this.props.guideModel

    return (
      <MainLayout>
        <WingBlank>
          <Carousel className="my-carousel"
            vertical
            dots={false}
            dragging={false}
            swiping={false}
            autoplay
            infinite
          >
            <Item  className="v-item" extra="10:30" align="top" thumb="https://zos.alipayobjects.com/rmsportal/dNuvNrtqUztHCwM.png" multipleLine>
              Title <Brief>subtitle</Brief>
            </Item>
            <Item  className="v-item" extra="10:30" align="top" thumb="https://zos.alipayobjects.com/rmsportal/dNuvNrtqUztHCwM.png" multipleLine>
              Title <Brief>subtitle</Brief>
            </Item>            
            <Item  className="v-item" extra="10:30" align="top" thumb="https://zos.alipayobjects.com/rmsportal/dNuvNrtqUztHCwM.png" multipleLine>
              Title <Brief>subtitle</Brief>
            </Item>
          </Carousel>
        </WingBlank>
        <WhiteSpace />
        <Button type="primary" onClick={this.toHome.bind(this)} disabled={homeLink?false:true}>前往赚钱</Button>
      </MainLayout>
    )
  }
}

export default connect(({guideModel}) => ({guideModel}))(Page);
