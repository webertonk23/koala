<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="Weberton Kaic">
		<meta http-equiv="refresh" content="1">
	</head>
<?php
	set_time_limit(18000);

	include "../_app/config.inc.php";
	
	$Xml = new TrataXml;
	$Vonix->GetResultFila();	
	$Xml->SetItens();

	//shell_exec("TASKKILL /f /IM chrome.exe");
	//shell_exec("TASKKILL /f /IM iexplore.exe");

?>
</html>