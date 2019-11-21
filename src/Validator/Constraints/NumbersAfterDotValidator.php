<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NumbersAfterDotValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if(strpos($value, ".") > 0) {
            if(strlen(substr(strrchr($value, "."), 1)) < $constraint->min) {
                $this->context->addViolation($constraint->message);
            }
            if($constraint->max !== false && strlen(substr(strrchr($value, "."), 1)) > $constraint->max) {
                $this->context->addViolation($constraint->message);
            }
        } else {
            if($constraint->min > 0) {
                $this->context->addViolation($constraint->message);
            }
        }
    }
}
