<?php

declare(strict_types=1);

namespace App\Tests\Unit\Validator;

use App\Validator\CouponCode\CouponCodeConstraint;
use App\Validator\CouponCode\CouponCodeConstraintValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

/**
 * @group validator
 * @group coupon_code
 * @group validator.coupon_code
 */
class CouponCodeConstraintValidatorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new CouponCodeConstraintValidator();
        $this->executionContext = $this->getMockBuilder(ExecutionContextInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->constraintViolationBuilder = $this->getMockBuilder(ConstraintViolationBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testCouponCodeValidatorSuccess(): void
    {
        $this->executionContext
            ->expects(self::never())
            ->method('buildViolation')
            ->with('Wrong coupon code')
            ->willReturn($this->constraintViolationBuilder);

        $this->validator->initialize($this->executionContext);
        $this->validator->validate('d12', new CouponCodeConstraint());
    }

    public function testCouponCodeValidatorErrorOnLength(): void
    {
        $this->executionContext
            ->expects(self::once())
            ->method('buildViolation')
            ->with('Wrong coupon code')
            ->willReturn($this->constraintViolationBuilder);

        $this->constraintViolationBuilder
            ->expects(self::once())
            ->method('addViolation');

        $this->validator->initialize($this->executionContext);
        $this->validator->validate('D', new CouponCodeConstraint());
    }

    public function testCouponCodeValidatorErrorOnPrefix(): void
    {
        $this->executionContext
            ->expects(self::once())
            ->method('buildViolation')
            ->with('Wrong coupon code')
            ->willReturn($this->constraintViolationBuilder);

        $this->constraintViolationBuilder
            ->expects(self::once())
            ->method('addViolation');

        $this->validator->initialize($this->executionContext);
        $this->validator->validate('S12', new CouponCodeConstraint());
    }

    public function testCouponCodeValidatorErrorOnAmount(): void
    {
        $this->executionContext
            ->expects(self::once())
            ->method('buildViolation')
            ->with('Wrong coupon code')
            ->willReturn($this->constraintViolationBuilder);

        $this->constraintViolationBuilder
            ->expects(self::once())
            ->method('addViolation');

        $this->validator->initialize($this->executionContext);
        $this->validator->validate('P-12', new CouponCodeConstraint());
    }

    public function testCouponCodeValidatorErrorOnAmountText(): void
    {
        $this->executionContext
            ->expects(self::once())
            ->method('buildViolation')
            ->with('Wrong coupon code')
            ->willReturn($this->constraintViolationBuilder);

        $this->constraintViolationBuilder
            ->expects(self::once())
            ->method('addViolation');

        $this->validator->initialize($this->executionContext);
        $this->validator->validate('Pvalue', new CouponCodeConstraint());
    }

    public function testCouponCodeValidatorErrorOnHundredPercentDiscount(): void
    {
        $this->executionContext
            ->expects(self::once())
            ->method('buildViolation')
            ->with('Wrong coupon code')
            ->willReturn($this->constraintViolationBuilder);

        $this->constraintViolationBuilder
            ->expects(self::once())
            ->method('addViolation');

        $this->validator->initialize($this->executionContext);
        $this->validator->validate('P100', new CouponCodeConstraint());
    }
}
