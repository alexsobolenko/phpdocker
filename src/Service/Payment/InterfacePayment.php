<?php

declare(strict_types=1);

namespace App\Service\Payment;

interface InterfacePayment
{
    /**
     * @param int $price
     * @throws \Exception
     */
    public function processPayment(int $price): void;
}
