<?php
	require('../Config.inc.php');
	
	$Cart = (!empty($_GET['Cart'])) ? $_GET['Cart'] : 0;
	
	$r = '';
	
	$r .= (!empty($_GET['Sup'])) ? " AND Supervisor = '{$_GET['Sup']}'" : '';
	$r .= (!empty($_GET['Prod'])) ? " AND idprod_venda = '{$_GET['Prod']}'" : '';
	
	$Read = new Read;
	
	$Read->FullRead("
		SELECT DISTINCT
			SUBSTRING(CONVERT(char(10), dtvenda_venda, 103), 0, 3) as Dia
		FROM
			vendas
		WHERE
			MONTH (dtvenda_venda) = MONTH (GETDATE()) AND YEAR (dtvenda_venda) = YEAR (GETDATE())
		ORDER BY Dia
	");
	
	if($Read->GetRowCount()>0){
		$Dias = "";
		foreach ($Read->GetResult() as $Values){
			$Dias .= (empty($Dias)) ? "[".$Values['Dia']."]" : ",[".$Values['Dia']."]";
		}
		
		$Read->FullRead("
			SELECT
				*
			FROM
				(
					SELECT
						DATEPART(day, dtvenda_venda) AS Dia,
						Nome_user,
						COUNT (*) AS Qtd
					FROM
						vendas INNER JOIN usuarios ON iduser_venda = id_user
						INNER JOIN Produto ON idprod_venda = id_prod
						INNER JOIN funcionarios ON IdFunc_user = id
					WHERE
						MONTH (dtvenda_venda) = MONTH (GETDATE())
						AND YEAR(dtvenda_venda) = YEAR(GETDATE())
						{$r}
					GROUP BY
						Nome_user,
						DATEPART(day, dtvenda_venda)
				) em_linha
				PIVOT (
					SUM(Qtd) FOR Dia IN (".$Dias.")
				) em_coluna
			ORDER BY 1
		");
		
		if($Read->GetRowCount()>0){
			echo "<div class='card'><table class='table table-sm text-center'>";
			echo "<thead><tr><th>Nome</th><th>".substr(str_replace("],[", "</th><th>", $Dias), 1, -1)."</th><th>Media</th><th>Total</th></tr></thead>";
			echo "<tbody class='table-striped'>";
			foreach($Read->GetResult() as $Values){
				echo "<tr>";
				echo "<td>{$Values['Nome_user']}</td>";
				
				$d = explode(",",substr(str_replace("],[", ",", $Dias), 1, -1));
				$t = 0;
				
				
				foreach($d as $V){
					
					if($Values[$V] == 1){
						$Class = "Class='text-info table-info'";
					}else if ($Values[$V] > 1){
						$Class = "Class='text-success table-success'";
						
					}
					
					echo (empty($Values[$V])) ? "<td class='text-danger table-danger'><strong>0</strong></td>" : "<td {$Class}>{$Values[$V]}</td>";
					
					$t += $Values[$V];
				
				}
				
				$m = round($t/count($d),1);
				
				echo "<td>".$m."</td><td>".$t."</td></tr>";
			}
			
			echo "</tbody></table></div>";
		}
	}
	
	
	
	
?>