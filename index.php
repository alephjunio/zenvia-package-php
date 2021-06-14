<?php
require 'src/autoload.php';

// Initialization with your API token (x-api-token)
$client = new ZenviaSDK\Client('q40Vp_AjKFn65boNgcZ_A7blZ65EDnewrGt4');

// Choosing the channel
$sms = $client->getChannel('sms');

// Creating a text content
$contents[] = new ZenviaSDK\Lib\Contents\TextContent('Teste Funcionou!');

try {
    echo $sms->sendMessage('wandering-hemisphere', '5511996457108', $contents);
}
catch(Exception $e) {
    echo 'Exceção capturada: ',  $e->getMessage(), "\n";
}