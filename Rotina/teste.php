<?php

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => "http://www.buscacep.correios.com.br/sistemas/buscacep/resultadoBuscaEndereco.cfm",
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => array('CEP' => '39404704'),
	CURLOPT_RETURNTRANSFER => true
));

$response = curl_exec($curl);

curl_close($curl);
libxml_use_internal_errors(true);
$dom = new DOMDocument();
$dom->loadHTML($response);

$End = array(
	'logra' => trim(html_entity_decode($dom->getElementsByTagName('td')->item(0)->nodeValue), " \t\n\r\0\x0B\xC2\xA0"),
	'bairro' => trim(html_entity_decode($dom->getElementsByTagName('td')->item(1)->nodeValue), " \t\n\r\0\x0B\xC2\xA0"),
	'cidade' => explode("/", trim(html_entity_decode($dom->getElementsByTagName('td')->item(2)->nodeValue), " \t\n\r\0\x0B\xC2\xA0"))[0],
	'uf' => explode("/", trim(html_entity_decode($dom->getElementsByTagName('td')->item(2)->nodeValue), " \t\n\r\0\x0B\xC2\xA0"))[1],
	'cep' => str_replace("-", "", trim(html_entity_decode($dom->getElementsByTagName('td')->item(3)->nodeValue), " \t\n\r\0\x0B\xC2\xA0"))
);

var_dump($End);