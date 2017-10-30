import { connect } from 'dva';
import React from 'react';

import Base from 'routes/Base';
import MainLayout from 'components/MainLayout/MainLayout';

class Page extends Base {

  componentDidMount() {
    const {dispatch, location} = this.props
    
    // 获取页面数据
    dispatch({type:'userModel/getUserinfo'}); //用户信息
    dispatch({type:'taskModel/getTaskApps'}); //列表信息

    // 判断是否需要重定向
    dispatch({type:'indexModel/isRedirect', payload:{search: location.search}});
  }

  render(){
    const {userInfo} = this.props.userModel
    const {taskApps} = this.props.taskModel

    return (
      <MainLayout>
         <div className="v5-index-container1" style={{"position": "relative"}}> 
          <div className="v5-fontsize11 v5-pa-lr-25 ">
           账户余额(元)
          </div> 
          <div className="v5-clearfix v5-pa-lr-25">
           <div className="aui-col-xs-6 v5-fontsize30">
            {userInfo.balance}&nbsp;
           </div> 
           <a href="/Cash/index.html">
            <div className="aui-col-xs-6 v5-fontsize16 ">
             <div className="v5-quxian-btn">
              <div>
               提现
              </div>
             </div>
            </div></a>
          </div> 
          <div className="v5-clearfix v5-op-container">
           <div className="aui-col-xs-6">
            <span className="v5-fontsize11 ">今日收入(元)</span>
            <span className="v5-fontsize16 pdl7 bdr1 to-down-2">{userInfo.today_income}</span>
           </div> 
           <div className="aui-col-xs-6">
            <span className="v5-fontsize11 ">累计收入(元)</span>
            <span className="v5-fontsize16 pdl7 bdr1 to-down-2">{userInfo.total_income}</span>
           </div>
          </div>
         </div> 

          <div className="v5-card v5-clearfix">
            {/*
           <div className="v5-card-header">
            <span className="tasking"></span>
            <span>投放中，总计 5.76 元</span>
           </div> 
           */}
           <div className="card-list-container">
            {
              taskApps.now_apps.map((row,key) => {
                return (
                  <div className="card-item v5-clearfix" key={key}>
                   <div className="aui-col-xs-3 task-ico">
                    <img src={row.icon} />
                   </div> 
                   <div className="aui-col-xs-6 task-item-center">
                    <p className="task-name">{row.title}</p> 
                    <div>
                     <span className="tag tag-pink">剩余{row.remain_num}份</span>
                    </div>
                   </div> 
                   <div className="aui-col-xs-3 task-price task-item-right aui-text-center">
                    <span className="aui-font-size-11">+</span>
                    <span className="aui-font-size-22">{row.price_user}</span>
                    <span className="aui-font-size-11">元</span>
                   </div>
                  </div>)
              })
            }
           </div>
          </div>

      </MainLayout>
    );
  }
}


export default connect(({userModel,taskModel}) => ({userModel,taskModel}))(Page);

