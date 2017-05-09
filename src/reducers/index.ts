import { combineReducers, Reducer } from 'redux';
import {routerReducer } from 'react-router-redux'

import todos from './todos';
import user from './users';

export interface RootState {
  todos: TodoStoreState;
  user: UserStoreState;
  router: typeof routerReducer;
}

export default combineReducers<RootState>({
  todos,
  user,
  router:routerReducer
});
