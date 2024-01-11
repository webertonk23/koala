<div class='row justify-content-center'>
	<div class="card col-12">
		<div class='card-body'>
			<?php
				if(isset($_POST['Salvar'])){
					unset($_POST['Salvar']);
					
					$_POST['tabulacao_tab'] = $Check->Name($_POST['tabulacao_tab']);
					$_POST['Origem_tab'] = $Check->Name($_POST['Origem_tab']);
					$_POST['Agendamento_tab'] = (int) $_POST['Agendamento_tab'];
					$_POST['isdn_tab'] = (int) $_POST['isdn_tab'];
					
					$Editar = new Update;
					
					$Editar->ExeUpdate('tabulacao', $_POST, "WHERE Id_tab = :Id", "Id={$_GET['Id']}");	
					
					if(!empty($Editar->GetResult())){
						Erro("Alteração salva com sucesso!", SUCESSO);
					}else{
						Erro("Algo de errado não esta certo.", ERRO);
					}
					
					
				}

				if(isset($_GET['Id'])){
					$Busca = new Read;
					
					$Busca->ExeRead("tabulacao", "WHERE Id_tab = :Id", "Id={$_GET['Id']}");
					
					$Tabulacao = ($Busca->GetRowCount() > 0) ? $Busca->GetResult()[0] : null;
					
				}
			?>

			<form class="form" name="Usuarios" method="POST">
				
				<label ><h3 >Criar Tabulação</h3></label>
				<div class='form-row'>
					<div class="form-group col-sm">
						<label>#Id</label>
						<input class="form-control  " disabled type='text' id="Id" name='Id' Placeholder="#Id" value='<?php echo (!empty($Tabulacao['Id_tab'])) ? $Tabulacao['Id_tab'] : null ?>'>
					</div>
				
					<div class="form-group col-sm-8">
						<label>Tabulação</label>
						<input class="form-control" type="text" id="tabulacao_tab" name="tabulacao_tab" Placeholder="Tabulação"  value='<?php echo (!empty($Tabulacao['Tabulacao_tab'])) ? $Tabulacao['Tabulacao_tab'] : null ?>'>
					</div>
				</div>
				
				<div class='form-row'>
					<div class="form-group col-sm-2">
						<label>Origem</label>
						<select class="form-control" id="Origem_tab" name="Origem_tab" required>
							<option disabled selected  >selecione</option> 
							<option <?php echo (isset($Tabulacao['Origem_tab']) AND $Tabulacao['Origem_tab'] == 'Operador' ) ? 'selected' : ''  ?> >Operador</option> 
							<option <?php echo (isset($Tabulacao['Origem_tab']) AND $Tabulacao['Origem_tab'] == 'Sistema' ) ? 'selected' : ''  ?> >Sistema</option> 
							<option <?php echo (isset($Tabulacao['Origem_tab']) AND $Tabulacao['Origem_tab'] == 'Discador' ) ? 'selected' : ''  ?> >Discador</option>
						</select>
					</div>
					
					<div class="form-group col-sm-2">
						<label>CPC?</label>
						<select class="form-control" id="Cpc_tab" name="Cpc_tab" required>
							<option disabled selected  >selecione</option> 
							<option <?php echo (isset($Tabulacao['Cpc_tab']) AND $Tabulacao['Cpc_tab'] == 0 ) ? 'selected' : ''  ?> value='0'>Não</option> 
							<option <?php echo (isset($Tabulacao['Cpc_tab']) AND $Tabulacao['Cpc_tab'] == 1 ) ? 'selected' : ''  ?> value='1'>Sim</option>
						</select>
					</div>
					
					<div class="form-group col-sm-2">
						<label>Finaliza?</label>
						<select class="form-control" id="Finaliza_tab" name="Finaliza_tab" required>
							<option disabled selected  >selecione</option> 
							<option <?php echo (isset($Tabulacao['Finaliza_tab']) AND $Tabulacao['Finaliza_tab'] == 0 ) ? 'selected' : ''  ?> value='0'>Não</option> 
							<option <?php echo (isset($Tabulacao['Finaliza_tab']) AND $Tabulacao['Finaliza_tab'] == 1 ) ? 'selected' : ''  ?> value='1'>Sim</option>
						</select>
					</div>
					
					<div class="form-group col-sm">
						<label>Agendamento</label>
						<input class="form-control" type="number" id="Agendamento_tab" name="Agendamento_tab" Placeholder="Agendamento (Sec)"   value='<?php echo (!empty($Tabulacao['Agendamento_tab'])) ? $Tabulacao['Agendamento_tab'] : null ?>'>
					</div>
					
					<div class="form-group col-sm">
						<label>ISDN</label>
						<input class="form-control" type="number" id="isdn_tab" name="isdn_tab" Placeholder="ISDN (Utilizar para origem discador)"   value='<?php echo (!empty($Tabulacao['Isdn_tab'])) ? $Tabulacao['Isdn_tab'] : null ?>'>
					</div>
				</div>
			
				<div class="form-group row">
					<div class='col-sm-6'>
						<button class='btn btn-success form-control' title = 'Salvar' name='Salvar'>Salvar</button>
					</div>
					
					<div class='col-sm-6'>
						<a class='btn btn-danger form-control' title = 'Cancelar' href='?p=Cadastro/Tabulacao'>Cancelar</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>



