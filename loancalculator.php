<?php
/*
Plugin Name: Loan Calculator
Description: Loan Calculator display
Plugin URI: 
Author: Arik Waisman
Version: 0.0.1
Author URI:
*/

require_once __DIR__ . '/vendor/autoload.php';

use Loan_Calculator\Request;
use Loan_Calculator\Shortcode;
use Loan_Calculator\Calculator;

$calculator = new Calculator();
$request = new Request( $calculator );
$request->init();

$shortcode = new Shortcode();
$shortcode->init();