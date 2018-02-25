import React, { Component } from 'react';
import CalculatorForm from './calculator_form';

export default class App extends Component {
  render() {
    return (
      <div>
          {!!initialFormSettings.title && <h2>{initialFormSettings.title}</h2>}
         <CalculatorForm />
      </div>
    );
  }
}
