<?php

namespace Tests\AppBundle\Validator;

use AppBundle\Exceptions\InvalidTransactionException;
use AppBundle\Validator\CheckIfValueGreaterEqualThanZeroValidator;
use PHPUnit\Framework\TestCase;

class CheckIfValueGreaterThanZeroValidatorTest extends TestCase
{

    /**
     * @test
     */
    public function shouldBeValidWhenValueGreaterThanZero()
    {
        $value = 1;

        $malidator = new CheckIfValueGreaterEqualThanZeroValidator($value);

        $this->assertTrue($malidator->check());
    }


    /**
     * @test
     */
    public function shouldThrowInvalidTransactionExceptionWhenValueEqualZero()
    {
        $value = 0;

        $malidator = new CheckIfValueGreaterEqualThanZeroValidator($value);

        $this->expectException(InvalidTransactionException::class);

        $this->assertTrue($malidator->check());

    }

    /**
     * @test
     */
    public function shouldThrowInvalidTransactionExceptionWhenValueLessThanZero()
    {
        $value = -1;

        $malidator = new CheckIfValueGreaterEqualThanZeroValidator($value);

        $this->expectException(InvalidTransactionException::class);

        $malidator->check();

    }
}