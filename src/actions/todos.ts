
import { polyfill } from 'es6-promise';
import request from 'axios';
import requestService from '../services/httpService'
import * as Actions from '../constants/actions';

polyfill();


export function addTodoPromise(todoItem:TodoItemData){
  return dispatch =>{
    const test = new Promise((resolve,reject)=>{
      setTimeout(function() {
        resolve(todoItem);
      }, 500);
    })

    test.then(item=>{
      dispatch(addTodo(item));
    });
  }
}

export function addTodo (todoItem :TodoItemData){
    return {
      type:Actions.ADD_TODO,
      payload: todoItem
    }
}

export function editTodo (todoItem: TodoItemData){
    return {
      type:Actions.EDIT_TODO,
      payload:todoItem
    }
}
export function deleteTodo (id:TodoItemId){
    return {
      type:Actions.DELETE_TODO,
      payload:id
    }
}
export function completeTodo (id:TodoItemId){
    return {
      type:Actions.COMPLETE_TODO,
      payload:id
    }
}
export function completeAll (){
    return {
      type:Actions.COMPLETE_ALL
    }
}

export function clearCompleted (){
    return {
      type:Actions.CLEAR_COMPLETED
    }
}

