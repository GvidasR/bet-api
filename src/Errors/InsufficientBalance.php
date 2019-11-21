<?php

namespace App\Errors;

class InsufficientBalance extends Error
{
    public $code = 11;
    public $message = 'Insufficient balance';
}
