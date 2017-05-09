import { prefix } from './../constants/constants';
// some-other-file.js
import history from '../history'

import { polyfill } from 'es6-promise';
import requestService from '../services/httpService'
import * as Actions from '../constants/actions';

polyfill();

export function login(userPassword:UserPassword){
  return dispatch =>{

    requestService.post('user','login',[userPassword])
      .then((res)=>{
        if(res.success){
          console.log(res);
          const userItemData:UserItemData = {
            id:res.result.id,
            lastLogin:res.result.lastlogin,
            token:res.result.token,
            userName:"masterofpuppets"
          }
          dispatch(loginSuccess(userItemData));
        }
        else{
          console.log("showErrorMSG");
        }


      })
      .catch((err)=>{
        console.log(err,"err");
      })
  }
}

export function loginSuccess (userItemData :UserItemData){
    return {
      type:Actions.USER_SUCCESS_LOGIN,
      payload: userItemData
    }
}

export function redirect(){
  return {
    type:Actions.USER_REDIRECT
  }
}
