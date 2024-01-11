<?php
	$Dir = "./Retorno/";

	$diretorio = dir($Dir);
		
	while($arquivo = $diretorio->read()){
		if(substr($arquivo,-4) == ".xml"){
			
			echo "<pre>";
			var_dump(json_decode(json_encode($xml = simplexml_load_file($Dir.$arquivo)), true));
			echo "</pre>";
			
			print_r(json_decode(json_encode($xml = simplexml_load_file($Dir.$arquivo))), true);
		}
	}
?>