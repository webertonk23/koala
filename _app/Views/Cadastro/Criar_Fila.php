<div class='row justify-content-center'>
	<div class="card col-sm">
		<div class='card-body'>
			<?php
			
				$Busca = new Read;

				$Busca->ExeRead("Tabulacao", "WHERE ativo_tab = 1 AND origem_tab = :Origem", "Origem=OPERADOR");

				$Tab = ($Busca->GetRowCount() > 0) ? $Busca->GetResult() : null;
					
				if(isset($_POST['Salvar'])){
					unset($_POST['Salvar']);
					
					$Create = new Create;
					
					$Create->ExeCreate('Fila', $_POST);	
					
					echo ($Create->GetResult()) ? "Salva com sucesso!" : "Algo de errado não esta certo.";
				
					
				}
			?>
			
			<form class="form" name="Usuarios" method="POST">
				<label><h3>Criar Fila</h3></label>
				
				<fieldset class='border p-2 rounded mb-3'>
					<div class='form-row'>
						<div class="form-group col-sm-1">
							<label>Id</label>
							<input class="form-control  " disabled type='text' id="Id" name='Id' Placeholder="#Id"  value="<?php echo (!empty($Fila[0]['Id_fila'])) ? $Fila[0]['Id_fila'] : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Descrição</label>
							<input class="form-control" type="text" id="Desc_fila" name="Desc_fila" Placeholder="Descrição" value="<?php echo (!empty($Fila[0]['Desc_fila'])) ? $Fila[0]['Desc_fila'] : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Id Discador</label>
							<input class="form-control" type="text" id="iddisc_fila" name="iddisc_fila" Placeholder="Id Discador" value="<?php echo (!empty($Fila[0]['iddisc_fila'])) ? $Fila[0]['iddisc_fila'] : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Perfil</label>
							<select class="form-control" id="Perfil_fila" name="Perfil_fila">
								<option selected disabled>Selecione</option>
								<option value='Vendas'>Vendas</option>
								<option value='Recptivo'>Receptivo</option>
								<option value='Prospeccao'>Prospecção</option>
								<option value='Pesquisa'>Pesquisa</option>
							</select>
						</div>
						
						<div class="form-group col-sm">
							<label>Ordem</label>
							<select class="form-control" id="Ordem_fila" name="Ordem_fila">
								<option selected disabled>Selecione</option>
								<option Value='Desc'>Mais Novo</option>
								<option value='Asc'>Mais Antigo</option>
							</select>
						</div>
					</div>
				</fieldset>
				
				<div class="form-group row">
					<div class='col-sm-6'>
						<button class='btn btn-success form-control' title = 'Salvar' name='Salvar'>Salvar</button>
					</div>
					
					<div class='col-sm-6'>
						<a class='btn btn-danger form-control' href='?p=Cadastro/Filas' title = 'Cancelar' name='Cancelar'>Cancelar</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>