<?php

namespace Source\App\Users;

use GuzzleHttp\Client;
use Source\Utils\BD;

class PaymentController
{

  public function __construct()
  {
    !session_start() && session_start();
    header('Content-Type: application/json;charset=utf-8');
  }

  public function getSession()
  {
    $url = "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions?email=" . EMAIL_PAGSEGURO . "&token=" . TOKEN_PAGSEGURO;

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

  public function paymentCreditCard()
  {

    if (!isset($_SESSION['cep'])) {
      echo json_encode(['error' => true, 'message' => 'Informe um CEP']);
      exit;
    }

    $fretePrice =  str_replace(',', '.', $_SESSION['valorFrete']);
    // pegar dados do usuario
    $dataUser = (new BD)->getClient(1);

    // pegar produto escolhido
    $dataProduct = (new BD)->getProductByID($_POST['id']);

    $finalPrice = number_format($fretePrice + $dataProduct['valor'], '2', '.');

    $hash = $_POST['hash'];
    $tokenCart = $_POST['token'];

    $dadosArray['email'] = EMAIL_PAGSEGURO;
    $dadosArray['token'] = TOKEN_PAGSEGURO;

    $dadosArray['paymentMode'] = 'default';
    $dadosArray['senderHash'] = $hash;
    $dadosArray['creditCardToken'] = $tokenCart;
    $dadosArray['paymentMethod'] = 'creditCard';
    $dadosArray['receiverEmail'] = EMAIL_PAGSEGURO;
    $dadosArray['senderName'] = $dataUser['nome'];
    $dadosArray['senderAreaCode'] = $dataUser['area_code'];
    $dadosArray['senderPhone'] = $dataUser['phone_number'];
    $dadosArray['senderEmail'] = 'c73633009611656029901@sandbox.pagseguro.com.br';
    $dadosArray['senderCPF'] = $dataUser['cpf'];
    $dadosArray['installmentQuantity'] = '1';

    $dadosArray['installmentValue'] = $finalPrice;
    $dadosArray['creditCardHolderName'] = 'Nilton de Oliveira Figueiredo';
    $dadosArray['creditCardHolderCPF'] = '00580372847';
    $dadosArray['creditCardHolderBirthDate'] = '01/08/1997';
    $dadosArray['creditCardHolderAreaCode'] = '16';
    $dadosArray['creditCardHolderPhone'] = '999999999';
    $dadosArray['billingAddressStreet'] = 'Rua Tal';
    $dadosArray['billingAddressNumber'] = '150';
    $dadosArray['billingAddressDistrict'] = 'Centro';
    $dadosArray['billingAddressPostalCode'] = '14840000';
    $dadosArray['billingAddressCity'] = 'Guariba';
    $dadosArray['billingAddressState'] = 'SP';
    $dadosArray['billingAddressCountry'] = 'Brasil';
    $dadosArray['currency'] = 'BRL';
    $dadosArray['itemId1'] = '01';
    $dadosArray['itemQuantity1'] = '1';
    $dadosArray['itemDescription1'] = 'Descrição do item';
    $dadosArray['reference'] = $dataProduct['nome'];
    $dadosArray['shippingAddressRequired'] = 'false';
    $dadosArray['itemAmount1'] = $finalPrice;

    $data = http_build_query($dadosArray);
    $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions';


    $curl = curl_init();
    $headers = array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8');

    curl_setopt($curl, CURLOPT_URL, $url . "?email=" . EMAIL_PAGSEGURO);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    //curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_HEADER, false);
    $xml = curl_exec($curl);

    curl_close($curl);

    $xml = simplexml_load_string($xml);


    if ($xml->error) {
      echo json_encode(['error' => 'erro na translação']);
      return;
    }

    echo json_encode([
      'error' => false,
      'code' => $xml->code,
      'sender' => $xml->sender->name
    ]);
    return;
  }

  public function paymentBoleto()
  {
    if (!isset($_SESSION['cep'])) {
      echo json_encode(['error' => true, 'message' => 'Informe um CEP']);
      exit;
    }

    $fretePrice =  str_replace(',', '.', $_SESSION['valorFrete']);
    // pegar dados do usuario
    $dataUser = (new BD)->getClient(1);

    // pegar produto escolhido
    $dataProduct = (new BD)->getProductByID($_POST['id']);

    $finalPrice = number_format($fretePrice + $dataProduct['valor'], '2', '.');

    $hash = $_POST['hash'];

    $data['token'] = TOKEN_PAGSEGURO; //token sandbox test
    $data['paymentMode'] = 'default';
    $data['hash'] = $hash;
    $data['paymentMethod'] = 'boleto';
    $data['receiverEmail'] = EMAIL_PAGSEGURO;
    $data['senderName'] = $dataUser['nome'];
    $data['senderAreaCode'] = $dataUser['area_code'];
    $data['senderPhone'] = $dataUser['phone_number'];
    $data['senderEmail'] = 'c73633009611656029901@sandbox.pagseguro.com.br';
    $data['senderCPF'] = $dataUser['cpf'];
    $data['currency'] = 'BRL';
    $data['itemId1'] = '01';
    $data['itemQuantity1'] = '1';
    $data['itemDescription1'] = 'Descrição do produto';
    $data['reference'] = $dataProduct['nome'];
    $data['shippingAddressRequired'] = 'false';
    $data['itemAmount1'] = $finalPrice;

    $data = http_build_query($data);
    $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions';


    $curl = curl_init();

    $headers = array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8');

    curl_setopt($curl, CURLOPT_URL, $url . "?email=" . EMAIL_PAGSEGURO);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HEADER, false);
    $xml = curl_exec($curl);

    curl_close($curl);

    $xml = simplexml_load_string($xml);

    if ($xml->error) {
      echo json_encode(['error' => 'erro na translação']);
      return;
    }

    echo json_encode([
      'error' => false,
      'link' => $xml->paymentLink,
      'sender' => $xml->sender->name
    ]);
  }
}
