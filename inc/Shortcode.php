<?php

namespace Loan_Calculator;

use Loan_Calculator\Base;

class Shortcode extends Base {
	
	public function attach_hooks() {
		
		add_shortcode( 'loan_calculator', array( $this, 'render_html_hook' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_shortcode_script' ) );
		
	}
	
	public function render_html_hook( $atts ) {
		
		$atts = shortcode_atts(
			array(
				'loan_amount' => '',
				'term_length' => '',
				'interest'    => '',
				'title'       => '',
			),
			$atts,
			'loan_calculator'
		);
		
		wp_localize_script( 'loan_calculator_script', 'initialFormSettings', $atts );
		
		return '<div id="loan-calc-hook" class="loan-calce"></div>';
		
	}
	
	
	public function load_shortcode_script() {
		global $post;
		
		wp_register_script( 'loan_calculator_script', plugin_dir_url( __FILE__ ) . '../loan-calculator-ui/dist/bundle.js', array(), '1.0', true );
		
		//render ajax url so react api can use it
		wp_localize_script( 'loan_calculator_script', 'loanCalcRestNamespace', array( 'url' => get_rest_url( null, 'loancalculator/v1' ) ) );
		
		
		if ( has_shortcode( $post->post_content, 'loan_calculator' ) ) {
			
			wp_enqueue_script('loan_calculator_script');
			
			$load_bootstrap = carbon_get_theme_option('load_bootstrap');
			
			if( $load_bootstrap ){
				wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', array(), null );
				
			}
		}
	}
	
	
}
