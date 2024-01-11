<?php
	require('../Config.inc.php');
	
	$Read = new Read;
	$Fila = $_GET['Fila'];
	
	switch ($_GET['Q']){
		case 1:
			$Read->FullRead("
				SELECT
					DISTINCT id_pes,
					nome_pes
				FROM
					Pessoas INNER JOIN fichas ON Id_Pes = IdPes_Ficha
				WHERE
					IdFila_ficha = 43
					AND Final_ficha = 0
					AND DtProxAcio_Ficha <= GETDATE()
			");

			echo trim(json_encode($Read->GetResult()));
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