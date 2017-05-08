import { createStore, applyMiddleware, Store,compose  } from 'redux';
import thunk from 'redux-thunk';
import { logger } from '../middleware';
import rootReducer, { RootState } from '../reducers';

export function configureStore(initialState?: RootState): Store<RootState> {

  const middleWare = [thunk,logger];
  let store;
  if(window.devToolsExtension){
    store = createStore(rootReducer,initialState,compose(applyMiddleware(...middleWare), window.devToolsExtension()));
  }
  else{
    store = createStore(rootReducer,initialState,compose(applyMiddleware(...middleWare), f=>f));
  }


  return store;
}
