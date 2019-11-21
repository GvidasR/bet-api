<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class WinLimit extends Constraint
{
    public $max = false;
    public $message = '';
}
