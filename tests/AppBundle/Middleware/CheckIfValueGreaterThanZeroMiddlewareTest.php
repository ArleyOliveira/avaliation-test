<?php

namespace Tests\AppBundle\Middleware;

use AppBundle\Exceptions\InvalidTransactionException;
use AppBundle\Middleware\CheckIfValueGreaterEqualThanZeroValidator;
use PHPUnit\Framework\TestCase;

class CheckIfValueGreaterThanZeroMiddlewareTest extends TestCase
{

    /**
     * @test
     */
    public function shouldBeValidWhenValueGreaterThanZero()
    {
        $value = 1;

        $middleware = new CheckIfValueGreaterEqualThanZeroValidator($value);

        $this->assertTrue($middleware->check());
    }


    /**
     * @test
     */
    public function shouldThrowInvalidTransactionExceptionWhenValueEqualZero()
    {
        $value = 0;

        $middleware = new CheckIfValueGreaterEqualThanZeroValidator($value);

        $this->expectException(InvalidTransactionException::class);

        $this->assertTrue($middleware->check());

    }

    /**
     * @test
     */
    public function shouldThrowInvalidTransactionExceptionWhenValueLessThanZero()
    {
        $value = -1;

        $middleware = new CheckIfValueGreaterEqualThanZeroValidator($value);

        $this->expectException(InvalidTransactionException::class);

        $middleware->check();

    }
}