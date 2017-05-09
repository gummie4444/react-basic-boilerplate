import * as React from 'react';
import * as ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { Router, Route, Switch } from 'react-router';
import { UserAuthWrapper } from 'redux-auth-wrapper'
import history from './history';
import { configureStore } from './store';
import App from './containers/App';
import { Login } from './containers/Login';
import {redirect} from './actions/user';
import { routerActions, ConnectedRouter } from 'react-router-redux'
const store = configureStore();

console.log(App,"app");
console.log(Login,"lognin");
console.log(ConnectedRouter);

// Redirects to /login by default
export const UserIsAuthenticated = UserAuthWrapper({
  authSelector: state => state.user,
   redirectAction: routerActions.replace,
   wrapperDisplayName: 'UserIsAuthenticated'
 })

ReactDOM.render(
  <Provider store={store}>
    <ConnectedRouter history={history}>
      <Switch>
        <Route exact path="/login" component={Login}/>
        <Route path="/" component={UserIsAuthenticated(App)}/>
      </Switch>
    </ConnectedRouter >
  </Provider>,
  document.getElementById('root')
);
