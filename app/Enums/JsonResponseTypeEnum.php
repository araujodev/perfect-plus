<?php

namespace App\Enums;

enum JsonResponseTypeEnum: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
}
