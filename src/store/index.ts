import { createStore, applyMiddleware, Store,compose  } from 'redux';
import thunk from 'redux-thunk';
import { logger } from '../middleware';
import rootReducer, { RootState } from '../reducers';
import {routerMiddleware } from 'react-router-redux'
import history from '../history'

const prefix = 'masterOfPuppets_new'
export function configureStore(initialState?: RootState): Store<RootState> {

  const routingMiddleware = routerMiddleware(history)
  const middleWare = [thunk,logger,routingMiddleware];

  let store;

  if(window.devToolsExtension){
    store = createStore(rootReducer,initialState,compose(applyMiddleware(...middleWare), window.devToolsExtension()));
  }
  else{
    store = createStore(rootReducer,initialState,compose(applyMiddleware(...middleWare), f=>f));
  }

  return store;
}
