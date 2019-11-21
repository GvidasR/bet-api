<?php

namespace App\Errors;

class MinimumNumberOfSelections extends Error
{
    public $code = 4;
    public $message = 'Minimum number of selections is %s';
}
