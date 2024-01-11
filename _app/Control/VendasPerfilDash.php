<?php
	require_once('../Config.inc.php');
	
	$DataDe = $_GET['DataDe']." 00:00:00";
	$DataAte = $_GET['DataAte']." 23:59:59";
	
	// var_dump($DataDe, $DataAte);
	
	$r = '';
	
	$r .= (!empty($_GET['Prod'])) ? " AND idprod_venda = '{$_GET['Prod']}'" : '';
	
	$Read = new Read;
	
	switch($_GET['q']){
	
		case 'uf':
			
			$Read->FullRead("
				SELECT DISTINCT
					CONCAT('BR-', Upper(Estado_Pes)) AS id,
					COUNT (*) AS 'value'
				FROM
					Vendas INNER JOIN Pessoas ON idpes_venda = Id_pes
				WHERE
					dtvenda_venda BETWEEN '{$DataDe}' AND '{$DataAte}'
					$r
				GROUP BY
					Estado_Pes
				ORDER BY
					value DESC
			");
		break;
		
		case 'sexo':
			$Read->FullRead("
				SELECT DISTINCT
					CASE Sexo_Pes WHEN 'M' THEN 'Masculino' ELSE CASE Sexo_Pes WHEN 'F' THEN 'Feminino' ELSE 'Indefinido' END END As sexo,
					COUNT (*) AS 'value'
				FROM
					Vendas INNER JOIN Pessoas ON idpes_venda = Id_pes
				WHERE
					dtvenda_venda BETWEEN '{$DataDe}' AND '{$DataAte}'
					$r
				GROUP BY
					Sexo_pes
				ORDER BY
					value DESC
			");
		break;
		
		case 'idade':
			$Read->FullRead("
				SELECT DISTINCT
					idade,
					COUNT (*) AS 'value'
				FROM
					Vendas INNER JOIN Pessoas ON idpes_venda = Id_pes
				CROSS APPLY (
					SELECT 
						CASE WHEN DATEDIFF(YEAR,DtNasc_Pes,DtVenda_Venda) BETWEEN 0 AND 59 THEN 'De 0 a 59'
						WHEN DATEDIFF(YEAR,DtNasc_Pes,DtVenda_Venda) BETWEEN 60 AND 65 THEN 'De 60 a 65'
						WHEN DATEDIFF(YEAR,DtNasc_Pes,DtVenda_Venda) BETWEEN 66 AND 70 THEN 'De 66 a 70'
						WHEN DATEDIFF(YEAR,DtNasc_Pes,DtVenda_Venda) BETWEEN 71 AND 75 THEN 'De 71 a 75'
						ELSE 'Apartir de 76' END as Idade
				) as idade
				
				WHERE
					dtvenda_venda BETWEEN '{$DataDe}' AND '{$DataAte}'
					$r
				GROUP BY
					Idade
				ORDER BY
					value DESC
			");
		break;
	
	}

	//Debug($Read);
	
	if($Read->GetRowCount()>0){
		echo json_encode($Read->GetResult());
	}
?>