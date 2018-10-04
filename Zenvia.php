<?php

// use Model\SmsFacade;
// use Model\Sms;

spl_autoload_register(function($class){
  if (file_exists("Model/$class.php")) {
    require "Model/$class.php";
  }
  if (file_exists("RestClient/$class.php")) {
    require "RestClient/$class.php";
  }
});

class Zenvia
{

  private $username;
  private $token;
  private $url;


  public function __construct(String $username, String $token, String $url = null)
  {
    $this->username = $username;
    $this->token = $token;
    $this->url = $url;
  }

  public function authZenvia()
  {
    return new SmsFacade($this->username, $this->token, $this->url);
  }



  public function allReceived()
  {
    $smsFacade = $this->authZenvia();

    try {
      //Lista todas mensagens recebidas que ainda não foram consultadas. Retorna um objeto do tipo SmsReceivedResponse
      //que conterá as mensagens recebidas.
      $response = $smsFacade->listMessagesReceived();

      echo "Status: " . $response->getStatusCode() . " - " . $response->getStatusDescription();
      echo "\nDetalhe: " . $response->getDetailCode() . " - " . $response->getDetailDescription();

      if ($response->hasMessages()) {
        $messages = $response->getReceivedMessages();
        foreach ($messages as $smsReceived) {
          echo "\nCelular: " . $smsReceived->getMobile();
          echo "\nData de recebimento: " . $smsReceived->getDateReceived();
          echo "\nMensagem: " . $smsReceived->getBody();
          //Id da mensagem que originou a mensagem de resposta
          echo "\nId da mensagem de origem: " . $smsReceived->getSmsOriginId();
        }
      } else {
        echo "\nNão foram encontradas mensagens recebidas.";
      }
    } catch (\Exception $ex) {
      echo "Falha ao listar as mensagens recebidas. Exceção: " . $ex->getMessage() . "\n" . $ex->getTraceAsString();
    }

  }


  public  function send($to ,$message ,$day ,$month ,$year ,$hour ,$min )
  {
    $sms = new Sms();
    $sms->setTo($to);
    $sms->setMsg($message);
    $sms->setId(uniqid());
    $sms->setCallbackOption(Sms::CALLBACK_ALL);

    $date = new \DateTime();
    $date->setTimeZone(new DateTimeZone('America/Sao_Paulo'));
    $date->setDate($year, $month, $day);
    $date->setTime($hour, $min, 00);
    $schedule = $date->format("Y-m-d\TH:i:s");

    //Formato da data deve obedecer ao padrão descrito na ISO-8601. Exemplo "2015-12-31T09:00:00"
    $sms->setSchedule($schedule);

    try{

      $smsFacade = $this->authZenvia();

      //Envia a mensagem para o webservice e retorna um objeto do tipo SmsResponse com o status da mensagem enviada
      $response = $smsFacade->send($sms);

      echo "Status: ".$response->getStatusCode() . " - " . $response->getStatusDescription();
      echo "\nDetalhe: ".$response->getDetailCode() . " - " . $response->getDetailDescription();

      if($response->getStatusCode()!="00"){
        echo "\nMensagem não pôde ser enviada.";
      }

    }
    catch(\Exception $ex){
      echo "Falha ao fazer o envio da mensagem. Exceção: ".$ex->getMessage()."\n".$ex->getTraceAsString();
    }

  }



  public function sendMany(Array $array,$message,$day ,$month ,$year ,$hour ,$min)
  {

    $smsList = [];

    foreach ($array as $key => $value) {
      $sms = new Sms();
      $sms->setTo($array[$key]);
      $sms->setMsg($message);
      $sms->setId(uniqid());
      $sms->setCallbackOption(Sms::CALLBACK_ALL);

      $date = new \DateTime();
      $date->setTimeZone(new DateTimeZone('America/Sao_Paulo'));
      $date->setDate($year, $month, $day);
      $date->setTime($hour, $min, 00);
      $schedule = $date->format("Y-m-d\TH:i:s");

      //Formato da data deve obedecer ao padrão descrito na ISO-8601. Exemplo "2015-12-31T09:00:00"
      $sms->setSchedule($schedule);

      array_push($smsList, $sms);

    }

    try {
      $smsFacade = $this->authZenvia();

      //Envia a lista de mensagens para o webservice e retorna uma lista de objetos do tipo SmsResponse com os staus das mensagens enviadas
      $responseList = $smsFacade->sendMultiple($smsList);

      foreach ($responseList as $response) {
        echo "Status: " . $response->getStatusCode() . " - " . $response->getStatusDescription();
        echo "\nDetalhe: " . $response->getDetailCode() . " - " . $response->getDetailDescription() . "\n";
      }
    } catch (\Exception $ex) {
      echo "Falha ao fazer o envio das mensagens. Exceção: " . $ex->getMessage() . "\n" . $ex->getTraceAsString();
    }

  }





