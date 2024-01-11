<?php
	set_time_limit(6000);
	require('../_app/Config.inc.php');
	$Insert = new Create;
	
	// $Fihas =  json_decode(file_get_contents('php://input'));
	
	$Fichas = (json_decode(file_get_contents('php://input'), true));
	
	$QtdContatos = (!$Fichas['fichas']) ? 0 : count($Fichas['fichas']);
	$Envio = ($QtdContatos > 0) ? $Vonix->SendFicha(trim($Fichas['fila']), $Fichas['fichas']) : null;
	
	if($Envio){
		$Resultado = json_decode($Envio, true);
		if($Resultado['status'] == 'imported'){
			$Not = (!empty($Resultado['not_imported_count'])) ? $Resultado['not_imported_count'] : 0;
			
			foreach($Fichas['fichas'] as $Values){
				$fd['Idpes_filad'] = explode("-", $Values['id'])[0];
				$fd['Descfila_filad'] = $Fichas['fila'];
			
				$Insert->ExeCreate('filadiscador', $fd);
			}
			
			echo "<tr>
					<td>{$Fichas['fila']}</td>
					<td>{$QtdContatos}</td>
					<td>{$Resultado['imported_count']}</td>
					<td>{$Not}</td>
					<td></td>
				<tr>";
			
		}else{
			echo "<tr>
					<td>{$Fichas['fila']}</td>
					<td>{$QtdContatos}</td>
					<td>0</td>
					<td>{$QtdContatos}</td>
					<td>{$Envio}</td>
				<tr>";
		}
	}

?>