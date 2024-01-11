<?php 
	set_time_limit(6000);
	require('../_app/Config.inc.php');
	
	$Read = new Read;

	$Read->ExeRead("Fila", "WHERE Ativo_fila = 1 AND Discador_fila = 'Vonix' AND Cart_fila IS NOT NULL");
	
	echo ($Read->GetRowCount() > 0) ? json_encode($Read->GetResult()) : ''; 
?>