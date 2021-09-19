<?php

namespace Tests\AppBundle\Validator;

use AppBundle\Entity\Wallet;
use AppBundle\Exceptions\InvalidTransactionException;
use AppBundle\Validator\CheckIfWalletIsNotNullValidator;
use PHPUnit\Framework\TestCase;

class CheckIfWalletIsNotNullValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeValidWhenNotNull() {
        $wallet = new Wallet();

        $malidator = new CheckIfWalletIsNotNullValidator($wallet);

        $this->assertTrue($malidator->check());
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