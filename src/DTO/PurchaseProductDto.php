<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Product;

class PurchaseProductDto
{
    /**
     * @var Product|null
     */
    private ?Product $product;

    /**
     * @var string|null
     */
    private ?string $taxNumber;

    /**
     * @var string|null
     */
    private ?string $couponCode;

    /**
     * @var string|null
     */
    private ?string $paymentProcessor;

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product|null $product
     */
    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return string|null
     */
    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    /**
     * @param string|null $taxNumber
     */
    public function setTaxNumber(?string $taxNumber): void
    {
        $this->taxNumber = $taxNumber;
    }

    /**
     * @return string|null
     */
    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    /**
     * @param string|null $couponCode
     */
    public function setCouponCode(?string $couponCode): void
    {
        $this->couponCode = $couponCode;
    }

    /**
     * @return string|null
     */
    public function getPaymentProcessor(): ?string
    {
        return $this->paymentProcessor;
    }

    /**
     * @param string|null $paymentProcessor
     */
    public function setPaymentProcessor(?string $paymentProcessor): void
    {
        $this->paymentProcessor = $paymentProcessor;
    }
}
