<div class='row justify-content-center'>
	<div class="card col-6">
		<div class='card-body'>
			<?php 
				if(isset($_POST['Salvar'])){
					unset($_POST['Salvar']);
					
					$_POST['Desc_cart'] = $Check->Name($_POST['Desc_cart']);
					$_POST['Contato_cart'] = $Check->Name($_POST['Contato_cart']);
					$_POST['RazaoSocial_cart'] = $Check->Name($_POST['RazaoSocial_cart']);
					$_POST['CNPJ_cart'] = ($_POST['CNPJ_cart'] != '') ? str_replace(' ', '', $Check->Name($_POST['CNPJ_cart'])) : null;
						
					$Salvar = new Create;
					$Salvar->ExeCreate("Carteira", $_POST);
					
					if($Salvar->GetResult()){
						Erro("Salvo com sucesso.", SUCESSO);
					}else{
						Erro("Algo de errado não esta certo.", ERRO);
					}
				}
			?>

			<form class="form" name="Usuarios" method="POST">
				
				<label ><h3 >Criar Carteira</h3></label>
				
				<div class='form-row'>
					<div class="form-group">
						<label>#Id</label>
						<input class="form-control  " disabled type='text' id="Id" name='Id' Placeholder="#Id">
					</div>
				
					<div class="form-group col-sm">
						<label>Carteira</label>
						<input class="form-control" type="text" id="Desc_Cart" name="Desc_cart" Placeholder="Carteira">
					</div>
				</div>
				
				<div class="form-group">
					<label>Razão social</label>
					<input class="form-control" type="text" id="RazaoSocial_cart" name="RazaoSocial_cart" Placeholder="Razão Social" >
				</div>
					
				<div class="form-group">
					<label>CNPJ</label>
					<input class="form-control" type="text" id="CNPJ_cart" name="CNPJ_cart" Placeholder="CNPJ">
				</div>

				<div class="form-group">
					<label>Perfil</label>
					<select class="form-control" name="perfil_cart" required>
						<option selected disabled>selecione</option>
						<option value='Vendas'>Vendas</option>
						<option value='Recptivo'>Receptivo</option>
						<option value='Prospeccao'>Prospecção</option>
						<option value='Pesquisa'>Pesquisa</option>
					
					</select>
				</div>
				
				<div class="form-group">
					<label>Telefone</label>
					<input class="form-control" type="number" id="Telefone_cart" name="Telefone_cart" Placeholder="Telefone">
				</div>
				
				<div class="form-group">
					<label>Contato</label>
					<input class="form-control" type="text" id="Contato_cart" name="Contato_cart" Placeholder="Contato">
				</div>
				
				<div class="form-group">
					<label>E-mail</label>
					<input class="form-control" type="email" id="Email_cart" name="Email_cart" Placeholder="E-mail">
				</div>

				<div class="form-group row">
					<div class='col-sm-6'>
						<button class='btn btn-success form-control' title = 'Salvar' name='Salvar'>Salvar</button>
					</div>
					
					<div class='col-sm-6'>
						<a class='btn btn-danger form-control' title = 'Cancelar' href='?p=<?php echo base64_encode("Cadastro/Carteira"); ?>'>Cancelar</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>



