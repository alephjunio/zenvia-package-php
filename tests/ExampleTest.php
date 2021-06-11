<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Example\Example;
use Example\Currency;

class ExampleTest extends TestCase
{
    public function testExample()
    {
        $result = Example::go();
        $this->assertFalse($result, 'Retorno Falso');
    }


    public function testFreteGratis()
    {
        $compra = new Example();
        $this->assertTrue($compra->freteGratis(150));
    }

    public function testFreteGratisExcecao()
    {
        $compra = new Example();
        $this->expectException(\ArgumentCountError::class);
        $compra->freteGratis();
    }

    public function testFindClientById()
    {
        $clientDao = new Example();
        $this->assertNotNull($clientDao->findClientByID(552));
    }

}
