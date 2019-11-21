<?php

namespace App\Errors;

class MaximumStakeAmount extends Error
{
    public $code = 3;
    public $message = 'Maximum stake amount is %s';
}
