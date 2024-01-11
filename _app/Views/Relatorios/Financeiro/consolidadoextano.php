<?php
	$Read = new Read;
	
	$Read->FullRead("
		SELECT DISTINCT
			YEAR(data_ext) as Anos
		FROM
			extrato
		ORDER BY Anos
	");
	
	$Anos = $Read->GetResult();
	
	$Ano = (!empty($_GET['Ano'])) ? $_GET['Ano'] : date("Y");
	
	if($Read->GetRowCount()>0){
		$Read->FullRead("
			SELECT
				*
			FROM
				(
					SELECT
						CASE DATEPART(MONTH, data_ext)
						WHEN 1 THEN 'Jan'
						WHEN 2 THEN 'Fev'
						WHEN 3 THEN 'Mar'
						WHEN 4 THEN 'Abr'
						WHEN 5 THEN 'Mai'
						WHEN 6 THEN 'Jun'
						WHEN 7 THEN 'Jul'
						WHEN 8 THEN 'Ago'
						WHEN 9 THEN 'Set'
						WHEN 10 THEN 'Out'
						WHEN 11 THEN 'Nov'
						WHEN 12 THEN 'Dez'
						END AS mes,
						Produto_ext,
						ROUND(SUM(valor_ext * tipo_ext), 2) AS Saldo
					FROM
						extrato
					WHERE
						YEAR(data_ext) = ".$Ano."
					GROUP BY
						DATEPART(MONTH, data_ext), Produto_ext
				) em_linha
				PIVOT (
					SUM(Saldo) FOR mes IN ([Jan],[Fev],[Mar],[Abr],[Mai],[Jun],[Jul],[Ago],[Set],[Out],[Nov],[Dez])
				) em_coluna
			ORDER BY 1
		", "");
		
		if($Read->GetRowCount()>0){
			echo "<div class='card'>";
			echo "<div>";
			foreach($Anos As $k => $v){
				echo "<a href='?p=Relatorios/Financeiro/consolidadoextano&Ano={$v['Anos']}' class='btn''>{$v['Anos']}</a>";
			}			
			echo"</div>";
			echo "<table id='tabela' class='table table-sm text-center table-striped table-hover'>";
			echo "<thead class='bg-dark text-white'><tr><th>".str_replace(",", "</th><th>", str_replace("_ext", "", implode(",", array_keys($Read->GetResult()[0]))))."</th></tr></thead>";
			
			echo "<tbody class=''>";
			
			$total = array();
			
			foreach($Read->GetResult() as $Values){
				echo "<tr>";
				echo "<td>{$Values['Produto_ext']}</td>";
				echo "<td>".number_format($Values['Jan'], 2, ",", ".")."</td>";
				echo "<td>".number_format($Values['Fev'], 2, ",", ".")."</td>";
				echo "<td>".number_format($Values['Mar'], 2, ",", ".")."</td>";
				echo "<td>".number_format($Values['Abr'], 2, ",", ".")."</td>";
				echo "<td>".number_format($Values['Mai'], 2, ",", ".")."</td>";
				echo "<td>".number_format($Values['Jun'], 2, ",", ".")."</td>";
				echo "<td>".number_format($Values['Jul'], 2, ",", ".")."</td>";
				echo "<td>".number_format($Values['Ago'], 2, ",", ".")."</td>";
				echo "<td>".number_format($Values['Set'], 2, ",", ".")."</td>";
				echo "<td>".number_format($Values['Out'], 2, ",", ".")."</td>";
				echo "<td>".number_format($Values['Nov'], 2, ",", ".")."</td>";
				echo "<td>".number_format($Values['Dez'], 2, ",", ".")."</td>";
				echo "</tr>";
			}
			
			echo "<tr class='bg-dark text-white'><th>Total</th>";
			echo "<th>".number_format(array_sum(array_filter(array_column($Read->GetResult(), 'Jan'))), 2, ",", ".")."</th>";
			echo "<th>".number_format(array_sum(array_filter(array_column($Read->GetResult(), 'Fev'))), 2, ",", ".")."</th>";
			echo "<th>".number_format(array_sum(array_filter(array_column($Read->GetResult(), 'Mar'))), 2, ",", ".")."</th>";
			echo "<th>".number_format(array_sum(array_filter(array_column($Read->GetResult(), 'Abr'))), 2, ",", ".")."</th>";
			echo "<th>".number_format(array_sum(array_filter(array_column($Read->GetResult(), 'Mai'))), 2, ",", ".")."</th>";
			echo "<th>".number_format(array_sum(array_filter(array_column($Read->GetResult(), 'Jun'))), 2, ",", ".")."</th>";
			echo "<th>".number_format(array_sum(array_filter(array_column($Read->GetResult(), 'Jul'))), 2, ",", ".")."</th>";
			echo "<th>".number_format(array_sum(array_filter(array_column($Read->GetResult(), 'Ago'))), 2, ",", ".")."</th>";
			echo "<th>".number_format(array_sum(array_filter(array_column($Read->GetResult(), 'Set'))), 2, ",", ".")."</th>";
			echo "<th>".number_format(array_sum(array_filter(array_column($Read->GetResult(), 'Out'))), 2, ",", ".")."</th>";
			echo "<th>".number_format(array_sum(array_filter(array_column($Read->GetResult(), 'Nov'))), 2, ",", ".")."</th>";
			echo "<th>".number_format(array_sum(array_filter(array_column($Read->GetResult(), 'Dez'))), 2, ",", ".")."</th>";
			echo "</tr></tbody></table></div>";
		}
	}
?>