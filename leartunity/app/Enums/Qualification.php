<?php

namespace App\Enums;
use Number;

enum Qualification
{
    case MATRICULATION;
    case INTERMEDIATE;
    case UNDERGRADUATE;
    case GRADUATE;
    case POSTGRADUATE;

    public function get(): int {
        return match($this) {
            Qualification::MATRICULATION => 0,
            Qualification::INTERMEDIATE => 1,
            Qualification::UNDERGRADUATE => 2,
            Qualification::GRADUATE => 3,
            Qualification::POSTGRADUATE => 4,
        };
    }
    public static function toAssoc() {
        $qualificationArray = [];

        foreach(Qualification::cases() as $qualification) {
            $qualificationArray[] = $qualification->name;
        }

        return $qualificationArray;
    }
}
