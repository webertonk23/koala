<?php

	$path = "./retorno/tratados/";
	$diretorio = dir($path);
	 
	
	while($arquivo = $diretorio -> read()){
		$Dias = floor((strtotime(date("Y-m-d H:i:s")) - filectime($path.$arquivo)) / (60 * 60 * 24));
		
		if($Dias > 7){
			if(unlink($path.$arquivo)){
				echo "Arquivo ".$path.$arquivo." deletado com sucesso <br>";
			}else{
				echo "Erro ao Deletar arquivo: ".$path.$arquivo." <br>";
			}
		}
	}
	
	$diretorio -> close();

?>