<?php

declare(strict_types=1);

namespace App\Tests\Unit\Validator;

use App\Validator\TaxNumber\TaxNumberConstraint;
use App\Validator\TaxNumber\TaxNumberConstraintValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

/**
 * @group validator
 * @group tax_number
 * @group validator.tax_number
 */
class TaxNumberConstraintValidatorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new TaxNumberConstraintValidator();
        $this->executionContext = $this->getMockBuilder(ExecutionContextInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->constraintViolationBuilder = $this->getMockBuilder(ConstraintViolationBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @dataProvider taxNumberProvider
     */
    public function testCouponCodeValidatorSuccess(string $taxNumber): void
    {
        $this->executionContext
            ->expects(self::never())
            ->method('buildViolation')
            ->with('Wrong coupon code')
            ->willReturn($this->constraintViolationBuilder);

        $this->validator->initialize($this->executionContext);
        $this->validator->validate($taxNumber, new TaxNumberConstraint());
    }

    public function testCouponCodeValidatorError(): void
    {
        $this->executionContext
            ->expects(self::once())
            ->method('buildViolation')
            ->with('Wrong tax number')
            ->willReturn($this->constraintViolationBuilder);

        $this->constraintViolationBuilder
            ->expects(self::once())
            ->method('addViolation');

        $this->validator->initialize($this->executionContext);
        $this->validator->validate('SS124125', new TaxNumberConstraint());
    }

    /**
     * @return array
     */
    public function taxNumberProvider(): array
    {
        return [
            ['DE123456789'],
            ['IT12345678910'],
            ['GR123456789'],
            ['FRZZ123456789'],
        ];
    }
}
