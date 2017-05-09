import * as React from 'react';
import * as UserActions from '../../actions/user';
import * as style from './style.css';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { RouteComponentProps } from 'react-router';
import { routerActions } from 'react-router-redux'
import { parse } from 'query-string'
import { RootState } from '../../reducers';
import { Header, MainSection } from '../../components';

export namespace Login {
  export interface Props extends RouteComponentProps<void> {
    isAuthenticated: boolean;
    redirect: string;
    actions: typeof UserActions;
    replace: typeof routerActions.replace;
  }

  export interface State {
    /* empty */
  }
}


@connect(mapStateToProps, mapDispatchToProps)
export class Login extends React.Component<Login.Props, Login.State> {

  refs: {
    [key: string]: (Element);
    password: (HTMLInputElement);
  }

  componentWillMount(){
    const {isAuthenticated,replace,redirect} = this.props;
    if(isAuthenticated)
      replace(redirect);
  }

  componentWillReceiveProps(nextProps){
    const { isAuthenticated, replace, redirect } = nextProps;
    const { isAuthenticated: wasAuthenticated } = this.props;

    if(!wasAuthenticated && isAuthenticated){
      replace(redirect);
    }
  }

  clickButton = (e) =>{
    e.preventDefault();
    if(this.refs.password.value.length > 0){
      this.props.actions.login(this.refs.password.value);
    }
  }

  render() {
    return (
      <div className={style.normal}>
        <span>Password: </span><input ref="password" type="password"></input>
        <button onClick={this.clickButton}>login</button>
      </div>
    );
  }
}

function mapStateToProps(state: RootState,ownProps) {
  const isAuthenticated = state.user.token || false;
  const query = new URLSearchParams(ownProps.location.search)
  const redirect = query.get('redirect') || '/';

  return {
    isAuthenticated,
    redirect: redirect || '/'
  };

}

function mapDispatchToProps(dispatch) {
  return {
    actions: bindActionCreators(UserActions as any, dispatch),
    replace: bindActionCreators(routerActions.replace,dispatch)
  };
}
