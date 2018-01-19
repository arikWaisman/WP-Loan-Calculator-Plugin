<?php
/*
Plugin Name: Loan Calculator
Description: Loan Calculator display
Plugin URI: 
Author: Arik Waisman
Version: 0.0.1
Author URI:
*/

require_once __DIR__ . '/inc/class-loan-calculator.php';

$loan_calculator = new \Loan_Calculator\Loan_Calculator();
$loan_calculator->init();
	

