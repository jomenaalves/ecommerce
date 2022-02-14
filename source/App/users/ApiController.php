<?php

namespace Source\App\Users;

use Exception;
use Source\Utils\BD;
use Source\App\CorreiosController;

class ApiController
{

  public function __construct()
  {
    !session_start() && session_start();
    header('Content-Type: application/json;charset=utf-8');
  }

  // Metódo responsavel por fazer a autentificação do administrador
  public function loginAdmin(array $data)
  {

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $passwd = $_POST['passwd'];

    $data = (new BD)->getAdminByEmail($email);

    if ($data == []) {
      echo json_encode(['error' => true, 'message' => 'Email ou Senha não correspondem']);
      return;
    }

    if (password_verify($passwd, $data['passwd'])) {
      $_SESSION['idAdminLogged'] = $data['id'];
      echo json_encode(['error' => false, 'message' => 'ok']);
      return;
    }
    echo json_encode(['error' => true, 'message' => 'Email ou Senha não correspondem']);
  }

  public function cadProduct(array $data)
  {
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_EMAIL);
    $valor = $_POST['valor'];

    $insert = (new BD)->cadProduct($nome, $valor);
    echo json_encode($insert);
  }


  public function upProduct(array $data)
  {
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_EMAIL);
    $valor = $_POST['valor'];
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

    $insert = (new BD)->upProduct($nome, $valor, $id);
    echo json_encode($insert);
  }

  public function delProduct(array $data)
  {

    $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

    $insert = (new BD)->delProduct($id);
    echo json_encode($insert);
  }


  public function calcFrete(array $data)
  {
    $obCorreios = new CorreiosController();

    $frete = $obCorreios->calcFrete(COD_SERVICO, CEP_ORIGEM, $data['cep'], PESO, FORMATO, COMPRIMENTO, ALTURA, LARGURA, DIAMETRO);
   
    $error = strlen($frete->Erro) > 1 ? true : false;

    if(!$error){
      $this->setCEP($data['cep'], $frete->Valor);

      echo json_encode(['ok' => true]);
      return;
    }

    echo json_encode(['ok' => false]);
    return;

   
  }

  public function setCEP(String $cep, String $valor)
  {

    try{
      $_SESSION['cep'] = $cep;
      $_SESSION['valorFrete'] = $valor;

      return true;
    }catch(\Exception){
      return false;
    }

    return false;
  }

  public function removeCep()
  {
    try{
      unset($_SESSION['cep']);
      unset($_SESSION['valorFrete']);

      echo json_encode(true);
      return;
    }catch(\Exception){
      echo json_encode(false);
      return;
    }
  }


}
