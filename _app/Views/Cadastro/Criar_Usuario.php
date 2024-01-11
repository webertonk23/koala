<div class='row justify-content-center'>
	<div class="card col-12">
		<div class='card-body'>
			<?php 
				if(isset($_POST['Salvar'])){
					unset($_POST['Salvar']);
					
					$_POST['Usuario_user'] = $Check->Name($_POST['Usuario_user']);
					$_POST['Nome_user'] = $Check->Name($_POST['Nome_user']);
					$_POST['Agent_user'] = $_POST['Agent_user'];
					$_POST['Senha_user'] = md5($_POST['Senha_user']);
					$_POST['Nivel_user'] = (int) ($_POST['Nivel_user']);
					
					$Read = new Read;
					$Read->ExeRead('Usuarios', "WHERE Usuario_user = :User", "User={$_POST['Usuario_user']}");
					if(	$Read->GetRowCount()>0){
						Erro("Nome de usuario já existe no sistema, gentileza escolher um diferente.", ERRO);
					}else{
						$Salvar = new Create;
						$Salvar->ExeCreate("Usuarios", $_POST);
						
						if($Salvar->GetResult()){
							Erro("Salvo com sucesso.", SUCESSO);
						}else{
							Erro("Algo de errado não esta certo.", ERRO);
						}
					}
				}
			?>

			<form class="form" name="Usuarios" method="POST">
				
				<label ><h3 >Criar Usuario</h3></label>
				<div class='form-row'>
					<div class="form-group col-sm-1">
						<label>#Id</label>
						<input class="form-control  " disabled type='text' id="Id" name='Id' Placeholder="#Id">
					</div>
				
					<div class="form-group col-sm">
						<label>Usuario</label>
						<input class="form-control" type="text" id="Usuario_user" name="Usuario_user" Placeholder="Usuario">
					</div>
					
					<div class="form-group col-sm">
						<label>Senha</label>
						<input class="form-control" type="password" id="Senha_user" name="Senha_user" Placeholder="Senha">
					</div>
				</div>
				
				<div class='form-row'>
					<div class="form-group col-sm">
						<label>Nome</label>
						<input class="form-control" type="text" id="Nome_user" name="Nome_user" Placeholder="Nome completo">
					</div>
					
					<div class="form-group col-sm">
						<label>Nivel</label>
						<select class="form-control" id="Nivel_user" name="Nivel_user" required>
							<option disabled select  >selecione</option> 
							<option value='1'>1 - Operador</option> 
							<option value='2'>2 - supervisoe</option>
							<option value='3'>3 - Gerente</option>
							<option value='4'>4 - Administrador</option>
						</select>
					</div>
					
					<div class="form-group col-sm">
						<label>Agente</label>
						<input class="form-control" type="number" id="Agent_user" name="Agent_user" Placeholder="Agente">
					</div>
				</div>
			
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



