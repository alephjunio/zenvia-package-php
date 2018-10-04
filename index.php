<?php

spl_autoload_register(function($class){
  if (file_exists("$class.php")) {
    require "$class.php";
  }
});



$array = [
  '551199995555',
  '551199995555',
  '551199995555',
  '551199995555',
  '551199995555',
  '551199995555',
];

$sms = new Zenvia('teste','teste');
$sms->sendMany($array,'TESTE',10,05,2018,13,30);

echo "<hr />";

$dateStart = [
  'day'   => 25,
  'month' => 05,
  'year'  => 2015,
  'hour'  => 23,
  'min'   => 30,
  'second'=> 00
];

$dateEnd =   [
  'day'   => 25,
  'month' => 05,
  'year'  => 2015,
  'hour'  => 23,
  'min'   => 30,
  'second'=> 00
];

$sms2 = new Zenvia('teste','teste');
$sms2->searchSmsReceived($dateStart,$dateEnd,'551199998877',0001);


echo "<hr />";


$sms3 = new Zenvia('teste','teste');
$sms3->allReceived();
echo "<hr />";


$sms4 = new Zenvia('teste','teste');
$sms4->getStatus(0001);
echo "<hr />";


$sms5 = new Zenvia('teste','teste');
$sms5->cancelSms(0001);
