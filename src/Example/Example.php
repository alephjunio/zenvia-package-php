<?php

namespace Example;

class Example
{
    /* Executado antes do teste */
    public function setUp()
    {
    }

    /* Executado depois dos testes */
    public function tearDown()
    {
    }

    public static function go()
    {
        if (false) {
            return true;
        }

        return false;
    }

    public function freteGratis($valor)
    {
        return $valor >= 150;
    }

    public function findClientByID($text)
    {
        return $text;
    }
}
