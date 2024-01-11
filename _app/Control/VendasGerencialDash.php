<?php
	require('../Config.inc.php');
	
	$Cart = (!empty($_GET['Cart'])) ? $_GET['Cart'] : 0;
	
	$r = '';
	
	$r .= (!empty($_GET['Sup'])) ? " AND p2.id_user = '{$_GET['Sup']}'" : '';
	$r .= (!empty($_GET['Equipe'])) ? " AND id_equipe = '{$_GET['Equipe']}'" : '';
	
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
						MONTH (dtvenda_venda) = MONTH (GETDATE())
						AND YEAR(dtvenda_venda) = YEAR(GETDATE())
						AND Status_venda != 'Cancelada'
						{$r}
					GROUP BY
						p1.Nome_user, desc_equipe, p2.Nome_user,
						DATEPART(day, dtvenda_venda)
				) em_linha
				PIVOT (
					SUM(Qtd) FOR Dia IN (".$Dias.")
				) em_coluna
			ORDER BY 1
		");
		
		//print_r($Read);
		
		if($Read->GetRowCount()>0){
			echo "<div class='card'><table id='tabela' class='table table-sm text-center table-striped table-hover'>";
			echo "<thead class='bg-dark text-white'><tr><th>Nome</th><th>Equipe</th><th>Supervisor</th><th>".substr(str_replace("],[", "</th><th>", $Dias), 1, -1)."</th><th>Media</th><th>Total</th></tr></thead>";
			echo "<tbody class=''>";
			
			$total = array();
			
			foreach($Read->GetResult() as $Values){
				echo "<tr>";
				echo "<td>{$Values['Nome_user']}</td>";
				echo "<td>{$Values['desc_equipe']}</td>";
				echo "<td>{$Values['Supervisor']}</td>";
				
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
					
					if(empty($total[$V])){
						$total[$V] = (int) $Values[$V];
					}else{
						$total[$V] = (int) $total[$V] + $Values[$V];
					}
				
				}
				
				$m = number_format($t/count($d),1, ",", ".");
				
				echo "<td>".$m."</td><td>".$t."</td></tr>";
			}
			
			echo "<tr class='bg-dark text-white'><th>Total</th><th></th><th></th><th>" .implode("</th><th>", $total). "</th><th>". number_format(array_sum($total)/count($d),1, ",", ".") ."</th><th>". array_sum($total) ."</th></tr>";
			echo "</tbody></table></div>";
		}
	}
?>