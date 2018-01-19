<?php

namespace Loan_Calculator;

class Loan_Calculator {
	
	public function init() {
		$this->attach_hooks();
	}
	
	public function attach_hooks() {
		
		add_shortcode( 'loan_calculator', array( $this, 'render_html_hook' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_shortcode_script' ) );
		add_action( 'rest_api_init', array( $this, 'register_result_endpoint' ) );
		
	}
	
	
	public function render_html_hook( $atts ) {
		
		$atts = shortcode_atts(
			array(
				'loan_amount' => '',
				'term_length' => '',
				'interest'    => '',
			), $atts, 'loan_calculator' );
		
		return sprintf( '<div id="loan-calc-hook"></div><script> var initialFormValues = %s</script>', wp_json_encode( $atts ) );
		
	}
	
	
	public function load_shortcode_script() {
		global $post;
		
		if ( has_shortcode( $post->post_content, 'loan_calculator' ) ) {
			
			wp_enqueue_script( 'loan_calculator_script', plugin_dir_url( __FILE__ ) . '../loan-calculator-ui/dist/bundle.js', array(), '1.0', true );
			
			//render ajax url so react api can use it
			wp_localize_script( 'loan_calculator_script', 'loanCalcRestNamespace', array( 'url' => get_rest_url( null, 'loancalculator/v1' ) ) );
			
			wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', array(), null );
		}
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
		
		$monthly_payment = $this->calculate_monthly_payment($loan_amount, $term_length, $interest);
		
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
	
	/**
	 * Convert percent to a decimal
	 *
	 * @param $apr
	 *
	 * @return float|int
	 */
	public function percent_to_decimal( $apr ) {
		
		$decimal = $apr / 100;
		
		return $decimal;
		
	}
	
	/**
	 * Convert years into months
	 *
	 * @param $years
	 *
	 * @return float|int
	 */
	public function years_to_months( $years ) {
		
		$months = $years * 12;
		
		return $months;
	}
	
	/**
	 * Calculate Monthly Interest
	 *
	 * @param $interest
	 *
	 * @return float|int
	 */
	public function monthly_interest( $interest ) {
		
		$monthly_interest = $interest / 12;
		
		return $monthly_interest;
		
	}
	
	public function calculate_monthly_payment( $loan_amount, $term_length, $interest ) {
		
		$interest          = $this->percent_to_decimal( $interest );
		$periodic_interest = $this->monthly_interest( $interest );
		$num_payments      = $this->years_to_months( $term_length );
		
		$payment_amount = ( ( $periodic_interest * $loan_amount ) / ( 1 - ( ( 1 + $periodic_interest ) ** - $num_payments ) ) );
		
		$payment_rounded = number_format( (float) $payment_amount, 2, '.', '' );
		
		return $payment_rounded;
		
	}
	
	
}

