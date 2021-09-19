<?php

namespace Tests\AppBundle\Validator;

use AppBundle\Entity\PhysicalUser;
use AppBundle\Validator\CheckIfPayerAndPayeeAreEqualsValidator;
use PHPUnit\Framework\TestCase;

class CheckIfPayerAndPayeeAreEqualsValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeValidWhenUsersAreDifferent() {
        $payer = $this->createMock(PhysicalUser::class);
        $payer
            ->method('getId')
            ->willReturn(1)
        ;

        $payee = $this->createMock(PhysicalUser::class);
        $payee
            ->method('getId')
            ->willReturn(2)
        ;

        $validator = new CheckIfPayerAndPayeeAreEqualsValidator($payer, $payee);

        $this->assertTrue($validator->check());
    }
}