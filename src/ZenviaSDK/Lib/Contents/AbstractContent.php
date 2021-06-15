<?php

namespace ZenviaSDK\Lib\Contents;

class AbstractContent {

    /**
     * @var string
     */
    public $type;
    
    public function __construct($type)
    {
        $this->type = $type;
    }
}