<?php

namespace ZenviaSDK\Lib\Channels;

class SmsChannel extends AbstractChannel {

    /**
     * @var array
     */
    private $supportedContents = [];
    
    /**
    * @param string $token
    */
    public function __construct($token) {
        parent::__construct($token, 'sms');
        $this->supportedContents = ['text'];
    }

    protected function contentSupportValidation($content) {
        if(!in_array($content->type, $this->supportedContents)) {
            throw new \Exception('Content of ' . $content->type . ' is not supported in SMS channel');
        }
    }
   
}