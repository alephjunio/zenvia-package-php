<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Zenvia\Client;

class ZenviaTest extends TestCase
{

    public function testGetMessagesReportClient() {
        $client = new Client('123');
        $this->assertNotNull($client->getMessagesReportClient(), 'Class return null');
    }

}