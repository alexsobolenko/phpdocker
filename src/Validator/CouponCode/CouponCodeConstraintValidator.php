<?php

declare(strict_types=1);

namespace App\Validator\CouponCode;

use App\Service\Payment\PaymentProviderService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CouponCodeConstraintValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     */
    public function validate($value, Constraint $constraint): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (!$constraint instanceof CouponCodeConstraint) {
            throw new UnexpectedTypeException($constraint, CouponCodeConstraint::class);
        }

        $valueLength = strlen($value);
        if ($valueLength < 2) {
            $this->context->buildViolation($constraint->errorMessage)->addViolation();

            return;
        }

        $prefix = strtoupper(substr($value, 0 , 1));
        if (!PaymentProviderService::isCouponPrefixValid($prefix)) {
            $this->context->buildViolation($constraint->errorMessage)->addViolation();

            return;
        }

        $amount = (int) substr($value, 1);
        if ($amount <= 0) {
            $this->context->buildViolation($constraint->errorMessage)->addViolation();
        } elseif (PaymentProviderService::COUPON_PREFIX_PERCENT === $prefix && $amount > 99) {
            $this->context->buildViolation($constraint->errorMessage)->addViolation();
        }
    }
}
