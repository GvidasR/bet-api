<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueElementsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if(count(array_unique(array_column($value,$constraint->field))) < count($value)){
            $this->context->addViolation($constraint->message);
        }
    }
}
