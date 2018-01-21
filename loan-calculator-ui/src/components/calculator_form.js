import React, { Component } from 'react';
import { Field, reduxForm } from 'redux-form';
import { connect } from 'react-redux';
import { getCalculation } from '../actions';

const renderInputField = (field) => {

    const { meta: { touched, error }, serverErrors } = field;

    const className = `form-group ${ touched && error || !!serverErrors && serverErrors.hasOwnProperty(field.input.name) ? 'has-error' : '' }`;

    let outputServerError = null;

    if( !!serverErrors && serverErrors.hasOwnProperty(field.input.name) ){
        outputServerError = serverErrors[field.input.name];
    }

    return(
        <div className={className}>
            <label>{field.label}</label>
            <input
                type={field.type}
                placeholder={field.label}
                className="form-control"
                {...field.input}
            />
            <div className="input-feedback">
                <div>{ touched ? error : '' }</div>
                <div>{outputServerError}</div>
            </div>
        </div>
    );
};

class CalculatorForm extends Component {

    onSubmit(values) {
            this.props.getCalculation(values);
    }

    componentDidMount(){
        this.props.initialize({
            loan_amount: initialFormValues.loan_amount,
            term_length: initialFormValues.term_length,
            interest: initialFormValues.interest
        });

        this.props.handleSubmit(this.onSubmit.bind(this));
    }

    render(){
        const { handleSubmit, calculation } = this.props;

        return(
            <div>
                <form onSubmit={handleSubmit(this.onSubmit.bind(this))}>
                    <Field
                        label="Loan Amount"
                        type="text"
                        name="loan_amount"
                        component={renderInputField}
                        serverErrors={calculation.errors}
                    />
                    <Field
                        label="Term Length In Years"
                        type="text"
                        name="term_length"
                        component={renderInputField}
                        serverErrors={calculation.errors}
                    />
                    <Field
                        label="APR % / Interest"
                        type="text"
                        name="interest"
                        component={renderInputField}
                        serverErrors={calculation.errors}
                    />

                    { !!calculation.result && <div className="form-group result">Monthly Payment: <strong>${calculation.result}</strong></div>}

                    <div>
                        <button type="submit" className="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        );
    }

}

function validate(values){

	const errors = {};

	//validate inputs
	if( ! values.loan_amount ){
		errors.loan_amount = "Enter the loan amount";
	}

	if( ! values.term_length ){
		errors.term_length = "Enter the length of the loan";
	}

	if( ! values.interest ){
		errors.interest = "Enter the interest rate";
	}

	return errors;

}

const mapStateToProps = (state) => {
    return {
        calculation: state.calculation
    }
};

export default reduxForm({
	validate,
	form: 'LoanCalculatorForm'
})(
	connect(mapStateToProps, {getCalculation})(CalculatorForm)
);
