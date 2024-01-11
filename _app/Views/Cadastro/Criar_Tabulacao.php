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
						
					$Salvar = new Create;
					$Salvar->ExeCreate("Tabulacao", $_POST);
					
					if($Salvar->GetResult()){
						Erro("Salvo com sucesso.", SUCESSO);
					}else{
						Erro("Algo de errado não esta certo.", ERRO);
					}
				}
			?>

			<form class="form" name="Usuarios" method="POST">
				
				<label ><h3 >Criar Tabulação</h3></label>
				<div class='form-row'>
					<div class="form-group col-sm">
						<label>#Id</label>
						<input class="form-control  " disabled type='text' id="Id" name='Id' Placeholder="#Id">
					</div>
				
					<div class="form-group col-sm-8">
						<label>Tabulação</label>
						<input class="form-control" type="text" id="tabulacao_tab" name="tabulacao_tab" Placeholder="Tabulação">
					</div>
				</div>
				
				<div class='form-row'>
					<div class="form-group col-sm-2">
						<label>Origem</label>
						<select class="form-control" id="Origem_tab" name="Origem_tab" required>
							<option disabled select  >selecione</option> 
							<option>Operador</option> 
							<option>Sistema</option> 
							<option>Discador</option>
						</select>
					</div>
					
					<div class="form-group col-sm-2">
						<label>CPC?</label>
						<select class="form-control" id="Cpc_tab" name="Cpc_tab" required>
							<option disabled select  >selecione</option> 
							<option value='0'>Não</option> 
							<option value='1'>Sim</option>
						</select>
					</div>
					
					<div class="form-group col-sm-2">
						<label>Finaliza?</label>
						<select class="form-control" id="Finaliza_tab" name="Finaliza_tab" required>
							<option disabled select  >selecione</option> 
							<option value='0'>Não</option> 
							<option value='1'>Sim</option>
						</select>
					</div>
					
					<div class="form-group col-sm">
						<label>Agendamento</label>
						<input class="form-control" type="number" id="Agendamento_tab" name="Agendamento_tab" Placeholder="Agendamento (Sec)">
					</div>
					
					<div class="form-group col-sm">
						<label>ISDN</label>
						<input class="form-control" type="number" id="isdn_tab" name="isdn_tab" Placeholder="ISDN (Utilizar para origem discador)">
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



