import React from 'react';

import Footer from './Footer';

function MainLayout({ children, location }) {
  return (
    <div className="normal">
      {children}
      <Footer/>
      <style jsx>{`
        .normal {
          display: flex;
          flex-direction: column;
          height: 100%;
        }
      `}</style>
    </div>
  );
}

export default MainLayout;
