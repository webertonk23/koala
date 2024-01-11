<?php
	//Debug($_SERVER['HTTP_USER_AGENT']);
	
	// exec("arp -a {$_SERVER['REMOTE_ADDR']}", $output);
	// $IpMac = explode(" ", trim($output[3]));
		
	
	
	$Vonix->GetStatusfila('pesquisa11');
	
	// $Vonix->DeslogarAgent();
	
	// Debug($IpMac[10]);
	
	//$Vonix->LogarAgent(str_replace("-", "", $IpMac[10]));
	
	// $Vonix->PausaAgent(3);
	
	// $Vonix->DespausaAgent();
	
	// var_dump($Vonix->LimparFila('Pesquisa04'));
	
	var_dump($Vonix->Result["stored_contacts"]);	
	// $Check = new Check;
	


?>

