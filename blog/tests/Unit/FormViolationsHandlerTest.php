<?php

namespace App\Tests\Unit;

use App\Entity\User;
use App\Service\FormViolationsHandler;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class FormViolationsHandlerTest extends TestCase
{
    /** @test */
    public function shouldReturnEmptyArrayIfViolationsNoyExist()
    {
        $errors = $this->createMock(ConstraintViolationListInterface::class);
        $errors->expects($this->any())
            ->method('count')
            ->willReturn(0);

        $violationsMessages = new FormViolationsHandler();
        $result = $violationsMessages->getViolationMessages($errors);

        self::assertEquals(0, count($result));
    }

    /** @test */
    public function shouldReturnErrorMessage()
    {

        $expectedResult = 'Validation error';
        $message = $this->createMock(ConstraintViolationInterface::class);
        $message->expects($this->any())
            ->method('getMessage')
            ->willReturn('Validation error');

        $errors = $this->createMock(ConstraintViolationListInterface::class);
        $errors->expects($this->any())
            ->method('count')
            ->willReturn(2);
        $errors->expects($this->any())
            ->method('get')
            ->willReturn($message);

        $violationsMessages = new FormViolationsHandler();
        $result = $violationsMessages->getViolationMessages($errors);
        self::assertEquals($expectedResult, $result[0]);
    }
}