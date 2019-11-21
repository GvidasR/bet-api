<?php

namespace App\Errors;

class BetslipStructureMismatch extends Error
{
    public $code = 1;
    public $message = 'Betslip structure mismatch';
}
