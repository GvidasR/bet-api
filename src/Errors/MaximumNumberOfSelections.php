<?php

namespace App\Errors;

class MaximumNumberOfSelections extends Error
{
    public $code = 5;
    public $message = 'Maximum number of selections is %s';
}
