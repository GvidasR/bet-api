<?php

namespace App\Errors;

class MinimumStakeAmount extends Error
{
    public $code = 2;
    public $message = 'Minimum stake amount is %s';
}
