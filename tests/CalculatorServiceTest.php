<?php

namespace App\Tests;

use App\Services\Calculator\CalculateServiceFactory;
use App\Services\Calculator\Exception\DivisionByZeroException;
use App\Services\Calculator\OperationsEnum;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalculatorServiceTest extends KernelTestCase
{
    /**
     * @dataProvider dataProviderCalculate
     */
    public function testGetResult(
        string $operation,
        float $firstOperand,
        float $secondOperand,
        string $expectedResult
    ): void
    {
        $calculatorService = CalculateServiceFactory::create($operation);
        $result = $calculatorService->getResult($firstOperand, $secondOperand);
        $this->assertSame($expectedResult, $result);
    }

    public function testGetResultForNonExistedOperation(): void
    {
        $nonExistedOperation = '?';
        $this->expectException(\DomainException::class);
        $calculatorService = CalculateServiceFactory::create($nonExistedOperation);
        $calculatorService->getResult(1,1);
    }

    public function testGetResultDivideByZero(): void
    {
        $this->expectException(DivisionByZeroException::class);
        $calculatorService = CalculateServiceFactory::create('/');
        $calculatorService->getResult(1,0);
    }

    public function dataProviderCalculate(): array
    {
        return [
            [
                'operation' => OperationsEnum::PLUS->value,
                'firstOperand' => 10,
                'secondOperand' => 5,
                'expectedResult' => '10 + 5 = 15'
            ],
            [
                'operation' => OperationsEnum::MINUS->value,
                'firstOperand' => 10,
                'secondOperand' => 5,
                'expectedResult' => '10 - 5 = 5'
            ],
            [
                'operation' => OperationsEnum::MULTIPLY->value,
                'firstOperand' => 10,
                'secondOperand' => 5,
                'expectedResult' => '10 * 5 = 50'
            ],
            [
                'operation' => OperationsEnum::DIVIDE->value,
                'firstOperand' => 10,
                'secondOperand' => 5,
                'expectedResult' => '10 / 5 = 2'
            ],
        ];
    }
}
