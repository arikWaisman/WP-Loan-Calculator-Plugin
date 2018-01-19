import {
    RECEIVE_RESULT,
    FETCH_CALCULATION_ERROR
}  from '../actions/types';

export default (state = {}, action) => {

    switch(action.type) {
        case RECEIVE_RESULT:
            return {
                ...state,
                result: action.payload,
                errors: null
            };

        case FETCH_CALCULATION_ERROR:
            return {
                ...state,
                errors: action.payload
            };
    }

    return state

}