<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueElements extends Constraint
{
    public $field = '';
    public $message = '';
}
