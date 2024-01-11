<?php
	include "../_app/config.inc.php";
	
	$Read = new read();
	$Read->ExeRead('fila', "ORDER BY Ativo_fila DESC, Id_fila ASC");
	if($Read->GetRowCount()>0){
		$Fila = array();

		foreach($Read->GetResult() as $Key => $Values){
			if(!in_array($Values['iddisc_fila'], $Fila)){
				$Fila[] = trim($Values['iddisc_fila']);
			}
		}
	}
	array_unique($Fila);
	array_filter($Fila);
	$Fila = array_unique(array_filter($Fila));

	foreach($Fila as $Value){
		$Vonix->LimparFila($Value);
	}

?>