import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { createStore, applyMiddleware } from 'redux';
import reduxThunk from 'redux-thunk';
import logger from 'redux-logger';

import App from './components/app';
import reducers from './reducers';

import '../style/style.scss';

const createStoreWithMiddleware = applyMiddleware( reduxThunk )(createStore);

ReactDOM.render(
  <Provider store={createStoreWithMiddleware(reducers)}>
    <App />
  </Provider>
  , document.getElementById('loan-calc-hook'));
