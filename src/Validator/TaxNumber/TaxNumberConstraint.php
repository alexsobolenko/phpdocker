<?php

declare(strict_types=1);

namespace App\Validator\TaxNumber;

use Symfony\Component\Validator\Constraint;

class TaxNumberConstraint extends Constraint
{
    /**
     * @var string
     */
    public string $errorMessage = 'Wrong tax number';
}
