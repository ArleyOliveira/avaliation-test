<?php

namespace Tests\AppBundle\Validator;

use AppBundle\Entity\Wallet;
use AppBundle\Exceptions\InvalidTransactionException;
use AppBundle\Validator\CheckIfWalletHasAvailableValueValidator;
use PHPUnit\Framework\TestCase;

class CheckIfWalletHasAvailableValueValidatorTest extends TestCase
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

        $malidator = new CheckIfWalletHasAvailableValueValidator($this->wallet, $requestValue);
        $hasAvailableValue = $malidator->check();
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

        $malidator = new CheckIfWalletHasAvailableValueValidator($this->wallet, $requestValue);

        $this->expectException(InvalidTransactionException::class);

        $malidator->check();
    }
}