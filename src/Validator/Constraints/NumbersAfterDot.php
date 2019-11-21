<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NumbersAfterDot extends Constraint
{
    public $min = 0;
    public $max = false;
    public $message = '';
}
