<?php

declare(strict_types=1);

namespace App\Exception;

abstract class ApiException extends \Exception
{
    /**
     * @var string
     */
    public $message = 'Api exception';

    /**
     * @return array
     */
    abstract public function toArray(): array;
}
