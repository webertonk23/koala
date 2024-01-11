<?php

	$Read = new Read;
	
	$Id_M = base64_decode($_GET['Id_M']);
	
	$Read->FullRead("SELECT Monitoria.Id_Av, Nome_Av, Id_Chamada, Avaliador, Obs, Acao, Data, Nota, Feedback, Id_Categoria, Pergunta, MonitoriaRespostas.Resposta, MonitoriaRespostas.Id_Pergunta,
						CASE WHEN MonitoriaPerguntas.Resposta = MonitoriaRespostas.Resposta THEN 1 ELSE 0 END AS 'Acertou', NomeCompleto AS 'Operador'
					FROM MonitoriaRealizada LEFT JOIN Monitoria on MonitoriaRealizada.Id_Av = Monitoria.Id_Av
						LEFT JOIN MonitoriaPerguntas ON MonitoriaPerguntas.Id_Avaliacao = Monitoria.Id_Av
						INNER JOIN MonitoriaRespostas ON MonitoriaRealizada.Id_R = MonitoriaRespostas.Id_realizado and MonitoriaPerguntas.Id_Itens = MonitoriaRespostas.Id_Pergunta
						INNER JOIN Funcionarios ON MonitoriaRealizada.Id_Func = Funcionarios.Id
					WHERE MonitoriaRealizada.Id_R = :Id", "Id={$Id_M}");
					
	if($Read->GetRowCount()>0){
		$Monitoria = $Read->GetResult();
	}
?>
	
	<legend ><h3 >Realizar Avaliação - <?php echo $Monitoria[0]['Nome_Av'];?></h3></legend>
	<div class='row'>
		<div class="col-sm-4">
			<div class="card mb-3">
				<div class='card-body'>
				<label>Nota</label>
				<h2 class="text-center">
				<?php
					echo number_format($Monitoria[0]['Nota'],2,',','.')."%";
				?>
				</h2>
				</div>	
			</div>	
			
			<div class="card mb-3">
				<div class='card-body'>
					<div class='form-group'>
						<Label>Id Ligação (Uniqueid)</Label>
						<input type='text' class='form-control' Name='Id_Chamada' readonly value='<?php echo $Monitoria[0]['Id_Chamada']?>'>
					</div>
			
					<div class='form-group'>
						<label>Operador</label>
						<input type='text' class='form-control' id='Operador' Name='Operador' readonly value='<?php echo $Monitoria[0]['Operador']?>'>
					</div>
			
					<div class='form-group'>
						<label>Ação</label>
						<input class='form-control' Name='Acao' readonly value='<?php echo $Monitoria[0]['Acao']?>'>
					</div>
					
					<div class='form-group'>
						<label>Observação</label>
						<textarea class="form-control" rows='5' name='Obs' readonly><?php echo $Monitoria[0]['Obs']?></textarea> 
					</div>
				</div>
			</div>
		</div>
		
		<div  class='col-sm-8'>
			<?php
				$Read->FullRead("SELECT DISTINCT Nome_Cat, Id_Categoria FROM MonitoriaCategorias, MonitoriaPerguntas WHERE Id_cat = Id_Categoria  AND Id_Avaliacao = :Id ORDER BY Id_Categoria", "Id={$Monitoria[0]['Id_Av']}");
				if($Read->GetRowCount()>0){
					$Categoria = $Read->GetResult();
				}
				
				foreach($Categoria as $chave){
					echo "<div class='card mb-3'><div class='card-header'><h4 class='card-title'>{$chave['Nome_Cat']}</h4></div><div class='card-body'>";
					//$Pergunta->ExeRead('Avaliacao_itens, avaliacao_respostas', 'WHERE avaliacao_itens.id = avaliacao_respostas.Id_Pergunta and avaliacao_itens.Id_Avaliacao = :Id_Avaliacao AND Id_Categoria = :Id_Categoria and Id_Realizado = :Id_Realizado ORDER BY Id_Pergunta', "Id_Avaliacao={$Busca->GetResult()[0]['Id_Avaliacao']}&Id_Categoria={$chave['Id_Categoria']}&Id_Realizado={$_GET['Id']}");
					foreach ($Monitoria as $key => $value){
						if($chave['Id_Categoria'] == $value['Id_Categoria']){
							$checked = ($value['Resposta'])?'checked':'';
							$Check = ($value['Acertou'])?"<span class='oi oi-check'></span>":"<span class='oi oi-x' aria-hidden='true'></span>";
							echo "<dl class='row'><dt class='col-sm-10'>".$value['Pergunta']."?</dt>
							<label class='switch'>
								<input type='checkbox' disabled name='Resposta[{$value['Id_Pergunta']}]' id='{$value['Id_Pergunta']}'  value='1' $checked>
								<span class='slider round'></span>
							</label>
							&nbsp;&nbsp;$Check
							</dl>";
						}
					}
					echo "</div></div>";
				}
			?>
			
			<div class='form-group row'>
				<div class='col-sm-6'>
					<button class='btn btn-success form-control' Disabled title = 'Salvar' name='Salvar'>Salvar</button>
				</div>
				
				<div class='col-sm-6'>
					<a href='?p=Monitoria' class='btn btn-danger form-control' title = 'Cancelar' name='Cancelar'>Cancelar</a>
				</div>
			</div>						
		</div>
	</div>
	</form>