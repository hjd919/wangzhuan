import { Button, List } from 'antd-mobile';
const Item = List.Item;
const Brief = Item.Brief;
import { Link } from 'dva/router';
import { connect } from 'dva';
import React from 'react';

import Header from 'components/MainLayout/Header';
import MainLayout from 'components/MainLayout/MainLayout';
import globalStyles from 'styles/globalStyles';

class Page extends React.Component {
	constructor(props) {
	    super(props)

	    const {dispatch} = props
	    // 获取页面数据
	    dispatch({type:'myModel/getUserinfo'});
  	}

  render(){
  	const {userinfo} = this.props.myModel
  	
  	return (
      	<MainLayout>
	        <Header rightContent={[
	          <Link key="1" to={{ pathname: '/' }}>
	            <Button type="default" size="small">首页</Button>
	          </Link>,
	        ]}/>
	        <div style={{height:'1px',background:'#D4D6D8'}}></div>
  			<div className="headerWrap">
  				<div className="userinfo">
					<div className="avatar">
		                <img className="avatarImg" src={userinfo.avatar}/>
		            </div>
					<div className="judgebRenewFalse">
	                    <div className="nameVipF">
	                        <span className="nameVipFSpan">
	                            <span className="nametitleF">{userinfo.nickname}</span>
	                     	</span>
	                    </div>
	                </div>
  				</div>
  				<div className="top_line_box">
		            <p className="top_line wandu_wap_bordercolor_f3"></p>
		        </div>
				<div className="balance_pay">
		            <div className="balanceD clearfix">
		                <p>
		                    <span className="egold">0</span> 书豆<br/>书豆余额
		                </p>
		            </div>
		            <div className="mid wandu_wap_bordercolor_f3"></div>
		            <div className="balanceQ clearfix">
		                <p>
		                    <span className="egold">0</span> 书券<br/>书券余额
		                </p>
		            </div>
		            <div className="pay clearfix">
		                <a className="payBookBtn wandu_wap_fontcolor" href="http://t.10000read.com/user/pay">充值书豆</a>
		            </div>
	        	</div>
  			</div>
			<div className="gap"></div>
		 	<List className="my-list">
		        <Item arrow="horizontal">
			        <Link to="/help">
			          使用帮助
			        </Link>
		        </Item>
		        <Item arrow="horizontal">
			        <Link to="/feedback">
			          反馈建议
			        </Link>
		        </Item>
		    </List>
	    	<style jsx>{`
	    		.wandu_wap_fontcolor {
				    color: #ef3a3a !important;
				}
	    		.egold {
				    display: inline-block;
				    line-height: 37px;
				    color: #fff;
				    font-size: 26px;
				}
				.balanceD p, .balanceQ p {
				    color: #fff;
				    font-size: 12px;
				    margin-bottom: 10px;
				}
	    		.payBookBtn {
				    display: inline-block;
				    width: 100%;
				}
				.pay {
				    width: 70%;
				    margin: 0 auto;
				    color: #EF3A3A;
				    clear: both;
				    text-align: center;
				    border-radius: 22px;
				    background: #F8F8F8;
				    font-size: 14px;
				    line-height: 34px;
				}
				.balanceQ {
				    width: 49.56%;
				    float: right;
				    overflow: hidden;
				    text-align: center;
				}
				.wandu_wap_bordercolor_f3 {
				    border-color: rgba(255,255,255,0.3) !important;
				}	    	
				.mid {
				    /* width: 1px; */
				    overflow: hidden;
				    float: left;
				    height: 30px;
				    border-right: 1px solid #F54949;
				    margin-top: 12px;
				    position: relative;
				}	    
	    		.balance_pay{
				    padding: 6px 0px 10px;
				    overflow: hidden;
	    		}
	    		.balanceD {
				    width: 49%;
				    float: left;
				    overflow: hidden;
				    text-align: center;
				}
	    		.top_line_box{
					width: 88.3%;
				    overflow: hidden;
				    margin: 0 auto;
				    margin-top: -1px;
				    height: 1px;
	    		}
	    		.top_line{
					border-top: 3px solid #F54949;
				    width: 100%;
				    height: 1px;
	    		}
				.wandu_wap_bordercolor_f3 {
				    border-color: rgba(255,255,255,0.3) !important;
				}
	    	  .headerWrap {
	    	  	background: #ef3a3a !important;
			    border-radius: 4px;
			    margin: 10px 16px;
	    	  }
	    	  .userinfo{
	    	  	position: relative;
	    	  	padding: 14px 16px 6px;
	    	  	width: 100%;
	    	  	height: 64px;
	    	  	height: 100%;
			    padding: 14px 16px;
			    overflow: hidden;
			    box-sizing: border-box;
	    	  }
	    	  .avatar{
	    	  	margin-right:10px;
	    	  }
	    	  .avatarImg{
	    	  	width:50px;height:50px;border-radius:50%;
	    	  }
	    	  .judgebRenewFalse{
			    width: 76%;
			    overflow: hidden;
	    	  }
	    	  .nameVipFSpan{
				position: absolute;
			    top: 20px;
			    left: 80px;
			    width: 76%;
	    	  }
	    	  .nametitleF{
	    	  	float: left;
			    font-size: 18px;
			    max-width: 72.5%;
			    display: inline-block;
			    line-height: 36px;
			    color: #fff;
			    overflow: hidden;
			    white-space: nowrap;
			    text-overflow: ellipsis;
	    	  }
	    	`}</style>
	    	<style jsx global>{globalStyles}</style>
  		</MainLayout>
  	)
  }
}
export default connect(({myModel}) => ({myModel}))(Page);
