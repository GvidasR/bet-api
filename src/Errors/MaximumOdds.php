<?php

namespace App\Errors;

class MaximumOdds extends Error
{
    public $code = 7;
    public $message = 'Maximum odds are %s';
}
