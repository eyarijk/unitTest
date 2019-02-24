<?php

namespace MrEvrey\Unit\Tests;

use MrEvrey\Unit\ValidatorChain;
use MrEvrey\Unit\ValidatorInvalidArgumentException;
use MrEvrey\Unit\ValidatorNotFoundException;
use MrEvrey\Unit\Validators\EmailValidator;
use MrEvrey\Unit\Validators\IpValidator;
use MrEvrey\Unit\Validators\UrlValidator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    /**
     * @dataProvider validValidatorDataProvider
     *
     * @param string $validator
     * @param string $argument
     * @throws ValidatorNotFoundException
     */
    public function testValidArguments(string $validator,string $argument): void
    {
        $validatorChain = $this->createValidatorChain();

        $isValid = $validatorChain->getValidator($validator)->validate($argument);

        $this->assertTrue($isValid);
    }

    /**
     * @dataProvider invalidValidatorDataProvider
     *
     * @param string $validator
     * @param string $argument
     * @throws ValidatorNotFoundException
     */
    public function testInvalidArguments(string $validator,string $argument): void
    {
        $validatorChain = $this->createValidatorChain();

        $isValid = $validatorChain->getValidator($validator)->validate($argument);

        $this->assertFalse($isValid);
    }

    /**
     * @throws ValidatorNotFoundException
     */
    public function testSuccessEmailValidator(): void
    {
        $validatorChain = $this->createValidatorChain();

        $isValid = $validatorChain->getValidator('emailValidator')->validate('test@gmail.com');

        $this->assertTrue($isValid);
    }

    /**
     * @throws ValidatorNotFoundException
     */
    public function testFailEmailValidator(): void
    {
        $validatorChain = $this->createValidatorChain();

        $isValid = $validatorChain->getValidator('emailValidator')->validate('test');

        $this->assertFalse($isValid);
    }

    /**
     * @throws ValidatorNotFoundException
     */
    public function testExceptionTestEmailValidator(): void
    {
        $validatorChain = $this->createValidatorChain();

        $this->expectException(ValidatorNotFoundException::class);

        $validatorChain->getValidator(md5(time()))->validate('test@gmail.com');
    }

    /**
     * @throws ValidatorNotFoundException
     */
    public function testInvalidArgumentExceptionEmailValidator(): void
    {
        $validatorChain = $this->createValidatorChain();

        $this->expectException(ValidatorInvalidArgumentException::class);

        $validatorChain->getValidator('emailValidator')->validate(new \stdClass());
    }

    /**
     * @throws ValidatorNotFoundException
     */
    public function testSuccessIpValidator(): void
    {
        $validatorChain = $this->createValidatorChain();

        $isValid = $validatorChain->getValidator('ipValidator')->validate('127.0.0.1');

        $this->assertTrue($isValid);
    }

    /**
     * @throws ValidatorNotFoundException
     */
    public function testFailIpValidator(): void
    {
        $validatorChain = $this->createValidatorChain();

        $isValid = $validatorChain->getValidator('ipValidator')->validate('256.256.256.256');

        $this->assertFalse($isValid);
    }

    /**
     * @throws ValidatorNotFoundException
     */
    public function testSuccessUrlValidator(): void
    {
        $validatorChain = $this->createValidatorChain();

        $isValid = $validatorChain->getValidator('urlValidator')->validate('https://google.com');

        $this->assertTrue($isValid);
    }

    /**
     * @throws ValidatorNotFoundException
     */
    public function testFailUrlValidator(): void
    {
        $validatorChain = $this->createValidatorChain();

        $isValid = $validatorChain->getValidator('urlValidator')->validate('google.com');

        $this->assertFalse($isValid);
    }

    /**
     * @return iterable
     */
    public function validValidatorDataProvider(): iterable
    {
        return [
            ['urlValidator','https://google.com'],
            ['ipValidator', '127.0.0.1'],
            ['emailValidator', 'test@gmail.com'],
        ];
    }

    /**
     * @return iterable
     */
    public function invalidValidatorDataProvider(): iterable
    {
        return [
            ['urlValidator','google.com'],
            ['ipValidator', '256.256.256.256'],
            ['emailValidator', 'test'],
        ];
    }

    /**
     * @return ValidatorChain
     */
    private function createValidatorChain(): ValidatorChain
    {
        $validatorChain = new ValidatorChain();

        $validatorChain->addValidator(new IpValidator());
        $validatorChain->addValidator(new UrlValidator());
        $validatorChain->addValidator(new EmailValidator());

        return $validatorChain;
    }
}
