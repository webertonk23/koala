<?php
	require('../Config.inc.php');
	
	$r = '';
	
	$r .= (!empty($_GET['Sup'])) ? " AND p2.id_user = '{$_GET['Sup']}'" : '';
	$r .= (!empty($_GET['Equipe'])) ? " AND p1.idequipe_user = '{$_GET['Equipe']}'" : '';
	
	$Read = new Read;
	
	$Read->FullRead("
		SELECT DISTINCT
			SUBSTRING(CONVERT(CHAR(20), dtvenda_venda, 114), 0, 3) As Hora
		FROM
			vendas
		WHERE
			dtvenda_venda BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59'
		ORDER BY Hora
	");
	
	if($Read->GetRowCount()>0){
		$Horas = "";
		foreach ($Read->GetResult() as $Values){
			$Horas .= (empty($Horas)) ? "[".$Values['Hora']."]" : ",[".$Values['Hora']."]";
		}
		
		$Read->FullRead("
			SELECT
				*
			FROM
				(
					SELECT
						DATEPART(HOUR, dtvenda_venda) AS Hora,
						p1.Nome_user,
						desc_equipe,
						p2.Nome_user as Supervisor,
						COUNT (*) AS Qtd
					FROM
						vendas INNER JOIN usuarios as p1 ON iduser_venda = p1.id_user
						INNER JOIN Produto ON idprod_venda = id_prod
						LEFT JOIN equipe ON p1.idequipe_user = id_equipe
						LEFT JOIN usuarios as p2 ON p1.IdSuper_user = p2.Id_user
					WHERE
						dtvenda_venda BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59'
						{$r}
					GROUP BY
						p1.Nome_user,
						desc_equipe,
						p2.Nome_user,
						DATEPART(HOUR, dtvenda_venda)
				) em_linha
				PIVOT (
					SUM(Qtd) FOR Hora IN (".$Horas.")
				) em_coluna
			ORDER BY 1
		");
		
		//Debug($Read);
		
		if($Read->GetRowCount()>0){
			echo "<div class='card'><table class='table table-sm text-center table-striped table-hover'>";
			echo "<thead class='bg-dark text-white'><tr><th>Nome</th><th>Equipe</th><th>Supervisor</th><th>".substr(str_replace("],[", ":00</th><th>", $Horas), 1, -1).":00</th><th>Media</th><th>Total</th></tr></thead>";
			echo "<tbody class='table-striped'>";
			
			$total = array();
			
			foreach($Read->GetResult() as $Values){
				echo "<tr>";
				echo "<td>{$Values['Nome_user']}</td>";
				echo "<td>{$Values['desc_equipe']}</td>";
				echo "<td>{$Values['Supervisor']}</td>";
				
				$d = explode(",",substr(str_replace("],[", ",", $Horas), 1, -1));
				$t = 0;
				
				foreach($d as $V){
					
					if($Values[$V] == 1){
						$Class = "Class='text-info table-info'";
					}else if ($Values[$V] > 1){
						$Class = "Class='text-success table-success'";
						
					}
					
					echo (empty($Values[$V])) ? "<td class='text-danger table-danger'><strong>0</strong></td>" : "<td {$Class}>{$Values[$V]}</td>";
					
					$t += $Values[$V];
					
					if(empty($total[$V])){
						$total[$V] = (int) $Values[$V];
					}else{
						$total[$V] = (int) $total[$V] + $Values[$V];
					}					
				}
				
				$m = round($t/count($d),1);
				
				echo "<td>".$m."</td><td>".$t."</td></tr>";
				
			}
			
			echo "<tr class='bg-dark text-white'><th>Total</th><th></th><th></th><th>" .implode("</th><th>", $total). "</th><th>". round(array_sum($total)/count($d),1) ."</th><th>". array_sum($total) ."</th></tr>";
			echo "</tbody></table></div>";

		}
	}
	
	
	
	
?>