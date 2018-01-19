import React, { Component } from 'react';
import CalculatorForm from './calculator_form';

export default class App extends Component {
  render() {
    return (
      <div>
         <h2>Loan Calculator</h2>
         <CalculatorForm />
      </div>
    );
  }
}
