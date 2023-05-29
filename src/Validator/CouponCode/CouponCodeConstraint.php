<?php

declare(strict_types=1);

namespace App\Validator\CouponCode;

use Symfony\Component\Validator\Constraint;

class CouponCodeConstraint extends Constraint
{
    /**
     * @var string
     */
    public string $errorMessage = 'Wrong coupon code';
}
