<?php

declare(strict_types=1);

namespace App\Model\Payment\Factory;

use App\Model\Payment\PaymentInfoModel;

class PaymentInfoModelFactory
{
    /**
     * @param string|null $productTitle
     * @param float|null $price
     * @return PaymentInfoModel
     */
    public function fromParameters(?string $productTitle, ?float $price): PaymentInfoModel
    {
        $model = new PaymentInfoModel();
        $model->setProductName($productTitle);
        $model->setPrice($price);

        return $model;
    }
}
