<?php

namespace Source\App;

class CorreiosController
{

  private $codEmpresa = '';
  private $senhaEmpresa = '';

  public function __construct(String $codEmpresa = '', String $senhaEmpresa = '')
  {

    $this->codEmpresa = $codEmpresa;
    $this->senhaEmpresa = $senhaEmpresa;
  }

  public function calcFrete(
    String $codigoServico,
    String $cepOrigem,
    String $cepDestino,
    Float $peso,
    Int $formato,
    Int $comprimento,
    Int $altura,
    Int $largura,
    Int $diametro = 0,
    Bool $maoPropia = false,
    Int $valorDeclarado = 0,
    Bool $avisoRecebimento = false
  ) {


    $paramsUrl = [
      'nCdEmpresa' => $this->codEmpresa,
      'sDsSenha' => $this->senhaEmpresa,
      'nCdServico' => $codigoServico,
      'sCepOrigem' => $cepOrigem,
      'sCepDestino' => $cepDestino,
      'nVlPeso' => $peso,
      'nCdFormato' => $formato,
      'nVlComprimento' => $comprimento,
      'nVlAltura' => $altura,
      'nVlLargura' => $largura,
      'nVlDiametro' => $diametro,
      'sCdMaoPropria' => $maoPropia ? 'S' : 'N',
      'nVlValorDeclarado' => $valorDeclarado,
      'sCdAvisoRecebimento' => $avisoRecebimento ? 'S' : 'N',
      'StrRetorno' => 'xml'
    ];

    $query = http_build_query($paramsUrl);

    $baseURL = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
    $result = $this->get($baseURL . $query);

    return $result ? $result->cServico : false;
  }

  public function get($url)
  {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $response = curl_exec($ch);
    curl_close($ch);


    return strlen($response) ? simplexml_load_string($response) : null;
  }
}
