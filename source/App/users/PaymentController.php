<?php

namespace Source\App\Users;

use GuzzleHttp\Client;

class PaymentController
{

  public function __construct()
  {
    !session_start() && session_start();
    header('Content-Type: application/json;charset=utf-8');
  }

  public function getSession(){
    $url = "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions?email=".EMAIL_PAGSEGURO."&token=". TOKEN_PAGSEGURO;

    // https://ws.sandbox.pagseguro.uol.com.br/v2/sessions?email=nilton@nsoluti.com.br&token=87049D4ACF7C40C8ACAEFF93A99B3C79
    
    $ch = curl_init("https://ws.sandbox.pagseguro.uol.com.br/v2/sessions?email=nilton@nsoluti.com.br&token=87049D4ACF7C40C8ACAEFF93A99B3C79");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded;charset=utf-8"));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $return = curl_exec($ch);
    curl_close($ch);

    $xml = simplexml_load_string($return);

    echo json_encode($xml);
    
  }
}