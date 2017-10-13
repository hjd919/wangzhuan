import { Router, Route, Switch } from 'dva/router';
import React from 'react';
import dynamic from 'dva/dynamic';

function RouterConfig({ history, app }) {
  // 主页
  const IndexPage = dynamic({
    app,
    models: () => [
      import('./models/indexModel'),
      import('./models/globalModel'),
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

  return (
    <Router history={history}>
      <Switch>
        <Route exact path="/" component={IndexPage} />
        <Route exact path="/login" component={LoginPage} />
      </Switch>
    </Router>
  );
}

export default RouterConfig;
