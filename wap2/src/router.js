import { Router, Route, Switch, Redirect } from 'dva/router';
import React from 'react';
import dynamic from 'dva/dynamic';

function RouterConfig({ history, app }) {
  // 主页
  const IndexPage = dynamic({
    app,
    models: () => [
      import('./models/userModel'),
      import('./models/taskModel'),
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

  // 设置
  const SettingPage = dynamic({
    app,
    models: () => [
      import('./models/settingModel'),
      import('./models/loginModel'),
    ],
    component: () => import('./routes/SettingPage'),
  });

  // 引导
  const GuidePage = dynamic({
    app,
    models: () => [
      import('./models/guideModel'),
    ],
    component: () => import('./routes/GuidePage'),
  });

  return (
    <Router history={history}>
      <Switch>
        <Route exact path="/" component={IndexPage} />
        <Route path="/login" component={LoginPage} />
        <Route path="/my" component={MyPage} />
        <Route path="/help" component={HelpPage} />
        <Route path="/feedback" component={FeedbackPage} />
        <Route path="/setting" component={SettingPage} />
        <Route path="/guide" component={GuidePage} />
        <Redirect to="/" />
      </Switch>
    </Router>
  );
}

export default RouterConfig;
