import { prefix } from './../constants/constants';
import * as Actions from '../constants/actions';

let initialState: UserStoreState = {};

const stringUser = localStorage.getItem(prefix+'user');

if(stringUser){
  initialState = JSON.parse(stringUser)
}

export default function user(state = initialState, action: any) {

  switch (action.type) {
    case Actions.USER_SUCCESS_LOGIN:
      localStorage.setItem(prefix+'user',JSON.stringify(action.payload));
      return action.payload;
    case Actions.USER_SUCCESS_LOGOUT:
      localStorage.removeItem(prefix+'user');
      return {}
    default:
      return state;
  }
}
