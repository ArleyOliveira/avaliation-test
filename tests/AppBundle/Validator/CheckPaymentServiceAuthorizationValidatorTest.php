<?php

namespace Tests\AppBundle\Validator;

use AppBundle\Exceptions\Http\UnauthorizedHttpException;
use AppBundle\Service\Gateway\PaymentAuthorizerService;
use AppBundle\Validator\CheckPaymentServiceAuthorizationValidator;
use PHPUnit\Framework\TestCase;

class CheckPaymentServiceAuthorizationValidatorTest extends TestCase
{
    private $authorizer;

    protected function setUp()
    {
        $this->authorizer = $this->createMock(PaymentAuthorizerService::class);
    }

    /**
     * @test
     */
    public function shouldBeValidWhenAuthorize() {
        $this->authorizer
            ->method('isAuthorized')
            ->willReturn(true)
        ;

        $validator = new CheckPaymentServiceAuthorizationValidator($this->authorizer);

        $this->assertTrue($validator->check());
    }

    /**
     * @test
     */
    public function shouldThrowUnauthorizedHttpExceptionWhenNotAuthorize() {
        $this->authorizer
            ->method('isAuthorized')
            ->willReturn(false)
        ;

        $validator = new CheckPaymentServiceAuthorizationValidator($this->authorizer);

        $this->expectException(UnauthorizedHttpException::class);

        $validator->check();
    }
}