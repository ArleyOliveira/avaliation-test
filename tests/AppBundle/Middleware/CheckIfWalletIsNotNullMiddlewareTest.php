<?php

namespace Tests\AppBundle\Middleware;

use AppBundle\Entity\Wallet;
use AppBundle\Exceptions\InvalidTransactionException;
use AppBundle\Middleware\CheckIfWalletIsNotNullValidator;
use PHPUnit\Framework\TestCase;

class CheckIfWalletIsNotNullMiddlewareTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeValidWhenNotNull() {
        $wallet = new Wallet();

        $middleware = new CheckIfWalletIsNotNullValidator($wallet);

        $this->assertTrue($middleware->check());
    }

    /**
     * @test
     */
    public function shouldThrowInvalidTransactionExceptionWhen() {
        $wallet = null;

        $validator = new CheckIfWalletIsNotNullValidator($wallet);

        $this->expectException(InvalidTransactionException::class);

        $this->assertTrue($validator->check());

    }
}