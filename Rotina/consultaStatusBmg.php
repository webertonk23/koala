<?php	
	include("../_app/config.inc.php");
	
	$Read = new Read;
	$Update = new Update;
	$Bmg = new Bmg();
	
	$Read->FullRead("SELECT numero_venda FROM Vendas WHERE status_venda = 'Pendente' ORDER BY dtvenda_venda DESC", "");
	
	$Ade = array();
	foreach($Read->GetResult() As $Val){
		array_push($Ade, $Val['numero_venda']);
	}
	
	$Ade = array_unique($Ade);
	
	$Ade = array_chunk($Ade, 1000);
	
	foreach($Ade As $V){
		$Bmg->Status($V);
		
		if($Bmg->Erro){
			var_dump($Bmg->Erro);
		}else{
			foreach($Bmg->Result->listaStatus As $Val){
				if(in_array($Val->codigoStatus, [4, 7])){
					echo "Alterando status ADE: {$Val->numero}<br>\r\n";
					
					$Dados["Status_venda"] = ($Val->status == "Crédito Enviado") ? 'Paga' : 'Cancelada';
					$Dados["dtaltstatus_venda"] = date("Y-m-d");
					
					$Update->ExeUpdate("vendas", $Dados, "WHERE numero_venda = :Ade", "Ade={$Val->numero}");
					
				}
			}
		}
	}