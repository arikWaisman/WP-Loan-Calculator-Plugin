import { combineReducers } from 'redux';
import { reducer as formReducer } from 'redux-form';
import calculationReducer from './calculation_reducer';

const rootReducer = combineReducers({
    form: formReducer,
    calculation: calculationReducer
});

export default rootReducer;
