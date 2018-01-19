<?php

namespace Loan_Calculator;

class Calculator
{

    /**
     * Convert percent to a decimal
     *
     * @param $apr
     *
     * @return float|int
     */
    public function percent_to_decimal($apr) {

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
    public function years_to_months($years) {

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
    public function monthly_interest($interest) {

        $monthly_interest = $interest / 12;

        return $monthly_interest;

    }

    public function calculate_monthly_payment($loan_amount, $term_length, $interest) {

        $interest = $this->percent_to_decimal($interest);
        $periodic_interest = $this->monthly_interest($interest);
        $num_payments = $this->years_to_months($term_length);

        $payment_amount = (($periodic_interest * $loan_amount) / (1 - ((1 + $periodic_interest) ** -$num_payments)));

        $payment_rounded = number_format((float)$payment_amount, 2, '.', '');

        return $payment_rounded;

    }

}