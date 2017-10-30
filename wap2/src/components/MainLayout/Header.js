import { NavBar } from 'antd-mobile';
import React from 'react';

function Header({rightContent,leftContent}) {

  return (
    <header className="aui-bar aui-bar-nav v5-header">
      <div className="aui-title v5-title">试玩赚赚</div>
      <style jsx>{`
.v5-header{
  background: #2a2a2a;
}
.v5-title{
  font-size: 17px;  
}
      `}</style>
    </header>
  );
}
export default Header;
