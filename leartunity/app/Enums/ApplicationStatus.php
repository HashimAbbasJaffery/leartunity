<?php

namespace App\Enums;

enum ApplicationStatus: int
{
    case PENDING = 0;
    case APPROVED = 1;
    case REJECTED = 2;

}
