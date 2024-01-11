<?php
	set_time_limit(60000);
	$Read = new Read();
	
	$Read->FullRead("
		SELECT
			DISTINCT IdDisc_hist,
			CONVERT(char(10), DtOco_hist, 120) as Data
		FROM
			pessoas INNER JOIN Historico ON id_pes = IdPes_hist
			INNER JOIN fichas ON id_pes = IdPes_Ficha
			INNER JOIN carteira ON IdCart_Ficha = id_cart
			INNER JOIN tabulacao ON IdTab_hist = id_tab
		WHERE
			cidade_pes = 'Grao Mogol'
			AND IdDisc_hist IS NOT NULL
			AND id_cart = 16
			AND tabulacao_tab = 'Atendida'
	", "");

	foreach($Read->GetResult() as $v){
		$d = explode("-", $v["Data"]);
		
		$Result = array("sucesso" => 0, "erro" => 0, "lista_erros" => "");
		
		$s = "\\\\10.20.10.247\\vonix.$\\{$d['0']}\\{$d['1']}\\{$d['2']}\\${v['IdDisc_hist']}.wav";
		if (!copy($s, "\\\\10.20.10.201\\Audios\\${v['IdDisc_hist']}.wav")){
			$Result['erro'] += 1;
			$Result['lista_erros'] .= "{$s}<br>";
		}else{
			$Result['sucesso'] += 1;
		}	
	}
	
	echo "<h5>sucessos: {$Result['sucesso']}, Erros: {$Result['erro']}</h5>";
	Echo "<p>Lista de erros:<br>{$Result['lista_erros']}</p>";
?>