<div class='row justify-content-center'>
	<div class="col-sm-7">
		<div class="card">
			<div class='card-header'>
				<h4 class='card-title'>Criar Ativo</h4>
			</div>

			<div class='card-body'>
				<?php 
					$Read = new Read;
					
					if(isset($_POST['Salvar'])){
						$Read->ExeRead("Ativos", "WHERE Etiqueta_ativo = :NEtiqueta", "NEtiqueta={$_POST['Etiqueta_ativo']}");
						
						if($Read->GetRowCount() > 0){
							Erro("Já existe ativo salvo com esta etiqueta", AVISO);
						}else{
						
							unset($_POST['Salvar']);
							$Check = new Check;
							
							$_POST['Produto_ativo'] = $Check->Name($_POST['Produto_ativo']);
							$_POST['Descricao_ativo'] = $Check->Name($_POST['Descricao_ativo']);
							$_POST['Setor_ativo'] = $Check->Name($_POST['Setor_ativo']);
							$_POST['Fornecedor_ativo'] = $Check->Name($_POST['Fornecedor_ativo']);
							$_POST['Etiqueta_ativo'] = str_pad($_POST['Etiqueta_ativo'], 4, 0, STR_PAD_LEFT);
							$_POST['Valor_ativo'] = str_replace(",", ".", $_POST['Valor_ativo']);
							
							$_POST['DtCad_ativo'] = date("Y-m-d");
							$_POST['DtEnt_ativo'] = ($_POST['DtEnt_ativo'] == '') ? NULL : $_POST['DtEnt_ativo'];
							
							$Create = new Create;
							
							$Create->ExeCreate('Ativos', $_POST);
							
							if($Create->GetResult()){
								Erro("Salvo com sucesso", SUCESSO);
							}
						}
					}
				?>

				<form class="form" name="Usuarios" method="POST">
					
					<div class='form-row'>
						<div class="form-group col-sm-2">
							<label>#Id</label>
							<input class="form-control  " disabled type='text' id="Id_ativo" name='Id_ativo' Placeholder="#Id">
						</div>
						
						<div class="form-group col-sm">
							<label>Produto</label>
							<input class="form-control" type="text" id="Produto_ativo" name="Produto_ativo" Placeholder="Produto" maxlength='50'>
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Número Etiqueta</label>
							<input class="form-control" type="number" id="Etiqueta_ativo" name="Etiqueta_ativo" Placeholder="Número Etiqueta">
						</div>
						
						<div class="form-group col-sm">
							<label>Setor</label>
							<select class="form-control" id="Setor_ativo" name="Setor_ativo">
								<option value='0' disabled selected>Selecione</option>
								<option>Operação</option>
								<option>planejamento</option>
								<option>Ti</option>
								<option>Coordenadoria</option>
								<option>Financeiro / RH</option>
								<option>Deretoria</option>
								<option>Comercial</option>
							</select>
						</div>
					</div>
						
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Fornecedor</label>
							<input class="form-control" type="text" id="Fornecedor_ativo" name="Fornecedor_ativo" Placeholder="Fornecedor">
						</div>
					
						<div class="form-group col-sm">
							<label>Valor</label>
							<input class="form-control" type="text" id="Valor_ativo" name="Valor_ativo" Placeholder="Valor">
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Data Entrada</label>
							<input class="form-control" type="date" id="DtEnt_ativo" name="DtEnt_ativo" Placeholder="DtEntrada">
						</div>
						
						<div class="form-group col-sm">
							<label>Data Baixa</label>
							<input class="form-control" disabled type="date" id="DtBaixa_ativo" name="DtBaixa_ativo" Placeholder="DtBaixa" >
						</div>
					</div>
					
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Descrição</label>
							<textarea class="form-control" id="Descricao_ativo" name="Descricao_ativo" Placeholder="Descricao"></textarea>
						</div>
					</div>
					
					
					<div class="form-group row">
						<div class='col-sm-6'>
							<button class='btn btn-success form-control' title = 'Salvar' name='Salvar'>Salvar</button>
						</div>
						
						<div class='col-sm-6'>
							<a class='btn btn-danger form-control' title = 'Cancelar' href="?p=<?php echo base64_encode('Cadastro/Ativos'); ?>">Cancelar</a>
						</div>
					</div>
				</form>
			</div>
			
			<div class='card-footer'>
		
			</div>

		</div>
	</div>
</div>



