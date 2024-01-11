<?php
	if(empty($_GET['p'])){
		require('\\\\10.20.10.247\\htdocs\\KoalaCRM\\_app\\Config.inc.php');
	}
	
	//var_dump($_SERVER);
	
	set_time_limit(60000);
	
	$Read = new Read();
	$Update = new Update();
	
	$Read->ExeRead("Pessoas INNER JOIN fichas ON id_pes = idpes_ficha", "WHERE idcart_ficha = 19 AND Contrato_Ficha != '0' AND final_ficha = 0 AND ArqInc_Ficha = 'ASA_SAQUE_2020.csv'", "");
	
	foreach($Read->GetResult() as $Values){
		$Cpf = $Values['CpfCnpj_Pes'];
		$matricula = $Values['Contrato_Ficha'];
		$Bmg = new Bmg();
		
		$Bmg->buscarCartoesDisponiveis($Cpf);
		$BuscaCard = $Bmg->getResult()['Body'];
		
		if(!empty($BuscaCard["buscarCartoesDisponiveisResponse"]["buscarCartoesDisponiveisReturn"]["cartoesRetorno"]["cartoesRetorno"])){
			$a = $BuscaCard["buscarCartoesDisponiveisResponse"]["buscarCartoesDisponiveisReturn"]["cartoesRetorno"]["cartoesRetorno"];
			if(!empty($a["liberado"])){
				
				$Bmg->buscarLimiteSaque($Cpf,$matricula,$a["numeroContaInterna"]);
				$Saque = $Bmg->getResult()['Body']["buscarLimiteSaqueResponse"]["buscarLimiteSaqueReturn"];
				
				$Update->ExeUpdate("fichas", array('limite_ficha' => round($Saque["limiteCartao"], 2), 'limitesaque_ficha' => round($Saque["valorSaqueMaximo"], 2)), "WHERE id_ficha = :id", "id={$Values['Id_Ficha']}");
			}else{
				$Update->ExeUpdate("fichas", array('limite_ficha' => 0, 'limitesaque_ficha' => 0), "WHERE id_ficha = :id", "id={$Values['Id_Ficha']}");
			}
		}else{
			$Update->ExeUpdate("fichas", array('limite_ficha' => 0, 'limitesaque_ficha' => 0), "WHERE id_ficha = :id", "id={$Values['Id_Ficha']}");
		}
	}
?>

