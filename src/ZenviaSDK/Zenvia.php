<?php

namespace ZenviaSDK;

use ZenviaSDK\Client;
use ZenviaSDK\Lib\Contents\TextContent;

class Zenvia
{
    private $client;
    private $contents = [];
    private $channel;

    /**
    * @param string $token
    */
    public function __construct($token) {
        $this->client = new Client($token);
    }

    public function getChannel($channel) {
        //Choosing the channel
        $this->channel = $this->client->getChannel($channel);
    }

    public function addContent($text = '') {
        $this->contents[] = new TextContent($text);
    }

    public function send($from, $to) {
        $this->channel->sendMessage($from, $to, $this->contents);
        $this->contents = [];
    }
    
}