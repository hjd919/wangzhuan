import { Router, Route, Switch } from 'dva/router';
import React from 'react';
import dynamic from 'dva/dynamic';

function RouterConfig({ history, app }) {
  // 主页
  const IndexPage = dynamic({
    app,
    models: () => [
      import('./models/indexModel'),
      import('./models/loginModel'),
    ],
    component: () => import('./routes/IndexPage'),
  });

  // 登录
  const LoginPage = dynamic({
    app,
    models: () => [
      import('./models/loginModel'),
    ],
    component: () => import('./routes/LoginPage'),
  });

  // 我的
  const MyPage = dynamic({
    app,
    models: () => [
      import('./models/myModel'),
    ],
    component: () => import('./routes/MyPage'),
  });

  return (
    <Router history={history}>
      <Switch>
        <Route exact path="/" component={IndexPage} />
        <Route exact path="/login" component={LoginPage} />
        <Route exact path="/my" component={MyPage} />
      </Switch>
    </Router>
  );
}

export default RouterConfig;
