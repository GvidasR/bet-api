<?php

namespace App\Errors;

class MaximumWinAmount extends Error
{
    public $code = 9;
    public $message = 'Maximum win amount is %s';
}
