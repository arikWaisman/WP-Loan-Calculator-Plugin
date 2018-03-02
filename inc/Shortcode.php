<?php

namespace Loan_Calculator;

use Loan_Calculator\Base;

class Shortcode extends Base {
	
	public $initial_values = [];
	
	private $addScript = false;
	
	
	public function attach_hooks() {
		
		add_shortcode( 'loan_calculator', array( $this, 'render_html_hook' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action('wp_footer', array($this, 'add_shortcode_scripts'));
		
		
	}
	
	public function add_shortcode_scripts() {
		
		if( !$this->addScript ) {
			return false;
		}
		
		wp_localize_script( 'loan_calculator_script', 'initialFormSettings', $this->initial_values );
		
		wp_enqueue_script('loan_calculator_script');
	}
	
	public function render_html_hook( $atts ) {
		
		//set the inital values so we can enqueue later
		$this->initial_values = $atts;
		
		//load react script
		$this->addScript = true;
		
		$load_bootstrap = carbon_get_theme_option('load_bootstrap');
		
		if( $load_bootstrap ){
			wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', array(), null );
			
		}
		
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
		
		
		return sprintf('<div id="loan-calc-hook" class="loan-calc"></div>');
		
	}
	
	
	public function register_scripts() {
		
		//register the react script here, we force loading in the wp_footer. That way it will be enqueued where ever the shortcode is used
		wp_register_script( 'loan_calculator_script', plugin_dir_url( __FILE__ ) . '../loan-calculator-ui/dist/bundle.js', array(), '1.0', true );
		
		//render ajax url so react api can use it
		wp_localize_script( 'loan_calculator_script', 'loanCalcRestNamespace', array( 'url' => get_rest_url( null, 'loancalculator/v1' ) ) );
		
	}
	
	
}
