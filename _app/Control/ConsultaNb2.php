<?php
require('../Config.inc.php');

$NB = str_pad($_GET['NB'], 10, 0, STR_PAD_LEFT);
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://asnobrasil.com/server/consulta/{$NB}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer 352f7a0313ca0536bf379950890dd4410ebb02a18a3b6ef06c964edf233415d0689754"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$Dados = json_decode($response, true);



if(!empty($Dados['dados'][0]['margem']['margem_emprest'])){
	$Post['Margem_ficha'] = $Dados['dados'][0]['margem']['margem_emprest'];
}

if(!empty($Dados['dados'][0]['dadosEmprestimos']['emprestimosAtivos'])){
	$Post['QtdEmp_ficha'] = count($Dados['dados'][0]['dadosEmprestimos']['emprestimosAtivos']);
	$Post['DadosEmp_ficha'] = json_encode($Dados['dados'][0]['dadosEmprestimos']['emprestimosAtivos']);
}

if(!empty($Dados['dados'][0]['dadosContaCorrente'][0])){
	$Post['Banco_ficha'] = $Dados['dados'][0]['dadosContaCorrente'][0]['banco'];
	$Post['Agencia_ficha'] = $Dados['dados'][0]['dadosContaCorrente'][0]['agencia'];
	$Post['Cc_ficha'] = $Dados['dados'][0]['dadosContaCorrente'][0]['conta'];
}

if(!empty($Post)){
	$Update = new Update();
	
	$Update->ExeUpdate("fichas", $Post, "WHERE contrato_ficha = :NB", "NB={$_GET['NB']}");
}



echo $response;
