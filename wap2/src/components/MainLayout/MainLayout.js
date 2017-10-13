import React from 'react';

function MainLayout({ children, location }) {
  return (
    <div className="normal">
      {children}
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
