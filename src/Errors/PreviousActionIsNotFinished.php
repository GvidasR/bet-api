<?php

namespace App\Errors;

class PreviousActionIsNotFinished extends Error
{
    public $code = 10;
    public $message = 'Your previous action is not finished yet';
}
