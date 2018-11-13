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
$sms->sendMany($array,'TESTE','201-10-19');

echo "<hr />";



$sms2 = new Zenvia('teste','teste');
$sms2->searchSmsReceived('2010-12-20','2018-12-20','551199998877',0001);


echo "<hr />";


$sms3 = new Zenvia('teste','teste');
$sms3->allReceived();
echo "<hr />";


$sms4 = new Zenvia('teste','teste');
$sms4->getStatus(0001);
echo "<hr />";


$sms5 = new Zenvia('teste','teste');
$sms5->cancelSms(0001);
