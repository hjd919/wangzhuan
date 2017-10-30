import { Link } from 'dva/router';
import React from 'react';

function Footer(props) {

  return (
    <div className="footer">
      <p className="link">
          <Link className="link_a" to="/">首页</Link> 
          <span className="cutoff_line"></span>
          <span className="link_a" to="/feedback">客服qq:297538600</span> 
      </p>
      <style jsx>{`
        .footer {
          position:fixed;
          bottom:0;
          width: 100%;
          height: 40px;
          font-size: 16px;
          color: #333;
          text-align: center;
          background: #f0f0f0;
        }
        .link{
          width: 266px;
          margin: 0 auto 0;
          padding-top: 10px;
          color: #333;
          font-size: 14px; 
        }
        :global(.link_a){
          color: #333;
          font-size: 14px;
          text-decoration: none;
        }
        .cutoff_line{
          padding-left: 18px;
          border-right: 1px solid #ccc;
          margin-right: 20px;
        }
      `}</style>
    </div>
  );
}
export default Footer;
