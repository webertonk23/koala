<?php
	$Read = new Read;
	
	$Read->FullRead('SELECT DISTINCT descpausa_histp FROM histpausa');
	if($Read->GetRowCount()>0){
		$pausa = $Read->GetResult();
	}
	
	if(!empty($_POST)){
		$Query = "
			SELECT
				*
			FROM
				histpausa INNER JOIN funcionarios ON idfunc_histp = id
			WHERE
				inipausa_histp BETWEEN '".$_POST['DataDe']." 00:00:00' AND '".$_POST['DataAte']." 23:59:59' AND
				descpausa_histp = '{$_POST['pausa']}'
			ORDER BY
				idfunc_histp, inipausa_histp
		";
		
		$Read->FullRead($Query);
		
		if($Read->GetRowCount()>0){
			$Lista = $Read->GetResult();
			
			$Dados = array();
			foreach($Lista as $k => $v){
				$Dados[$v['Id']]['NomeCompleto'] = $v['NomeCompleto'];
				$Dados[$v['Id']]['Cpf'] = $v['Cpf'];
				$Dados[$v['Id']]['Pis'] = $v['Pis'];
				$Dados[$v['Id']]['Matricula'] = $v['matricula'];
				$Dados[$v['Id']]['Cargo'] = $v['Cargo'];
				$Dados[$v['Id']]['Pausa'] = $v['descpausa_histp'];
				$Dados[$v['Id']]['dia'][date("Y-m-d", strtotime($v['inipausa_histp']))][] = array(
					'ini' => substr(explode(" ", $v['inipausa_histp'])[1], 0, 5),
					'fim' => substr(explode(" ", $v['fimpausa_histp'])[1], 0, 5)
				);
			}
		}
	}
?>

<div class='card mb-2'>
	<div class='card-body'>
		<h4>Relatório de Login de operador</h4>
		<form class='form-row' method='POST'>
			<div class='form-group col-sm'>
				<label>Data De:</label>
				<input class='form-control' type='date' name='DataDe' required value='<?php echo (!empty($_POST['DataDe'])) ? $_POST['DataDe'] : '';?>'>
			</div>
			
			<div class='form-group col-sm'>
				<label>Data Até:</label>
				<input class='form-control' type='date' name='DataAte' required value='<?php echo (!empty($_POST['DataAte'])) ? $_POST['DataAte'] : '';?>'>
			</div>
			
			<div class="form-group col-sm">
				<label>pausa</label>
				<select class="form-control" id="pausa" name="pausa" required>
					<option disabled selected  >selecione</option> 
					<?php
						foreach($pausa as $Values){
							$sel = ($Values['descpausa_histp'] == $_POST['pausa']) ? 'selected' : '';
							echo "<option value='{$Values['descpausa_histp']}' $sel>{$Values['descpausa_histp']}</option>";
						}
					
					?>
				</select>
			</div>
		
			<div class='form-group col-sm'>
				<label class='text-white'>.</label>
				<button class='form-control btn btn-primary' name='Aplicar'>Aplicar</button>
			</div>
		</form>
	</div>
</div>

<div class='form-group col-sm'>
	<label class='text-white'>.</label>
	<button id="btn" class='btn'><span class="fa fa-print"></span> Imprimir</button>
</div>

<div id='print'>
	<!-- Bootstrap core CSS -->
	<link href="bootstrap-4.5.2/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Custom styles for this template -->
	<style>
		.pb {
		   clear: both;
		   page-break-before: always;
		   page-break-inside: avoid;
		}
	</style>
	
	<?php if(isset($Dados)){ 
		foreach($Dados as $k => $v){
	?>

	<div class='card m-2'>
		<div class='card-body'>
			<div class='col-sm'>
				<label class='font-weight-bold'>Período: </label>
				<span><?php echo  date("d/m/Y", strtotime($_POST['DataDe']))?></span>
				<label class='font-weight-bold'>Até</label>
				<span><?php echo date("d/m/Y", strtotime($_POST['DataAte']))?></span>
			</div>
			
			<div class='col-sm'>
				<label class='font-weight-bold'><?php echo  $v['Matricula'] ." - ". $v['NomeCompleto']?></label>
			</div>
			
			<div class='col-sm'>
				<label class='font-weight-bold'>Pis:</label>
				<span><?php echo  $v['Pis'] ?></label>
			</div>
			
			<div class='col-sm'>
				<label class='font-weight-bold'>Cargo:</label>
				<span><?php echo  $v['Cargo'] ?></label>
			</div>
			
			<table class='table'>
					<tr>
						<th>Data</th>
						<th>Descrição</th>
						<th>Inicio</th>
						<th>Fim</th>
						<th>Inicio</th>
						<th>Fim</th>
						<th>Inicio</th>
						<th>Fim</th>
					</tr>
					
					<?php
						foreach($v['dia'] as $key => $d){
							echo "<tr>
									<td>".utf8_encode(strftime("%d/%m/%Y %A", strtotime($key)))."</td>
									<td>{$v['Pausa']}</td>";
							echo (!empty($d[0])) ? "<td>{$d[0]['ini']}</td>" : "<td></td>";
							echo (!empty($d[0])) ? "<td>{$d[0]['fim']}</td>" : "<td></td>";
							echo (!empty($d[1])) ? "<td>{$d[1]['ini']}</td>" : "<td></td>";
							echo (!empty($d[1])) ? "<td>{$d[1]['fim']}</td>" : "<td></td>";
							echo (!empty($d[2])) ? "<td>{$d[2]['ini']}</td>" : "<td></td>";
							echo (!empty($d[2])) ? "<td>{$d[2]['fim']}</td>" : "<td></td>";
							echo "</tr>";
						}
					?>
			</table>
		</div>
		
		<label class='col-sm text-center'>___/___/_____ _____________________________________</label>
	</div>
	
	
	<div class="pb"></div>
<?php }}?>
</div>

<script>
	document.getElementById('btn').onclick = function() {
		var conteudo = document.getElementById('print').innerHTML,
		tela_impressao = window.open('about:blank');
		tela_impressao.document.write(conteudo);
		tela_impressao.window.print();
		tela_impressao.window.close();
	};
</script>