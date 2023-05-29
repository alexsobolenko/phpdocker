<?php

declare(strict_types=1);

namespace App\Service\Payment;

class PaypalPaymentProcessor implements InterfacePayment
{
    /**
     * @param int $price
     * @throws \Exception
     */
    public function processPayment(int $price): void
    {
        if ($price > 100) {
            throw new \Exception('Too high price');
        }
    }
}