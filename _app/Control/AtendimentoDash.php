<?php
	require('../Config.inc.php');
	
	$Cart = (!empty($_GET['Cart'])) ? $_GET['Cart'] : 0;
	
	$Read = new Read;
	
	switch ($_GET['Q']){
		case 1:
			$Read->FullRead("
				SELECT
					COUNT(DISTINCT IdPes_hist) as 'Clientes',
					SUM(CASE sucesso_tab WHEN 1 THEN 1 ELSE 0 END) As 'Atendidas',
					SUM(CASE Cpc_tab WHEN 1 THEN 1 ELSE 0 END) As 'CPC',
					SUM(CASE Efetivo_tab WHEN 1 THEN 1 ELSE 0 END) As 'Efetivo'

				FROM
					Historico WITH (NOLOCK) INNER JOIN tabulacao ON IdTab_hist = id_tab
					INNER JOIN fichas ON IdFicha_hist = Id_Ficha
					LEFT JOIN fila ON IdDiscFila_hist = iddisc_fila					
				WHERE
					DtOco_hist BETWEEN '".date("Y-m-d 00:00:00")."' AND '".date("Y-m-d 23:59:59")."'
					AND IdCart_Ficha = {$Cart}
					AND Origem_tab = 'Operador'
			");

			if($Read->GetRowCount()>0){
				$Funil = $Read->GetResult()[0];
			}else{
				$Funil = '';
			}
			
			echo trim(json_encode($Funil));
		break;
		
		case 2:
			$Read->FullRead("
				SELECT
					Tabulacao_tab as Ocorrencia,
					COUNT(*) as Qtd 
				FROM
					Historico	INNER JOIN tabulacao ON IdTab_hist = Id_tab 
					INNER JOIN fichas ON IdFicha_hist = Id_Ficha
				WHERE
					Origem_tab = 'Discador' 
					AND DtOco_hist BETWEEN '".date("Y-m-d 00:00:00")."' AND '".date("Y-m-d 23:59:59")."'
					AND IdCart_Ficha = {$Cart}
				GROUP BY
					Tabulacao_tab
				ORDER BY Qtd DESC
			");
			
			if($Read->GetRowCount()>0){
				$Discador = $Read->GetResult();
			}else{
				$Discador = '';
			}
			
			echo trim(json_encode($Discador));
		break;
		
		case 3:
			$Read->FullRead("
				SELECT
					Tabulacao_tab as Ocorrencia,
					COUNT(*) as Qtd 
				FROM
					Historico	INNER JOIN tabulacao ON IdTab_hist = Id_tab 
					INNER JOIN fichas ON IdFicha_hist = Id_Ficha
				WHERE
					Origem_tab = 'Operador' 
					AND DtOco_hist BETWEEN '".date("Y-m-d 00:00:00")."' AND '".date("Y-m-d 23:59:59")."'
					AND IdCart_Ficha = {$Cart}
				GROUP BY
					Tabulacao_tab
				ORDER BY Qtd DESC
			");
			
			if($Read->GetRowCount()>0){
				$Operador = $Read->GetResult();
			}else{
				$Operador ='';
			}
			
			echo trim(json_encode($Operador));
		break;
	}
?>