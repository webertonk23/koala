<?php
	include "../_app/config.inc.php";
	
	$Xml = new TrataXml;
	$Vonix->GetResultFila();	
	$Xml->SetItens();

?>