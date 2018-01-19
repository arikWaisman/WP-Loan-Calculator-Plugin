<?php 

namespace Loan_Calculator;

abstract class Base {

    public function init(){
        $this->attach_hooks();
    }

    abstract public function attach_hooks();
}
