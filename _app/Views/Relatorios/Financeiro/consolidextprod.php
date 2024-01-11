<?php 
	$Mes = (!empty($_POST['Mes'])) ? $_POST['Mes'] : date("m");
	$Ano = (!empty($_POST['Ano'])) ? $_POST['Ano'] : date("Y");
	$Prod = (!empty($_POST['Prod'])) ? $_POST['Prod'] : "Produto_ext";
?>

<div class='card'>
	<form method='POST'>
		<div class='form-row'>
			<div class='form-group col-sm'>
				<select name='Ano' class='form-control'>
					<?php
						for($i=2020; $i <= date("Y"); $i++){
							echo ($i == $Ano) ? "<option selected>" : "<option>";
							echo $i ."</option>";
						}
					?>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<select name='Mes' class='form-control'>
					<option value='1' <?php echo ($Mes == 1) ? 'selected' : ''; ?> >Janeiro</option>
					<option value='2' <?php echo ($Mes == 2) ? 'selected' : ''; ?> >Fevereiro</option>
					<option value='3' <?php echo ($Mes == 3) ? 'selected' : ''; ?> >Março</option>
					<option value='4' <?php echo ($Mes == 4) ? 'selected' : ''; ?> >Abril</option>
					<option value='5' <?php echo ($Mes == 5) ? 'selected' : ''; ?> >Maio</option>
					<option value='6' <?php echo ($Mes == 6) ? 'selected' : ''; ?> >Junho</option>
					<option value='7' <?php echo ($Mes == 7) ? 'selected' : ''; ?> >Julho</option>
					<option value='8' <?php echo ($Mes == 8) ? 'selected' : ''; ?> >Agosto</option>
					<option value='9' <?php echo ($Mes == 9) ? 'selected' : ''; ?> >Setembro</option>
					<option value='10' <?php echo ($Mes == 10) ? 'selected' : ''; ?> >Outubro</option>
					<option value='11' <?php echo ($Mes == 11) ? 'selected' : ''; ?> >Novembro</option>
					<option value='12' <?php echo ($Mes == 12) ? 'selected' : ''; ?> >Dezembro</option>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<select name='Prod' class='form-control'>
					<option value='Produto_ext' <?php echo ($Prod == 'Produto_ext') ? 'selected' : ''; ?> >Produto</option>
					<option value='Data_ext' <?php echo ($Prod == 'Data_ext') ? 'selected' : ''; ?> >Dia</option>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<input type='submit' class='btn btn-primary' name='Aplicar' value='Aplicar'>
			</div>
		</div>
	</form>
</div>

<?php
	$Read = new Read;
	
	$Read->FullRead("
		SELECT
			".$Prod." As Prod,
			ROUND(SUM(CASE tipo_ext WHEN 1 THEN valor_ext else 0 END), 2) AS Entrada,
			ROUND(SUM(CASE tipo_ext WHEN -1 THEN valor_ext else 0 END), 2) AS Estorno
		FROM
			extrato
		WHERE
			MONTH(data_ext) = {$Mes} AND YEAR(data_ext) = {$Ano}
		GROUP BY
			".$Prod, "");
	
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
?>