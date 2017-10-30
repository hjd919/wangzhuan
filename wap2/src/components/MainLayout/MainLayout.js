import React from 'react';

import globalStyles from 'styles/globalStyles';

import Footer from './Footer';
import Header from './Header';

function MainLayout({ children, location }) {
  return (
    <div className="normal">
      <Header/>
        <div className="aui-content" style={{ marginBottom: '50px'}}> 
        {children}
        </div>
      <Footer/>
      <style jsx>{`
        .normal {
          display: flex;
          flex-direction: column;
          height: 100%;
        }
      `}</style>
      <style jsx global>{globalStyles}</style>
    </div>
  );
}

export default MainLayout;
