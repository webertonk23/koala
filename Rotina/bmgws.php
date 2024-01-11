<?php
	include("../_app/config.inc.php");
	
	$Read = new Read;
	$Bmg = new Bmg();
	$Update = new Update;
	
	//$Read->FullRead("SELECT TOP 1 cpf, ade FROM bordero WHERE Cod_Loja = 52849 AND Tabela IS NULL AND Servico != 'Cartao Bmg Master'", "");
	
	
	// if($Read->GetRowCount() > 0 ){
		// foreach($Read->GetResult() as $Values){
			// $Bmg->buscaAdesao($Values["ade"], $Values["cpf"]);
			// if($Bmg->Erro){
				// var_dump($Bmg->Erro);
			// }else{
				// echo "<pre>";
				// print_r($Bmg->Result[0]->produto);
				// echo "</pre>";
			// }
		// }
	// }
	
	
		
	// $Bmg->AddPropConsig();
	$Bmg->AddCardBmg();
	
	if($Bmg->Erro){
		var_dump($Bmg->Erro);
	}else{
		echo "<pre>";
		print_r($Bmg->Result);
		echo "</pre>";
	}
	
	
	
?>

