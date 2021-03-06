import dva from 'dva';
import './index.css';
import createHistory from 'history/createBrowserHistory';
// 1. Initialize
const app = dva({
	// history: createHistory(),
	onError(e, dispatch) {
		console.log('global error')
    	console.log(e);
  	},
});

// 2. Plugins
// app.use({});

// 3. Model
app.model(require('./models/example'));

// 4. Router
app.router(require('./router'));

// 5. Start
app.start('#root');
