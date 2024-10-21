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

    public static function get($value) {
        return Qualification::toAssoc()[(int)$value];
    }
    public static function toAssoc() {
        $qualificationArray = [];

        foreach(Qualification::cases() as $qualification) {
            $qualificationArray[] = $qualification->name;
        }

        return $qualificationArray;
    }
}
