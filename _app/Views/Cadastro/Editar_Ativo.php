<div class='row justify-content-center'>
	<div class="col-7">
		<div class="card">
			<div class='card-header'>
				<h4 class='card-title'>Editar Ativo</h4>
			</div>
			
			<div class='card-body'>
				<?php
					if(isset($_POST['Salvar'])){
						unset($_POST['Salvar']);
						
						$Check = new Check;
						
						$Editar = new Update;
						
						$Editar->ExeUpdate('Ativos', $_POST, "WHERE Id_ativo = :Id", "Id={$_GET['Id']}");	
						
						if($Editar->GetResult()){
							Erro("Salvo com sucesso.", SUCESSO);
						}
					}

					if(isset($_GET['Id'])){
						$Busca = new Read;
						
						$Busca->ExeRead("Ativos", "WHERE Id_ativo = :Id", "Id={$_GET['Id']}");
						
						if($Busca->GetRowCount() > 0){
							$Ativos = $Busca->GetResult()[0];
						}
					}
				?>

				<form class="form" name="Usuarios" method="POST">
					<div class='form-row'>
						<div class="form-group col-sm-2">
							<label>#Id</label>
							<input class="form-control  " disabled type='text' id="Id_ativo" name='Id_ativo' Placeholder="#Id" value="<?php echo (!empty($Ativos['Id_ativo'])) ? $Ativos['Id_ativo'] : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Produto</label>
							<input class="form-control  " type='text' id="Produto_ativo" name='Produto_ativo' Placeholder="Produto" value="<?php echo (!empty($Ativos['Produto_ativo'])) ? $Ativos['Produto_ativo'] : '';?>">
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Número Etiqueta</label>
							<input class="form-control" type="text" id="Etiqueta_ativo" name="Etiqueta_ativo" Placeholder="Número Etiqueta" value="<?php echo (!empty($Ativos['Etiqueta_ativo'])) ? $Ativos['Etiqueta_ativo'] : '';?>">
						</div>
					
						<div class="form-group col-sm">
							<label>Setor</label>
							<select class="form-control" id="Setor_ativo" name="Setor_ativo">
								<option <?php echo ($Ativos['Setor_ativo'] == 'Operação') ? 'Selected' : '' ?>>Operação</option>
								<option <?php echo ($Ativos['Setor_ativo'] == 'planejamento') ? 'Selected' : '' ?>>planejamento</option>
								<option <?php echo ($Ativos['Setor_ativo'] == 'Ti') ? 'Selected' : '' ?>>Ti</option>
								<option <?php echo ($Ativos['Setor_ativo'] == 'Coordenadoria') ? 'Selected' : '' ?>>Coordenadoria</option>
								<option <?php echo ($Ativos['Setor_ativo'] == 'Financeiro - RH') ? 'Selected' : '' ?>>Financeiro / RH</option>
								<option <?php echo ($Ativos['Setor_ativo'] == 'Deretoria') ? 'Selected' : '' ?>>Deretoria</option>
								<option <?php echo ($Ativos['Setor_ativo'] == 'Comercial') ? 'Selected' : '' ?>>Comercial</option>
							</select>
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Fornecedor</label>
							<input class="form-control" type="text" id="Fornecedor_ativo" name="Fornecedor_ativo" Placeholder="Fornecedor" value="<?php echo (!empty($Ativos['Fornecedor_ativo'])) ? $Ativos['Fornecedor_ativo'] : '';?>">
						</div>
					
						<div class="form-group col-sm">
							<label>Valor</label>
							<input class="form-control" type="number" id="Valor_ativo" name="Valor_ativo" Placeholder="Valor" value="<?php echo (!empty($Ativos['Valor_ativo'])) ? $Ativos['Valor_ativo'] : '';?>">
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Data Entrada</label>
							<input class="form-control" type="date" id="DtEnt_ativo" name="DtEnt_ativo" Placeholder="DtEntrada" value="<?php echo (!empty($Ativos['DtEnt_ativo'])) ? $Ativos['DtEnt_ativo'] : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Data Baixa</label>
							<input class="form-control" readonly type="date" id="DtBaixa_ativo" name="DtBaixa_ativo" Placeholder="DtBaixa" value="<?php echo (!empty($Ativos['DtBaixa_ativo'])) ? $Ativos['DtBaixa_ativo'] : '';?>">
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Descrição</label>
							<textarea class="form-control" id="Descricao_ativo" name="Descricao_ativo" Placeholder="Descricao"><?php echo (!empty($Ativos['Descricao_ativo'])) ? $Ativos['Descricao_ativo'] : '';?></textarea>
						</div>
					</div>
					
					<div class="form-group row">
						<div class='col-sm-6'>
							<button class='btn btn-success form-control' title = 'Salvar' name='Salvar'>Salvar</button>
						</div>
						
						<div class='col-sm-6'>
							<a class='btn btn-danger form-control' title = 'Cancelar' href='?p=Cadastro/Ativos'>Cancelar</a>
						</div>
					</div>
				</form>
			</div>
			
			<div class='card-footer'>
			
			</div>
		</div>
	</div>
</div>