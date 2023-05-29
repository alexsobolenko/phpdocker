<?php

declare(strict_types=1);

namespace App\Service\Payment;

class StripePaymentProcessor implements InterfacePayment
{
    /**
     * @param int $price
     * @throws \Exception
     */
    public function processPayment(int $price): void
    {
        if ($price < 10) {
            throw new \Exception('Too low price');
        }

        // process payment logic
    }
}
