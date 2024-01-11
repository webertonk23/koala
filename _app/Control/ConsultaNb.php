<?php
	require('../Config.inc.php');
	
	$NB = $_GET['NB'];
	
	$Link = "http://ws.inss.contatoplus.com/api/hiscre/{$NB}?apiKey=SkHUlG7j2yJqv6Mcd6Cfwp6TWOCG7KN3tl6qCRDTqOwTiifx7XrYL9fxMENdZxKv";
	
	$cURL = curl_init($Link);
	curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
	$resultado = curl_exec($cURL);
	curl_close($cURL);
	
	echo $resultado;
	
?>