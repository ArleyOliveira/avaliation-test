<?php

namespace Tests\AppBundle\Validator;

use AppBundle\Entity\LegalUser;
use AppBundle\Entity\PhysicalUser;
use AppBundle\Exceptions\InvalidUserException;
use AppBundle\Validator\CheckIfUserCanSendMoneyValidator;
use PHPUnit\Framework\TestCase;

class CheckIfUserCanSendMoneyValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeAbleToSendMoneyWhenItIsAnPhysicalUser() {
        $user = new PhysicalUser();

        $validator = new CheckIfUserCanSendMoneyValidator($user);

        $this->assertTrue($validator->check());
    }

    /**
     * @test
     */
    public function shouldThrowInvalidUserExceptionWhenItIsAnLegalUser() {
        $user = new LegalUser();

        $this->expectException(InvalidUserException::class);

        $validator = new CheckIfUserCanSendMoneyValidator($user);

        $validator->check();
    }
}