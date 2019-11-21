<?php

namespace App\Errors;

class MinimumOdds extends Error
{
    public $code = 6;
    public $message = 'Minimum odds are %s';
}
