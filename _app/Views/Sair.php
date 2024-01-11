<?php
	$Vonix = new Vonix;
	$Vonix->SetItens();
	$Vonix->DeslogarAgent();
	
	
	
	$Update = new Update;
	
	$Logout['dtlogout_sess'] = date("Y-m-d H:i:s");
	$session = session_id();
	
	$Update->ExeUpdate('session', $Logout, "WHERE session_sess = :session AND iduser_sess = :iduser AND dtlogout_sess IS NULL", "session={$session}&iduser={$_SESSION['Usuario']['Id_user']}");
	
	unset($_SESSION['Usuario']);
	session_regenerate_id();
	
	
	Redirect('?p=Login'); 
?>