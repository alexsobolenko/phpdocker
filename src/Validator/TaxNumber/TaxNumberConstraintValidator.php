<?php

declare(strict_types=1);

namespace App\Validator\TaxNumber;

use App\Service\Payment\PaymentProviderService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class TaxNumberConstraintValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     */
    public function validate($value, Constraint $constraint): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (!$constraint instanceof TaxNumberConstraint) {
            throw new UnexpectedTypeException($constraint, TaxNumberConstraint::class);
        }

        if (!preg_match(PaymentProviderService::TAX_NUMBER_REGEXP, $value)) {
            $this->context->buildViolation($constraint->errorMessage)->addViolation();
        }
    }
}
