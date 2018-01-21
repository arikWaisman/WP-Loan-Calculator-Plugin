<?php

namespace Loan_Calculator;

use Loan_Calculator\Base;

class Request extends Base
{
	public $calculator_obj;

	public function __construct( \Loan_Calculator\Calculator $calculator ){
		$this->calculator_obj = $calculator;
	}
 
	public function attach_hooks() {
		
		add_action( 'rest_api_init', array( $this, 'register_result_endpoint' ) );
		
	}
	
	public function register_result_endpoint() {
		
		register_rest_route( 'loancalculator/v1', '/get_result', array(
			'methods'  => 'POST',
			'callback' => array( $this, 'process_incoming_request_and_respond' ),
		) );
		
	}
	
	/**
	 * @param \WP_REST_Request $request
	 */
	public function process_incoming_request_and_respond( \WP_REST_Request $request ) {
		
		$input_values = $request->get_json_params();
		
		if ( ! $input_values ) {
			return wp_send_json( array( 'error' => 'Form needs to be filled out to calculate' ), 422 );
		}
		
		$rtn_errors = [];
		
		foreach ( $input_values as $key => $value ) {
			
			//clean the inputs and return error if nothing is returned
			if ( isset( $input_values[ $key ] ) ) {
				$input_values[ $key ] = $this->sanitize_input( $value );
				
				//if after sanitizing the inputs the value is less than or equal to zero set an error
				if ( ! $input_values[ $key ] > 0 ) {
					$rtn_errors[ $key ] = 'This value has to be greater than 0';
				}
				
			} else {
				$rtn_errors[ $key ] = 'This value has to exist';
			}
			
		}
		
		if ( count( $rtn_errors ) > 0 ) {
			return wp_send_json( $rtn_errors, 422 );
		}
		
		$loan_amount = $input_values['loan_amount'];
		$term_length = $input_values['term_length'];
		$interest    = $input_values['interest'];
		
		$monthly_payment = $this->calculator_obj->calculate_monthly_payment($loan_amount, $term_length, $interest);
		
		return wp_send_json( $monthly_payment, 200 );
		
	}
	
	/**
	 * Sanitize Inputs
	 *
	 * @param $value
	 *
	 * @return string
	 */
	public function sanitize_input( $value ) {
		
		return filter_var( $value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		
		
	}
	
}

