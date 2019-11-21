<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class WinLimitValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $possibleWin = $value;
        $bet = $this->context->getRoot();
        if(!empty($bet['selections'])) {
            foreach ($bet['selections'] as $selection) {
                $possibleWin *= $selection['odds'];
            }
        }
        if($constraint->max !== false && $possibleWin > $constraint->max) {
            $this->context->addViolation($constraint->message);
        }
    }
}
