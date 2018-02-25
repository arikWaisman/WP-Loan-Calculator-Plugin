<?php

namespace Loan_Calculator;

use Loan_Calculator\Base;
use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Settings extends Base {
	
	public function attach_hooks() {
		add_action( 'carbon_fields_register_fields', array( $this, 'settings' ) );
		add_action( 'after_setup_theme', array( $this, 'activate_carbon_fields' ) );
		
		
	}
	
	public function activate_carbon_fields(){
		Carbon_Fields::boot();
	}
	
	public function settings() {
		
		Container::make( 'theme_options', __( 'Loan Calculator Options', 'loan_calculator' ) )
			->set_page_parent( 'options-general.php' )
			->add_fields( array(
			         Field::make( 'checkbox', 'load_bootstrap', 'Load Bootstrap Styles' ),
		         ) );
		
	}
	
}