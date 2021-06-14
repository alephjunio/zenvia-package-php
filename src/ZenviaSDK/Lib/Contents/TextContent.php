<?php

namespace ZenviaSDK\Lib\Contents;

class TextContent {

    /**
     * @var string
     */
    public $text;
    
    /**
    * @param string $text
    */
    public function __construct($text = '') {
        $this->text = $text;
        $this->type = 'text';
    }
}