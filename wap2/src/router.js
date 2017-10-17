import { Router, Route, Switch, Redirect } from 'dva/router';
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

  // 帮助
  const HelpPage = dynamic({
    app,
    models: () => [
      import('./models/helpModel'),
    ],
    component: () => import('./routes/HelpPage'),
  });

  // 反馈
  const FeedbackPage = dynamic({
    app,
    models: () => [
      import('./models/feedbackModel'),
    ],
    component: () => import('./routes/FeedbackPage'),
  });

  return (
    <Router history={history}>
      <Switch>
        <Route exact path="/" component={IndexPage} />
        <Route path="/login" component={LoginPage} />
        <Route path="/my" component={MyPage} />
        <Route path="/help" component={HelpPage} />
        <Route path="/feedback" component={FeedbackPage} />
        <Redirect to="/" />
      </Switch>
    </Router>
  );
}

export default RouterConfig;
