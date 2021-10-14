<?php

namespace ZenviaSDK\Lib\Contents;

class TextContent extends AbstractContent{

    /**
     * @var string
     */
    public $text;
    
    /**
    * @param string $text
    */
    public function __construct($text = '') {
        parent::__construct('text');
        $this->text = $text;
    }
}