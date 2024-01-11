<?php
	
	//$sp= (isset($_GET['sp'])) ? "./_app/views/{$p}/{$_GET['sp']}.php" : 0;
	

	$path = "\\\\10.20.10.247\\e$\Backup\CallFlex\\";
	

	$Read = new read();
	
	$Read->ExeRead('Monitoria');
	if($Read->GetRowCount()>0){
		$Monitoria = $Read->GetResult();
	}
	
	$Read->ExeRead('Funcionarios', "WHERE Cargo = 'Operador' AND Status = 'Ativo' ORDER BY NomeCompleto");
	if($Read->GetRowCount()>0){
		$Operadores = $Read->GetResult();
	}
	
	if(isset($_POST['Filtro'])){
		if($_POST['DataAte'] < $_POST['DataDe']){
			Erro("A data final deve ser maior que a da data de inicio!", ALERTA);
		}else{
			$DataDe = $_POST['DataDe'];
			$DataAte = $_POST['DataAte'];
			$Operador = $_POST['Operador'];
			
			$Query = "
				SELECT
					Nome_Av as Avaliação,
					NomeCompleto as Operador,
					MonitoriaRealizada.*
				FROM
					MonitoriaRealizada INNER JOIN Monitoria on MonitoriaRealizada.Id_Av = Monitoria.Id_Av
					INNER JOIN Funcionarios on Id_Func = Funcionarios.Id
				WHERE Data BETWEEN :DataDe and :DataAte AND Id_Func = :Operador";
			$Pleaces = "DataDe={$DataDe}&DataAte={$DataAte}&Operador={$Operador}";
			
			$Read->FullRead($Query, $Pleaces);
			
			if($Read->GetRowCount()>0){
				$Lista = $Read->GetResult();
			}
		}
	}
	
	if(isset($_POST['Incluir'])){
		header ("location: ?p=".base64_encode("Monitoria/Realizar")."&Id_M=".base64_encode($_POST['Monitoria'])."&Id_O=".base64_encode($_POST['Operador'])."&Id_C=".base64_encode($_POST['Id_Chamada']));
	}
	
?>
<div class='card mb-2 text-center'>
	<div class='card-body'>
		<h3 class='card-title'>Monitoria</h3>
	</div>
</div>

<div class='card col'>
	<div class='card-body'>
		<div class="navbar navbar-expand-lg justify-content-between mb-3">
			<form class="form-inline my-2 my-lg-0" name="" method="POST">	
				<label class='mr-sm-2'> Operador</label>
				<select class='form-control mr-sm-2 col-sm-3' name='Operador' required >
					<option disabled selected value='0'>Todos</option>
					<?php
						if(!empty($Operadores)){
							foreach($Operadores as $Values){
								$a = ($Values['Id'] == $Operador) ? 'selected' : '';
								echo "<option $a value='{$Values['Id']}'>{$Values['NomeCompleto']}</option>";
							}
						}
					?>
				</select>
				
				<label class='mr-sm-2'> De: </label>
				<input class='form-control mr-sm-2 col-sm-3' type='date' name='DataDe' value="<?php echo $DataDe;?>" required>
						
				<label class='mr-sm-2'> Ate: </label>
				<input class='form-control mr-sm-2  col-sm-3' type='date' name='DataAte' value="<?php echo$DataAte;?>" required>	
				
				<button class='btn btn-primary' role="button" title="Aplicar filtro" name='Filtro'><span class="fa fa-search"></span></button>
				
				<button type="button" class="btn btn-success ml-sm-2" data-target="#Incluir"><span class="fa fa-plus"></span></button>
			</form>	

			<form class="" name="" method="POST">	
				<!-- Modal -->
				<div class="modal fade" id="Incluir" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="">Incluir nova monitoria</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							
							<div class="modal-body">
								<label class='mr-sm-2'>Monitoria</label>
								<select class='form-control mr-sm-2 col-sm' name='Monitoria' required >
									<option disabled selected value='0'>Todos</option>
									<?php
										if(!empty($Monitoria)){
											foreach($Monitoria as $Values){
												echo "<option $a value='{$Values['Id_Av']}'>{$Values['Nome_Av']}</option>";
											}
										}
									?>
								</select>
								
								<label class='mr-sm-2'>Operador</label>
								<select class='form-control mr-sm-2 col-sm' name='Operador' required >
									<option disabled selected>Todos</option>
									<?php
										if(!empty($Operadores)){
											foreach($Operadores as $Values){
												echo "<option $a value='{$Values['Id']}'>{$Values['NomeCompleto']}</option>";
											}
										}
									?>
								</select>
								
								<label class='mr-sm-2'>Id Ligação (Uniqueid)</label>
								<input type='text' class='form-control' name='Id_Chamada'required />
							</div>
							
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary" name='Incluir'>Prosseguir</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>

		<table class='table table-hover table-condensed'>
			<thead>
				<tr>
					<th class=''>Data</th>
					<th class=''>Id Ligação (Uniqueid)</th>
					<th class=''>Avaliação</th>
					<th class=''>Operador</th>
					<th class=''>Avaliador</th>
					<th class=''>Feedback</th>
					<th class=''>Nota</th>				
					<th class=''>Ação</th>				
				</tr>
			</thead>
			
			<tbody>
				<form method="POST">
					<?php
						if(!empty($Lista)){		
							foreach ($Read->GetResult() as $key => $value){
								echo "<tr><td>".$Check->Data($value['Data'])."</td>";
								echo "<td>".$value['Id_Chamada']."</td>";
								echo "<td>".$value['Avaliação']."</td>";
								echo "<td>".$value['Operador']."</td>";
								echo "<td>".$value['Avaliador']."</td>";
								echo ($value['Feedback']) ? "<td>SIM</td>" : "<td>NÃO</td>";
								echo "<td>".number_format($value['Nota'],2,',','')."%</td>";
								echo "<td>
											<a href='?p=".base64_encode("Monitoria/Feedback")."&Id=".base64_encode($value['Id_R'])."' title='Feedback' class='btn btn-outline-primary btn-sm'><span class='fa fa-comments-o'></span></a>
											<a href='?p=".base64_encode("Monitoria/Visualizar")."&Id_M=".base64_encode($value['Id_R'])."' class='btn btn-outline-success btn-sm' title='Visualizar Monitoria'><span class='fa fa-eye'></span></a>
										</td></tr>";
							}
						}
						
					?>
				</form>
			</tbody>
		</table>
	</div>
</div>