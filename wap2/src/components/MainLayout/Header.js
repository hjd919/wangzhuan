import { Button, NavBar } from 'antd-mobile';
import React from 'react';

function Header({rightContent}) {
  return (
    <NavBar 
      mode="light"
      leftContent={<span style={{fontSize: "18px",color: '#ef3a3a'}}>万读</span>}
      iconName={<img src="https://img.wandu.cn/novel/icon/20170808/181854_5989900ee6abc.png" style={{width:28,height:28}} alt="万读"/>}
      rightContent={rightContent}
    ></NavBar>
  );
}
export default Header;
