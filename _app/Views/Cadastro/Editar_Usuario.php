<div class='row justify-content-center'>
	<div class="card col-12">
		<div class='card-body'>
			<?php
				$Read = new Read;
				
				$f = "1,0";
				$Read->ExeRead('Fila');
				$Filas = ($Read->GetRowCount() > 0) ? $Read->GetResult() : null;
				
				$Read->ExeRead('equipe');
				$Equipe = ($Read->GetRowCount() > 0) ? $Read->GetResult() : null;
				
				if(isset($_POST['Salvar'])){
					unset($_POST['Salvar']);
					
					$_POST['Usuario_user'] = $Check->Name($_POST['Usuario_user']);
					$_POST['Nome_user'] = $Check->Name($_POST['Nome_user']);
					$_POST['Agent_user'] = $_POST['Agent_user'];
					if(!empty($_POST['Senha_user'])){
						$_POST['Senha_user'] = md5($_POST['Senha_user']);
					}else{
						unset($_POST['Senha_user']);
					}
					
					$_POST['Nivel_user'] = (int) ($_POST['Nivel_user']);
						
					$Salvar = new Update;
					$Salvar->ExeUpdate("Usuarios", $_POST, "WHERE Id_user = :Id", "Id={$_GET['Id']}");
					
					if($Salvar->GetResult()){
						Erro("Salvo com sucesso.", SUCESSO);
					}else{
						Erro("Algo de errado não esta certo.", ERRO);
					}
				}
				
				if(!empty($_GET['Id'])){
					$Read->ExeRead('Usuarios', "WHERE Id_user = :Id", "Id={$_GET['Id']}");
					
					$Usuario = ($Read->GetRowCount() > 0) ? $Read->GetResult()[0] : null;
					
				}
				
				if($Usuario['Nivel_user'] == 1){
					$Read->ExeRead('Usuarios', "WHERE Nivel_user = 2 And Ativo_user = 1", " ");
					
					$Super = ($Read->GetRowCount() > 0) ? $Read->GetResult() : null;
				}
			?>

			<form class="form" name="Usuarios" method="POST">
				
				<label ><h3 >Editar Usuario</h3></label>
				<fieldset class='border p-2 rounded mb-3'>
					<div class='form-row'>
						<div class="form-group col-sm-1">
							<label>#Id</label>
							<input class="form-control  " disabled type='text' id="Id" name='Id' Placeholder="#Id" value="<?php echo (!empty($Usuario['Id_user'])) ? $Usuario['Id_user'] : ''?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Nome</label>
							<input class="form-control" type="text" id="Nome_user" name="Nome_user" Placeholder="Nome completo" value='<?php echo (!empty($Usuario['Nome_user'])) ? $Usuario['Nome_user'] : ''?>'>
						</div>
					
						<div class="form-group col-sm">
							<label>Usuario</label>
							<input class="form-control" type="text" id="Usuario_user" name="Usuario_user" Placeholder="Usuario" value='<?php echo (!empty($Usuario['Usuario_user'])) ? $Usuario['Usuario_user'] : ''?>'>
						</div>
						
						<div class="form-group col-sm">
							<label>Senha</label>
							<input class="form-control" type="password" id="Senha_user" name="Senha_user" Placeholder="Senha">
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Nivel</label>
							<select class="form-control" id="Nivel_user" name="Nivel_user" required>
								<option disabled selected  >selecione</option> 
								<option value='1' <?php echo (!empty($Usuario['Nivel_user']) AND $Usuario['Nivel_user'] == 1) ? 'Selected' : ''?>>1 - Operador</option> 
								<option value='2' <?php echo (!empty($Usuario['Nivel_user']) AND $Usuario['Nivel_user'] == 2) ? 'Selected' : ''?>>2 - supervisoe</option>
								<option value='3' <?php echo (!empty($Usuario['Nivel_user']) AND $Usuario['Nivel_user'] == 3) ? 'Selected' : ''?>>3 - Gerente</option>
								<option value='4' <?php echo (!empty($Usuario['Nivel_user']) AND $Usuario['Nivel_user'] == 4) ? 'Selected' : ''?>>4 - Administrador</option>
							</select>
						</div>
						
						<div class="form-group col-sm">
							<label>Agente</label>
							<input class="form-control" type="number" id="Agent_user" name="Agent_user" Placeholder="Agente" value='<?php echo (!empty($Usuario['Agent_user'])) ? $Usuario['Agent_user'] : ''?>'>
						</div>
						
						<div class="form-group col-sm">
							<label>Fila Principal</label>
							<select class="form-control" id="IdFila_User" name="IdFila_User" required>
								<option disabled selected  >selecione</option> 
								<?php
									foreach($Filas as $Values){
										$sel = ($Values['Id_fila'] == $Usuario['IdFila_User']) ? 'selected' : '';
										echo "<option value='{$Values['Id_fila']}' $sel>{$Values['Desc_fila']}</option>";
									}
								
								?>
							</select>
						</div>
						
						<div class="form-group col-sm">
							<label>Equipe</label>
							<select class="form-control" id="idequipe_user" name="idequipe_user" required>
								<option disabled selected  >selecione</option> 
								<?php
									foreach($Equipe as $Values){
										$sel = ($Values['id_equipe'] == $Usuario['idequipe_user']) ? 'selected' : '';
										echo "<option value='{$Values['id_equipe']}' $sel>{$Values['desc_equipe']}</option>";
									}
								
								?>
							</select>
						</div>
						
						<?php if(!empty($Super)){ ?>
						<div class="form-group col-sm">
							<label>Supervisor</label>
							<select class="form-control" id="IdSuper_user" name="IdSuper_user" required>
								<option disabled selected  >selecione</option> 
								<?php
									foreach($Super as $Values){
										$sel = ($Values['Id_user'] == $Usuario['IdSuper_user']) ? 'selected' : '';
										echo "<option value='{$Values['Id_user']}' $sel>{$Values['Nome_user']}</option>";
									}
								
								?>
							</select>
						</div>
						<?php }?>
					</div>
				</fieldset>
				<div class="form-group row">
					<div class='col-sm-6'>
						<button class='btn btn-success form-control' title = 'Salvar' name='Salvar'>Salvar</button>
					</div>
					
					<div class='col-sm-6'>
						<a class='btn btn-danger form-control' title = 'Cancelar' href='?p=Cadastro/Usuarios'>Cancelar</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


