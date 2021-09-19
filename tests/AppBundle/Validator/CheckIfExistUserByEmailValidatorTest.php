<?php

namespace Tests\AppBundle\Validator;

use AppBundle\Entity\PhysicalUser;
use AppBundle\Exceptions\InvalidUserException;
use AppBundle\Repository\PersonUserRepository;
use AppBundle\Validator\CheckIfExistUserByEmailValidator;
use PHPUnit\Framework\TestCase;

class CheckIfExistUserByEmailValidatorTest extends TestCase
{
    private $repository;

    protected function setUp()
    {
        $this->repository = $this->createMock(PersonUserRepository::class);
    }

    /**
     * @test
     */
    public function shouldBeValidWhenNotExist() {

        $this->repository
            ->method('findOneBy')
            ->willReturn(null)
        ;

        $validator = new CheckIfExistUserByEmailValidator(
           'email','email@test.com', 1, $this->repository
        );

        $this->assertTrue($validator->check());
    }

    /**
     * @test
     */
    public function shouldBeValidWhenExistButIgnoredUserBy() {
        $ignoreUserId = 1;
        $user = $this->createMock(PhysicalUser::class);
        $user
            ->method('getId')
            ->willReturn($ignoreUserId)
        ;

        $this->repository
            ->method('findOneBy')
            ->willReturn($user)
        ;

        $validator = new CheckIfExistUserByEmailValidator(
            'email','email@test.com', $ignoreUserId, $this->repository
        );

        $this->assertTrue($validator->check());
    }

    /**
     * @test
     */
    public function shouldThrowInvalidUserExceptionWhenExistUser() {
        $ignoreUserId = 1;

        $user = $this->createMock(PhysicalUser::class);
        $user
            ->method('getId')
            ->willReturn(3)
        ;

        $this->repository
            ->method('findOneBy')
            ->willReturn($user)
        ;

        $this->expectException(InvalidUserException::class);

        $validator = new CheckIfExistUserByEmailValidator(
            'email','email@test.com', $ignoreUserId, $this->repository
        );

        $validator->check();
    }
}