import axios from 'axios';
import {
    FETCH_CALCULATION,
    RECEIVE_RESULT,
    FETCH_CALCULATION_ERROR
} from './types';

const LOAN_CALC_URL = loanCalcRestNamespace.url;

export const getCalculation = (formValues) => {

    return (dispatch) => {

        dispatch({
            type:FETCH_CALCULATION
        });

        return axios.post(`${LOAN_CALC_URL}/get_result`, formValues )
            .then( (response) => {
                dispatch({
                    type: RECEIVE_RESULT,
                    payload: response.data
                });
            })
            .catch( (error) => {
                dispatch({
                    type: FETCH_CALCULATION_ERROR,
                    payload: error.response.data
                });
            });

    };
};