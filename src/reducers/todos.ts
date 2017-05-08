import {
  EDIT_TODO
} from './../constants/actions';
import {
  handleActions
} from 'redux-actions';
import * as Actions from '../constants/actions';

const initialState: TodoStoreState = [{
  id: 0,
  text: 'Use Redux',
  completed: false
}];


export default function todo(state = initialState, action: any) {

  switch (action.type) {
    case Actions.ADD_TODO:
      return [{
        id: state.reduce((maxId, todo) => Math.max(todo.id, maxId), -1) + 1,
        completed: false,
        ...action.payload,
      }, ...state];

    case Actions.DELETE_TODO:
      return state.filter(todo => todo.id !== action.payload);

    case Actions.EDIT_TODO:
      return state.map(todo => {
        return todo.id === action.payload.id ?
          { ...todo,
            text: action.payload.text
          } :
          todo;
      });

    case Actions.COMPLETE_TODO:
      return state.map(todo => {
        return todo.id === action.payload ?
          { ...todo,
            completed: !todo.completed
          } :
          todo;
      });

    case Actions.COMPLETE_ALL:
      const areAllMarked = state.every(todo => todo.completed);
      return state.map(todo => {
        return {
          ...todo,
          completed: !areAllMarked
        };
      });

    case Actions.CLEAR_COMPLETED:
      return state.filter(todo => todo.completed === false);

    default:
      return state;
  }
}
