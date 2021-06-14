<?php

namespace ZenviaSDK;

use ZenviaSDK\Lib\Channels\SmsChannel;

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

    public function getChannel($channel) {
        switch ($channel) {
            case 'sms': 
                return new SmsChannel($this->token);
                break;
            default:
                throw new \Exception('Unsupported channel');
        }
    }
    
}