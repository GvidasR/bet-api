<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueElement extends Constraint
{
    public $field = '';
    public $message = '';
}
