<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class ValidationRequestException extends ValidatorException
{
    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     */
    public function __construct(private ConstraintViolationListInterface $constraintViolationList)
    {
        parent::__construct('Error validation request', 400);
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getConstraintViolationList(): ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }
}
