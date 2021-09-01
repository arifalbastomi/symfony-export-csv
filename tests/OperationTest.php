<?php
namespace App\Tests;
use App\Command\Operation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OperationTest extends KernelTestCase
{
    function testAdd()
    {
        $operation = new Operation();
        $result = $operation->add(4, 5);
        $this->assertEquals(9, $result);
    }

    function testMinus()
    {
        $operation = new Operation();
        $result = $operation->minus(10, 3);
        $this->assertEquals(7, $result);
    }

    function testDivide()
    {
        $operation = new Operation();
        $result = $operation->divide(100, 2);
        $this->assertEquals(50, $result);
    }

    function testMultiple()
    {
        $operation = new Operation();
        $result = $operation->multiple(6, 3);
        $this->assertEquals(18, $result);
    }
}

