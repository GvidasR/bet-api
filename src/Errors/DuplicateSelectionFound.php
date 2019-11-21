<?php

namespace App\Errors;

class DuplicateSelectionFound extends Error
{
    public $code = 8;
    public $message = 'Duplicate selection found';
}
