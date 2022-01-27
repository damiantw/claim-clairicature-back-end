<?php

namespace App\Enum;

enum Error
{
    case EMPLOYEE_NOT_FOUND;
    case EMPLOYEE_HAS_ALREADY_CLAIMED;
    case INVALID_WEB3_ADDRESS;
    case INVALID_SIGNATURE;
}
