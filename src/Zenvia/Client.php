<?php

namespace Zenvia;

class Client
{
    /**
     * @var string
     */
    private $token;

    /**
    * @param string $token
    */
    public function __construct($token) {
        $this->token = $token;
    }

    public function getMessagesReportClient() {
        return 'teste';
    }
    
}