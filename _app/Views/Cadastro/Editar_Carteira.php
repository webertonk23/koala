<div class='row justify-content-center'>
	<div class="card">
		<div class='card-body'>
			<?php
				if(!empty($_GET['Id'])){
					$Id = $_GET['Id'];
					
					if(isset($_POST['Salvar'])){
						unset($_POST['Salvar']);
						
						$_POST['Desc_cart'] = $Check->Name($_POST['Desc_cart']);
						$_POST['Contato_cart'] = $Check->Name($_POST['Contato_cart']);
						$_POST['RazaoSocial_cart'] = $Check->Name($_POST['RazaoSocial_cart']);
						$_POST['CNPJ_cart'] = ($_POST['CNPJ_cart'] != '') ? str_replace(' ', '', $Check->Name($_POST['CNPJ_cart'])) : null;
						$_POST['Tab_Cart'] = (!empty($_POST['Tabulacoes'])) ? implode(",", $_POST['Tabulacoes']) : null;	
						
						unset($_POST['Tabulacoes']);
						
						$Update = new Update;
						$Update->ExeUpdate("Carteira", $_POST, "WHERE id_cart = :id", "id={$Id}");
						
						if($Update->GetResult()){
							Erro("Salvo com sucesso.", SUCESSO);
						}else{
							Erro("Algo de errado não esta certo.", ERRO);
						}
					}
					
					$Read = new Read;
					
					$Read->ExeRead('Carteira', "WHERE id_cart = :id", "id={$Id}");
					$Carteira = ($Read->GetRowCount()>0) ? $Read->GetResult()[0] : null;
					
					$Read->ExeRead("Tabulacao", "WHERE ativo_tab = 1 AND origem_tab = :Origem", "Origem=OPERADOR");
					
					$Tab = ($Read->GetRowCount() > 0) ? $Read->GetResult() : null;
				}
			?>

			<form class="form" name="Usuarios" method="POST">
				
				<label ><h3 >Editar Carteira</h3></label>
				
				<fieldset class='border p-2 rounded mb-3'>
					<div class='form-row'>
						<div class="form-group">
							<label>#Id</label>
							<input class="form-control " disabled type='text' id="Id" name='Id' Placeholder="#Id" value='<?php echo (!empty($Carteira)) ? $Carteira['Id_Cart'] : ""; ?>'>
						</div>
					
						<div class="form-group col-sm">
							<label>Descrição</label>
							<input class="form-control" type="text" id="Desc_Cart" name="Desc_cart" Placeholder="Descrição" value='<?php echo (!empty($Carteira)) ? $Carteira['Desc_Cart'] : ""; ?>'>
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Razão social</label>
							<input class="form-control" type="text" id="RazaoSocial_cart" name="RazaoSocial_cart" Placeholder="Razão Social" value='<?php echo (!empty($Carteira)) ? $Carteira['RazaoSocial_Cart'] : ""; ?>'>
						</div>
							
						<div class="form-group col-sm">
							<label>CNPJ</label>
							<input class="form-control" type="text" id="CNPJ_cart" name="CNPJ_cart" Placeholder="CNPJ" value='<?php echo (!empty($Carteira)) ? $Carteira['CNPJ_Cart'] : ""; ?>'>
						</div>

						<div class="form-group col-sm">
							<label>Perfil</label>
							<select class="form-control" name="perfil_cart" required>
								<option selected disabled>selecione</option>
								<option value='Vendas' <?php echo (!empty($Carteira) AND $Carteira['Perfil_Cart'] == 'Vendas') ? 'selected' : ''?>>Vendas</option>
								<option value='Recptivo' <?php echo (!empty($Carteira) AND $Carteira['Perfil_Cart'] == 'Recptivo') ? 'selected' : ''?>>Receptivo</option>
								<option value='Prospeccao' <?php echo (!empty($Carteira) AND $Carteira['Perfil_Cart'] == 'Prospeccao') ? 'selected' : ''?>>Prospecção</option>
								<option value='Pesquisa' <?php echo (!empty($Carteira) AND $Carteira['Perfil_Cart'] == 'Pesquisa') ? 'selected' : ''?>>Pesquisa</option>
							</select>
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Telefone</label>
							<input class="form-control" type="number" id="Telefone_cart" name="Telefone_cart" Placeholder="Telefone" value='<?php echo (!empty($Carteira)) ? $Carteira['Telefone_Cart'] : ""; ?>'>
						</div>
						
						<div class="form-group col-sm">
							<label>Contato</label>
							<input class="form-control" type="text" id="Contato_cart" name="Contato_cart" Placeholder="Contato" value='<?php echo (!empty($Carteira)) ? $Carteira['Contato_Cart'] : ""; ?>'>
						</div>
						
						<div class="form-group col-sm">
							<label>E-mail</label>
							<input class="form-control" type="email" id="Email_cart" name="Email_cart" Placeholder="E-mail" value='<?php echo (!empty($Carteira)) ? $Carteira['Email_Cart'] : ""; ?>'>
						</div>
					</div>
				</fieldset>
				
				<fieldset class='border p-2 rounded mb-3'>
					<label><h5 >Tabulações liberadas</h5></label>
					<div class='form-row'>
						<?php 
							foreach($Tab as $Values){
								$sel = (in_array("'".$Values['Id_tab']."'", explode(",", $Carteira['Tab_Cart']))) ? 'checked' : '';
								echo "<div class='form-group col-sm-3'>
										<div class='form-check'>
											<label class='form-check-label'>
												<input class='form-check-input' type='checkbox' $sel value=\"'{$Values['Id_tab']}'\" name='Tabulacoes[]'>
												{$Values['Tabulacao_tab']}
											</label>
										</div>
									</div>";
							}
						?>
					</div>
				</fieldset>

				<div class="form-group row">
					<div class='col-sm-6'>
						<button class='btn btn-success form-control' title = 'Salvar' name='Salvar'>Salvar</button>
					</div>
					
					<div class='col-sm-6'>
						<a class='btn btn-danger form-control' title = 'Cancelar' href='?p=Cadastro/Carteira'>Cancelar</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>