  public function searchSmsReceived(Array $dateOne,Array $dateTwoo,String $mobile,Int $smsId)
  {

    $date = new \DateTime();
    $date->setDate($dateOne['year'], $dateOne['month'], $dateOne['day']);
    $date->setTime($dateOne['hour'], $dateOne['min'], $dateOne['second']);

    //Formato da data deve obedecer ao padrão descrito na ISO-8601. Exemplo "2015-12-31T09:00:00".
    $startPeriod = $date->format("Y-m-d\TH:i:s");

    $date2 = new \DateTime();
    $date->setDate($dateTwoo['year'], $dateTwoo['month'], $dateTwoo['day']);
    $date->setTime($dateTwoo['hour'], $dateTwoo['min'], $dateTwoo['second']);
    //Formato da data deve obedecer ao padrão descrito na ISO-8601. Exemplo "2015-12-31T09:00:00".
    $endPeriod = $date2->format("Y-m-d\TH:i:s");

    try {

      $smsFacade = $this->authZenvia();
      //Pesquisa por mensagens recebidas que obedeçam ao filtro passado. Retorna um objeto do tipo SmsReceivedResponse
      //que conterá as mensagens recebidas.
      //Os parametros startPeriod e endPeriod são obrigatórios.
      //Os parametros mobile e smsId são opcionais.
      $response = $smsFacade->searchMessagesReceived($startPeriod, $endPeriod, $mobile, $smsId);

      echo "Status: " . $response->getStatusCode() . " - " . $response->getStatusDescription();
      echo "\nDetalhe: " . $response->getDetailCode() . " - " . $response->getDetailDescription();
      if ($response->hasMessages()) {
        $messages = $response->getReceivedMessages();
        foreach ($messages as $smsReceived) {
          echo "\nCelular: " . $smsReceived->getMobile();
          echo "\nData de recebimento: " . $smsReceived->getDateReceived();
          echo "\nMensagem: " . $smsReceived->getBody();
          //Id da mensagem que originou a mensagem de resposta
          echo "\nId da mensagem de origem: " . $smsReceived->getSmsOriginId();
        }
      } else {
        echo "\nNão foram encontradas mensagens recebidas.";
      }
    } catch (\Exception $ex) {
      echo "Falha ao pesquisar pelas mensagens recebidas. Exceção: " . $ex->getMessage() . "\n" . $ex->getTraceAsString();
    }

  }


  public function getStatus($smsId)
  {


    $smsFacade = $this->authZenvia();

    try {
      $response = $smsFacade->getStatus($smsId);
      //Código e descrição do status atual da mensagem
      echo "Status: " . $response->getStatusCode() . " - " . $response->getStatusDescription();
      //Código e descrição do detalhe do status atual da mensagem
      echo "\nDetalhe: " . $response->getDetailCode() . " - " . $response->getDetailDescription();
      if ($response->getStatusCode() == "00") {
        //Id da mensagem
        echo "\nId: " . $response->getId();
        //Data de recebimento da mensagem no celular
        echo "\nRecebido em: " . $response->getReceived();
      } else {
        echo "\nStatus da mensagem não pôde ser consultado.";
      }
    } catch (\Exception $ex) {
      echo "Falha ao fazer consulta de status da mensagem. Exceção: " . $ex->getMessage() . "\n" . $ex->getTraceAsString();
    }


  }

  public function cancelSms($smsId)
  {

    $smsFacade = $this->authZenvia();

    try {
      $response = $smsFacade->cancel($smsId);
      //09 - Blocked
      echo "Status: " . $response->getStatusCode() . " - " . $response->getStatusDescription();
      //002 - Message successfully canceled
      echo "\nDetalhe: " . $response->getDetailCode() . " - " . $response->getDetailDescription();
      if ($response->getStatusCode() != "00") {
        echo "\nMensagem não pôde ser cancelada.";
      }
    } catch (\Exception $ex) {
      echo "Falha ao fazer o cancelamento da mensagem. Exceção: " . $ex->getMessage() . "\n" . $ex->getTraceAsString();
    }

  }


}
