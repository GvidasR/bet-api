<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueElementValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $bet = $this->context->getRoot();
        $idCounts = array_count_values(array_column($bet['selections'],$constraint->field));
        if($idCounts[$value] > 1){
            $this->context->addViolation($constraint->message);
        }
    }
}
