<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\Category;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CategoryConstraintValidator extends ConstraintValidator
{
    /**
     * @param Category $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if ($value->isFromWorld() && $value->isToWorld()) {
            $this->context->buildViolation('Деньги мимо кассы?')
                ->addViolation();
        }
    }
}
