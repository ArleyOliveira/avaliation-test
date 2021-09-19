<?php

namespace Tests\AppBundle\Middleware;

use AppBundle\Entity\Wallet;
use AppBundle\Exceptions\InvalidTransactionException;
use AppBundle\Middleware\CheckIfWalletHasAvailableValueMiddleware;
use PHPUnit\Framework\TestCase;

class CheckIfWalletHasAvailableValueMiddlewareTest extends TestCase
{
    /**
     * @var Wallet
     */
    private $wallet;

    protected function setUp()
    {
        $this->wallet = $this->createMock(Wallet::class);
    }


    /**
     * @test
     */
    public function shouldBeValidWhenAvailableValue() {
        $availableValue = 100;
        $requestValue = 50;

        $this->wallet
            ->method('getAvailableValue')
            ->willReturn($availableValue)
        ;

        $middleware = new CheckIfWalletHasAvailableValueMiddleware($this->wallet, $requestValue);
        $hasAvailableValue = $middleware->check();
        $this->assertTrue($hasAvailableValue);
    }

    /**
     * @test
     */
    public function shouldThrowInvalidTransactionExceptionWhenNotAvailableValue() {
        $availableValue = 50;
        $requestValue = 100;

        $this->wallet
            ->method('getAvailableValue')
            ->willReturn($availableValue)
        ;

        $middleware = new CheckIfWalletHasAvailableValueMiddleware($this->wallet, $requestValue);

        $this->expectException(InvalidTransactionException::class);

        $middleware->check();
    }
}