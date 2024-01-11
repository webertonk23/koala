<?php
	set_time_limit(6000);
	include("../_app/config.inc.php");
	
	$Read = new Read;
	$Update = new Update;
	
	
	$Read->FullRead("
		SELECT
			numero_venda,
			cpfcnpj_pes,
			dtaltstatus_venda,
			status_venda
		FROM
			Vendas INNER JOIN pessoas ON IDPES_VENDA = ID_PES
		WHERE
			--numero_venda = 67271390
			codprod_venda IS NULL OR  status_venda = 'Pendente'
			
		ORDER BY 
			dtvenda_venda DESC
	"
	, "");
	
	$Ade = $Read->GetResult();
	foreach($Ade As $V){
		$Bmg = new Bmg();
		$Bmg->buscaAdesao(trim($V['numero_venda']), trim($V['cpfcnpj_pes']));
		echo "Ade: {$V['numero_venda']}, CPF: {$V['cpfcnpj_pes']}<br>\r\n";
		unset($Dados);
 		
		if($Bmg->Erro){
			var_dump($Bmg->Erro);
		}else{
			$Val = $Bmg->Result[0];
			
			if(in_array($Val->statusCodigo, [4, 7])){
				echo ": )(";
				$Dados["status_venda"]  = ($Val->statusCodigo == 4) ? 'Paga' : 'Cancelada';
				$Dados["dtaltstatus_venda"] = ($V['status_venda'] == $Dados["status_venda"]) ? $V['dtaltstatus_venda'] : date("Y-m-d");
			}
			
			$Dados['codprod_venda'] = $Val->produto;
			$Dados['prazo_venda'] = $Val->coeficiente->quantidadePrestacoes;
			$Dados['valor_venda'] = $Val->valorLiberado;
			$Dados['dtvenda_venda'] = str_replace("T", " ", trim($Val->data, "Z"));
			
			var_dump($Dados);
			
			echo "Alterando status ADE: {$Val->numero}<br>\r\n";
			
			$Update->ExeUpdate("vendas", $Dados, "WHERE numero_venda = :Ade", "Ade={$Val->numero}");
		}
		unset($Bmg);
	}