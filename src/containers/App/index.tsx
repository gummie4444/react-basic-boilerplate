import * as React from 'react';
import * as TodoActions from '../../actions/todos';
import * as style from './style.css';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { RouteComponentProps } from 'react-router';
import { RootState } from '../../reducers';
import { Header, MainSection } from '../../components';
import { withRouter } from 'react-router-dom'

export namespace App {
  export interface Props extends RouteComponentProps<void> {
    todos: TodoItemData[];
    actions: typeof TodoActions;
  }

  export interface State {
    /* empty */
  }
}

 class App extends React.Component<App.Props, App.State> {

  render() {
    console.log("ddwedwerp");
    const { todos, actions, children } = this.props;
    return (
      <div className={style.normal}>
        <Header addTodo={actions.addTodo} />
        <MainSection todos={todos} actions={actions} />
        {children}
      </div>
    );
  }
}

function mapStateToProps(state: RootState) {
  return {
    todos: state.todos
  };
}

function mapDispatchToProps(dispatch) {
  return {
    actions: bindActionCreators(TodoActions as any, dispatch)
  };
}

export default withRouter(connect(mapStateToProps,mapDispatchToProps)(App));
