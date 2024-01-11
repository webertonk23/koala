<?php

	$Produtos = new Produtos;

	$Produtos->Listar();
	
	$Carteira = new Carteira;
	
	$Carteira->Listar();
	
	$Vendas = new Vendas;
	
	if(!empty($_POST)){
		if(!empty($_POST["Deletar"])){
			$Vendas->DeleteVenda($_POST['Id']);
		}else{
			$Vendas->Listar($_POST);
			
			if(!$Vendas->GetErro()){
				$Listar = $Vendas->GetResult();
			}else{
				Erro($Vendas->GetErro()[0], $Vendas->GetErro()[1]);
			}
		}
	}
	
	$Usuarios = new Usuarios;

	$Usuarios->Listar();
?>
<div class='card my-2'>
	<div class='card-body'>
		<h4>Manutenção de vendas</h4>
		<form class='form-row' method='POST'>
			<div class='form-group col-sm'>
				<label>Data Ate:</label>
				<input class='form-control' type='date' name='Data[]' value='<?php echo (!empty($_POST['Data'][0])) ? $_POST['Data'][0] : '';?>'>
			</div>
			
			<div class='form-group col-sm'>
				<label>Data Até:</label>
				<input class='form-control' type='date' name='Data[]' value='<?php echo (!empty($_POST['Data'][1])) ? $_POST['Data'][1] : '';?>'>
			</div>
		
			<div class='form-group col-sm'>
				<label>Carteiras</label>
				<select class='form-control' name='Id_Cart'>
					<option value='0' <?php echo (!empty($_POST['Id_Cart']) AND $_POST['Id_Cart'] == 0) ? 'selected' : '';?> >Todas</option>
					<?php
						if(!$Carteira->GetErro()){
							foreach($Carteira->GetResult() as $Value){
								$Selected = (!empty($_POST['Id_Cart']) AND $_POST['Id_Cart'] == $Value['Id_Cart']) ? 'selected' : '';
								echo "<option $Selected value='{$Value['Id_Cart']}'>{$Value['Desc_Cart']}</option>";
							}
						}
					?>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<label>Produto</label>
				<select class='form-control' name='id_prod'>
					<option value='0' <?php echo (!empty($_POST['id_prod']) AND $_POST['id_prod'] == 0) ? 'selected' : '';?> >Todos</option>
					<?php
						if(!$Produtos->GetErro()){
							foreach($Produtos->GetResult() as $Value){
								$Selected = (!empty($_POST['id_prod']) AND $_POST['id_prod'] == $Value['id_prod']) ? 'selected' : '';
								echo "<option $Selected value='{$Value['id_prod']}'>{$Value['desc_prod']}</option>";
							}
						}
					?>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<label>Status</label>
				<select class='form-control' name='status_venda'>
					<option value='0' <?php echo (!empty($_POST['status_venda']) AND $_POST['status_venda'] == 0) ? 'selected' : '';?> >Todos</option>
					<option value='Pendente' <?php echo (!empty($_POST['status_venda']) AND $_POST['status_venda'] == 'Pendente') ? 'selected' : '';?> >Pendente</option>
					<option value='Cancelada' <?php echo (!empty($_POST['status_venda']) AND $_POST['status_venda'] == 'Cancelada') ? 'selected' : '';?> >Cancelada</option>
					<option value='Paga' <?php echo (!empty($_POST['status_venda']) AND $_POST['status_venda'] == 'Paga') ? 'selected' : '';?> >Paga</option>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<label>Número venda / ADE</label>
				<input class='form-control' name='Numero_venda' value="<?php echo (!empty($_POST['Numero_venda']) ? $_POST['Numero_venda'] : "") ?>"/>
			</div>
			
			<div class='form-group col-sm'>
				<label> </label>
				<button class='form-control btn btn-primary'>Aplicar</button>
			</div>
		</form>
	</div>
</div>
	
