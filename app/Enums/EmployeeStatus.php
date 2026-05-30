<?php

namespace App\Enums;

enum EmployeeStatus: string
{
    case ACTIVE = 'Active';
    case RESIGNED = 'Resigned';
    case TERMINATED = 'Terminated';
}
