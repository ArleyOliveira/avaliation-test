<?php

namespace Tests\AppBundle\Middleware;

use AppBundle\Entity\Wallet;
use AppBundle\Exceptions\InvalidTransactionException;
use AppBundle\Middleware\CheckIfWalletIsNotNullMiddleware;
use PHPUnit\Framework\TestCase;

class CheckIfWalletIsNotNullMiddlewareTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeValidWhenNotNull() {
        $wallet = new Wallet();

        $middleware = new CheckIfWalletIsNotNullMiddleware($wallet);

        $this->assertTrue($middleware->check());
    }

    /**
     * @test
     */
    public function shouldThrowInvalidTransactionExceptionWhenNull() {
        $wallet = null;

        $validator = new CheckIfWalletIsNotNullMiddleware($wallet);

        $this->expectException(InvalidTransactionException::class);

        $this->assertTrue($validator->check());

    }
}