<div class='card'>
	<div class='card-body' id='Tabela'>
		<table class='table table-sm table-responsive'>
			<thead>
				<tr>
					<th>#Id</th>
					<th>Data</th>
					<th>Cliente</th>
					<th>CPF / CNPJ</th>
					<th>Carteira</th>
					<th>Nº Venda</th>
					<th>Produto</th>
					<th>Usuario</th>
					<th>Valor</th>
					<th>Status</th>
					<th>Motivo</th>
					<th>Ação</th>
				</tr>
			</thead>
			
			<tbody class='align-middle'>
				<?php
					if(!empty($Listar)){
						foreach($Listar as $Key => $Value){
							echo "<tr><td>".$Value['id_venda']."</td>";
							echo "<td>".substr($Check->Data($Value['dtvenda_venda']), 0, -4)."</td>";
							echo "<td>{$Value['Nome_Pes']}</td>";
							echo "<td>&nbsp;{$Value['Cpfcnpj_pes']}</td>";
							echo "<td>{$Value['Desc_Cart']}</td>";
							echo "<td>{$Value['numero_venda']}</td>";
							echo "<td>{$Value['desc_prod']}</td>";
							echo "<td>{$Value['Nome_user']}</td>";
							echo "<td>".number_format($Value['valor_venda'], 2, ',', '.')."</td>";
							echo "<td>{$Value['status_venda']}</td>";
							echo "<td>{$Value['motivost_venda']}</td>";
							echo "<td>
								<button class='btn btn-primary btn-sm mx-1' title='alterar status da venda' data-toggle='modal' data-target='#Status{$Value['id_venda']}' role='button'><span class='fa fa-cogs'></span></button>
								<button class='btn btn-primary btn-sm mx-1' title='alterar usuario da venda' data-toggle='modal' data-target='#Usuario{$Value['id_venda']}' role='button'><span class='fa fa-users'></span></button>
								<button class='btn btn-danger btn-sm mx-1' title='Deletar venda' data-toggle='modal' data-target='#Delete{$Value['id_venda']}' role='button'><span class='fa fa-trash'></span></button>
								</td></tr>";
						
						?>
							<div class="modal fade" id="Status<?php echo $Value['id_venda']; ?>" tabindex="-1" role="dialog" aria-labelledby="Status<?php echo $Value['id_venda']; ?>label" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="AddRetornolabel">Aterar status da venda</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										
										<form class="form" method="POST" action='?p=Submit'>
											<div class="modal-body">
												<div class="form-group">
													<label>Status</label>
													<select class="form-control" id="status_venda" name="status_venda" required>
														<option disabled selected>Selecione</option>
														<option value='Pendente' <?php echo (!empty($Value['status_venda']) AND $Value['status_venda'] == 'Pendente') ? 'selected' : '';?> >Pendente</option>
														<option value='Cancelada' <?php echo (!empty($Value['status_venda']) AND $Value['status_venda'] == 'Cancelada') ? 'selected' : '';?> >Cancelada</option>
														<option value='Paga' <?php echo (!empty($Value['status_venda']) AND $Value['status_venda'] == 'Paga') ? 'selected' : '';?> >Paga</option>
													</select>
												</div>
												
												<div class="form-group form-row">
													<div class="form-group col-sm">
														<label>Motivo</label>
														<textarea class="form-control" type="text" id="Motivost_venda" name="Motivost_venda" Placeholder="Motivo" rows='8' required ></textarea>
													</div>
												</div>
												<input type='hidden' name='Id' value='<?php echo $Value['id_venda']; ?>' />
												<input type='hidden' name='Tabela' value='Vendas' />
												<input type='hidden' name='msg' value='Status de venda alterado de: <?php echo $Value['status_venda']; ?>' />
												<input type="hidden" name="Page" value='<?php echo $_SERVER['QUERY_STRING'];?>'>
											</div>
											
											<div class="modal-footer">
												<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
												<button type="submit" class="btn btn-primary" title = 'Incluir Retorno ' name='Salvar' value='Editar' >Salvar</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							
							<div class="modal fade" id="Usuario<?php echo $Value['id_venda']; ?>" tabindex="-1" role="dialog" aria-labelledby="Usuario<?php echo $Value['id_venda']; ?>label" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="AddRetornolabel">Aterar usuario da venda</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										
										<form class="form" method="POST" action='?p=Submit'>
											<div class="modal-body">
												<div class="form-group">
													<label>Usuário</label>
													<select class="form-control" id="iduser_venda" name="iduser_venda">
														<option disabled selected >Selecione</option>
														<?php
															if(!$Usuarios->GetErro()){
																foreach($Usuarios->GetResult() as $Values){
																	echo "<option value='{$Values['Id_user']}'>{$Values['Usuario_user']}</option>";
																}
															}
														?>
													</select>
												</div>
												
												<input type='hidden' name='Id' value='<?php echo $Value['id_venda']; ?>' />
												<input type='hidden' name='Tabela' value='Vendas' />
												<input type="hidden" name="Page" value='<?php echo $_SERVER['QUERY_STRING'];?>'>
											</div>
											
											<div class="modal-footer">
												<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
												<button type="submit" class="btn btn-primary" title = 'Incluir Retorno ' name='Salvar' value='Editar' >Salvar</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							
							<div class="modal fade" id="Delete<?php echo $Value['id_venda']; ?>" tabindex="-1" role="dialog" aria-labelledby="Usuario<?php echo $Value['id_venda']; ?>label" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="AddRetornolabel">Deletar venda</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										
										<form class="form" method="POST">
											<div class="modal-body">
												<center>
													<p class="modal-text" >Tem certeza que deseja deletar a venda de numero <?php echo $Value['numero_venda']; ?></p>
												</center>
												
												<input type='hidden' name='Id' value='<?php echo $Value['id_venda']; ?>' />
												<input type='hidden' name='Tabela' value='Vendas' />
												<input type="hidden" name="Page" value='<?php echo $_SERVER['QUERY_STRING'];?>'>
											</div>
											
											<div class="modal-footer">
												<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
												<button type="submit" class="btn btn-primary" title = 'Deletar venda' name='Deletar' value='Deletar' >Deletar</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						<?php
						
						}
					}
				?>
			</tbody>
		</table>
	</div>
</div>