<div class='card'>
	<div class='card-body'>
		<form method='POST'>
			<div class='form-row'>
				<div class='form-group col-sm'>
					<label>Data De</label>
					<input type='date' name='DataDe' class='form-control' value='<?php echo (!empty($_POST['DataDe'])) ? $_POST['DataDe'] : '' ?>'/>
				</div>
				
				<div class='form-group col-sm'>
					<label>Data Ate</label>
					<input type='date' name='DataAte' class='form-control'  value='<?php echo (!empty($_POST['DataAte'])) ? $_POST['DataAte'] : '' ?>'/>
				</div>
				
				<div class='form-group col-sm'>
					<input type='submit' class='btn btn-primary h-100' name='Aplicar' value='Aplicar'>
				</div>
			</div>
		</form>
	</div>
</div>

<?php
	
	if(!empty($_POST['DataDe']) AND !empty($_POST['DataAte'])){
		$Read = new Read;
		
		$Read->FullRead("
			SELECT
				Produto_ext As Prod,
				ROUND(SUM(CASE tipo_ext WHEN 1 THEN valor_ext else 0 END), 2) AS Entrada,
				ROUND(SUM(CASE tipo_ext WHEN -1 THEN valor_ext else 0 END), 2) AS Estorno
			FROM
				extrato
			WHERE
				Data_ext BETWEEN '{$_POST['DataDe']}' AND '{$_POST['DataAte']}'
			GROUP BY
				Produto_ext","");
		
		if($Read->GetRowCount()>0){
			echo "<div class='card'>";
			echo "<table id='tabela' class='table table-sm text-center table-striped table-hover'>";
			echo "<thead class='bg-dark text-white'><tr><th>".str_replace(",", "</th><th>", str_replace("_ext", "", implode(",", array_keys($Read->GetResult()[0]))))."</th><th>Total</th></tr></thead>";
			
			echo "<tbody class=''>";
			
			foreach($Read->GetResult() as $Values){
				echo "<tr>";
				echo "<td>{$Values['Prod']}</td>";
				echo "<td>".number_format($Values['Entrada'], 2, ",", ".")."</td>";
				echo "<td>".number_format($Values['Estorno'], 2, ",", ".")."</td>";
				echo "<td>".number_format($Values['Entrada'] - $Values['Estorno'], 2, ",", ".")."</td>";
				echo "</tr>";
			}
			
			$entrada = array_sum(array_filter(array_column($Read->GetResult(), 'Entrada')));
			$saida = array_sum(array_filter(array_column($Read->GetResult(), 'Estorno')));
			
			echo "<tr class='bg-dark text-white'><th>Total</th>";
			echo "<th>".number_format($entrada, 2, ",", ".")."</th>";
			echo "<th>".number_format($saida, 2, ",", ".")."</th>";
			echo "<th>".number_format($entrada - $saida, 2, ",", ".")."</th>";
			echo "</tr></tbody></table></div>";
		}
	}
?>