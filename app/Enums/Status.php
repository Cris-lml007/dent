<?php

namespace App\Enums;

enum Status: int
{
    case CANCELED = 0;
    case ACTIVE = 1;
    case FINISHED = 2;
}
