<?php

namespace Tests\AppBundle\Middleware;

use AppBundle\Exceptions\InvalidTransactionException;
use AppBundle\Middleware\CheckIfValueGreaterEqualThanZeroMiddleware;
use PHPUnit\Framework\TestCase;

class CheckIfValueGreaterThanZeroMiddlewareTest extends TestCase
{

    /**
     * @test
     */
    public function shouldBeValidWhenValueGreaterThanZero()
    {
        $value = 1;

        $middleware = new CheckIfValueGreaterEqualThanZeroMiddleware($value);

        $this->assertTrue($middleware->check());
    }


    /**
     * @test
     */
    public function shouldThrowInvalidTransactionExceptionWhenValueEqualZero()
    {
        $value = 0;

        $middleware = new CheckIfValueGreaterEqualThanZeroMiddleware($value);

        $this->expectException(InvalidTransactionException::class);

        $this->assertTrue($middleware->check());

    }

    /**
     * @test
     */
    public function shouldThrowInvalidTransactionExceptionWhenValueLessThan()
    {
        $value = -1;

        $middleware = new CheckIfValueGreaterEqualThanZeroMiddleware($value);

        $this->expectException(InvalidTransactionException::class);

        $this->assertTrue($middleware->check());

    }
}