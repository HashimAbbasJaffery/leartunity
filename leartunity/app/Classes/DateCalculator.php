<?php 

namespace App\Classes;
use Illuminate\Database\Eloquent\Builder;

class DateCalculator {
    protected function previousMonth(int $month) {
        $previous_month = 12;
        $is_prev_year = true;
        if($month !== 1) {
            $previous_month = $month - 1;
            $is_prev_year = false;
        }

        return [$previous_month, $is_prev_year];
    }

    protected function calculateDate($date) {
        [$prev_month, $is_prev_year] = $this->previousMonth($date->month);
        $year = $date->year;
        if($is_prev_year) {
            $year--;
        };

        return [$prev_month, $year];
    }

    public function getDate($date) {
        return $this->calculateDate($date);
    }
}