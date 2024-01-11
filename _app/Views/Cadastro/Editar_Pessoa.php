<?php
	$Read = new Read();
	$Update = new Update();
	
	$Id = $_GET['Id'];
	
	$Read->ExeRead('Pessoas', 'WHERE Id_Pes = :Id', "Id={$Id}");
	
	if($Read->GetRowCount() > 0){
		$DadosCli = $Read->GetResult()[0];
	}else{
		Erro("Não possui resultado para este cliente", ERRO);
	}
	
	$Read->ExeRead("Fichas INNER JOIN Carteira ON IdCart_Ficha = Id_Cart", "WHERE IdPes_Ficha = :Id", "Id={$Id}");
		
	if($Read->GetRowCount()>0){
		$Fichas = $Read->GetResult();
	}
	
	if(isset($_POST['SalvaFone'])){
		unset($_POST['SalvaFone']);
		$_POST['IdPes_Fone'] = $Id;
		$_POST['Origem_Fone'] = 'Cadastro Manual';
		$_POST['Tipo_Fone'] = $Check->ValidaTelefone($_POST['Fone'])['Tipo'];
		$_POST['Fone'] = $Check->ValidaTelefone($_POST['Fone'])['Fone'];
		
		$InsertFone = new Create;
		
		$InsertFone->ExeCreate('Telefones', $_POST);
	}
	
	if(isset($_POST['SalvaEmail'])){
		unset($_POST['SalvaEmail']);
		$_POST['IdPes_Email'] = $Id;
		$_POST['Email'] = $_POST['Email'];
		
		$InsertFone = new Create;
		
		$InsertFone->ExeCreate('Pessoas_Email', $_POST);
	}
	
	if(isset($_POST['Pos'])){
		$_POST['Status_tel'] = 1;
		$Update->ExeUpdate('Telefones', $_POST, 'WHERE Id_tel :IdFone', "IdFone={$_POST['Pos']}");
	}
?>

<div class='card mb-2 text-center'>
	<div class='card-body'>
		<h3 class='card-title'>Editar Pessoa</h3>
	</div>
</div>

<form method='POST' action='?p=Submit'>
	<h4>Dados Pessoais</h4>
	<div class="card mb-3">
		<div class="card-body">
			<div class="form-row">
				<div class="form-group col-sm-2">
					<label for="Id">#ID</label>
					<input id="Id" Name="Id" class="form-control" type="text" placeholder="#ID" readonly value="<?php echo (isset($_POST['Id_Pes']))? $_POST['Id_Pes'] : (isset($DadosCli['Id_Pes'])) ? $DadosCli['Id_Pes'] : "" ;?>">
				</div>
					
				<div class="form-goup col-sm">
					<label for="Nome">Nome Completo</label>
					<input type="text" class="form-control" Name="Nome_Pes" placeholder="Nome Completo" value="<?php echo (isset($_POST['Nome_Pes']))? $_POST['Nome_Pes'] : (isset($DadosCli['Nome_Pes'])) ? $DadosCli['Nome_Pes'] : "" ;?>" >
				</div>
			
				<div class="form-goup col-sm">
					<label for="CpfCnpj">CPF / CNPJ</label>
					<input type="text" class="form-control" Name='CpfCnpj_Pes' placeholder="CPF / CNPJ" value="<?php echo (isset($_POST['CpfCnpj_Pes'])) ? $_POST['CpfCnpj_Pes'] : (isset($DadosCli['CpfCnpj_Pes'])) ? $DadosCli['CpfCnpj_Pes'] : "" ;?>">
				</div>
			</div>
			
			<div class='form-row'>
				<div class="form-group col-sm-4">
					<label>RG</label>
					<input type='text' class="form-control" name='Rg_Pes' value='<?php echo (isset($_POST['Rg_Pes'])) ? $_POST['Rg_Pes'] : (isset($DadosCli['Rg_Pes'])) ? $DadosCli['Rg_Pes'] : "" ?>'>
				</div>
				
				<div class="form-group col-sm">
					<label>Orgão Emissor</label>
					<input type='text' class="form-control" name='Rg_Pes' value='<?php echo (isset($_POST['OrgaoRg_Pes'])) ? $_POST['OrgaoRg_Pes'] : (isset($DadosCli['OrgaoRg_Pes'])) ? $DadosCli['OrgaoRg_Pes'] : "" ?>'>
				</div>
				
				<div class="form-group col-sm">
					<label>Uf Emissão</label>
					<input type='text' class="form-control" name='Rg_Pes' value='<?php echo (isset($_POST['UfRg_Pes'])) ? $_POST['UfRg_Pes'] : (isset($DadosCli['UfRg_Pes'])) ? $DadosCli['UfRg_Pes'] : "" ?>'>
				</div>
				
				<div class="form-group col-sm">
					<label>Dt Emissão</label>
					<input type='text' class="form-control" name='Rg_Pes' value='<?php echo (isset($_POST['DtEmissaoRg_Pes'])) ? $_POST['DtEmissaoRg_Pes'] : (isset($DadosCli['DtEmissaoRg_Pes'])) ? $DadosCli['DtEmissaoRg_Pes'] : "" ?>'>
				</div>					
			</div>
		</div>
		
		<input type="hidden" name="Page" value='<?php echo $_SERVER['QUERY_STRING'];?>'>
		<input type="hidden" name="Tabela" value='Pessoas'>
	</div>

	<h4>Localização</h4>
	<div class="card mb-3">
		<div class="card-header">
			<ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="home-tab" data-toggle="tab" href="#Fone" role="tab" aria-controls="Fone" aria-selected="true">
						<span class="oi oi-dial"></span> Fones
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="profile-tab" data-toggle="tab" href="#Email" role="tab" aria-controls="Email" aria-selected="false">
						<span class="oi oi-envelope-closed"></span> E-mails
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="profile-tab" data-toggle="tab" href="#End" role="tab" aria-controls="End" aria-selected="false">
						<span class="oi oi-map"></span> Endereços
					</a>
				</li>
			</ul>
		</div>
		
		<div class="card-body tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="Fone" role="tabpanel" aria-labelledby="Fone-tab">
				<a href='#IncluirFone' class="btn btn-outline-success" title="Adicionar Telefone" data-toggle="modal" data-target="#AddFone"><span class="oi oi-plus"></span> Adicionar Telefone</a>
				<hr>
				
				<?php 
					$Read->ExeRead('telefones', 'WHERE IdPes_tel = :Id', "Id={$Id}");
					
					if($Read->GetRowCount() > 0){
						foreach($Read->GetResult() as $Key => $Value){
							echo "<div class='row align-items-center'>";
							echo "<div class='col-sm-8'>";
							echo "<h5>({$Value['ddd_tel']}) {$Value['Telefone_tel']}</h5>";
							echo "</div>";
							echo "<div class='col-sm-2'>";
							echo ($Value['Tipo_tel'] == 'c') ? "<h5>Celular</h5>" : "<h5>Fixo</h5>";
							echo "</div>";
							echo "<div class='col-sm-2'>";
							echo "<button class='btn btn-outline-success  mr-2' name='Pos' value='{$Value['Id_tel']}'><span class='fa fa-plus'></span></button>";
							echo "<button class='btn btn-outline-danger' name='Neg' value='{$Value['Id_tel']}'><span class='fa fa-minus'></span></button>";
							echo "</div>";
							echo "</div>";
							echo "<hr>";
						}
					}else{
						echo"<h4 class='text-center'>Não há dados para mostrar</h4>";
					}
				?>
				
			</div>
			
			<div class="tab-pane fade" id="Email" role="tabpanel" aria-labelledby="Email-tab">
				<a href='#IncluirEmail' class="btn btn-outline-success" title="Adicionar E-mail"  data-toggle="modal" data-target="#AddEmail"><span class="oi oi-plus"></span> Adicionar E-mail</a>
				<hr>
				
				<?php 
					$Read->ExeRead('Pessoas_Email', 'WHERE IdPes_Email = :Id', "Id={$Id}");
					
					if($Read->GetRowCount() > 0){
						foreach($Read->GetResult() as $Key => $Value){
							echo "<div class='row align-items-center'>";
							echo "<div class='col-sm-10'>";
							echo "<h5>{$Value['Email']}</h5>";
							echo "</div>";
							echo "<div class='col-sm-2'>";
							echo "<a href='#' class='btn btn-outline-info' title='Editar Fone'><span class='fa fa-pencil'></span></a>";
							echo "<a href='#' class='btn btn-outline-danger' title='Remover Fone'><span class='fa fa-trash'></span></a>";
							echo "</div>";
							echo "</div>";
							echo "<hr>";
							
						}
					}else{
						echo"<h4 class='text-center'>Não há dados para mostrar</h4>";
					}
				?>
			</div>
			
			<div class="tab-pane fade" id="End" role="tabpanel" aria-labelledby="End-tab">
				<a href='#IncluirEnd' class="btn btn-outline-success" title="Adicionar Endereço"  data-toggle="modal" data-target="#AddEnd"><span class="oi oi-plus"></span> Adicionar Endereço</a>
				<hr>
				<?php 
					$Read->ExeRead('Pessoas_end', 'WHERE IdPes_End = :Id', "Id={$Id}");
					
					if($Read->GetRowCount() > 0){
						foreach($Read->GetResult() as $Key => $Value){
							echo "<div class='row align-items-center'>";
							echo "<div class='col-sm-10'>";
							echo "<h5>{$Value['Logradouro']}, Nº {$Value['Numero']} - {$Value['Bairro']}</h5>";
							echo "<small>{$Value['Cidade']} - {$Value['UF']} Cep: {$Value['Cep']}</small></p>";
							echo "</div>";
							echo "<div class='col-sm-2'>";
							echo "<a href='#' class='btn btn-outline-info' title='Editar Endereço'><span class='oi oi-pencil'></span></a>";
							echo "<a href='#' class='btn btn-outline-danger' title='Remover Endereço'><span class='oi oi-trash'></span></a>";
							echo "</div>";
							echo "</div>";
							echo "<hr>";
							
						}
					}else{
						echo"<h4 class='text-center'>Não há dados para mostrar</h4>";
					}
				?> 
			</div>
		</div>
	</div>
	
	<h4>Fichas</h4>
	<div class="card mb-3">
		<div class="card-body">
			<table class='table table-hover table-sm table-striped'>
				<thead class="thead-light">
					<tr>
						<th scope="col">Carteira</th>
						<th scope="col">Contrato</th>
						<th scope="col">Agendamento</th>
					</tr>
				</thead>
			
				<tbody>
					<?php
						if(!empty($Fichas)){		
							foreach ($Fichas as $key => $value){
								echo "<tr >";
								echo "<td>".$value['Desc_Cart']."</td>";
								echo "<td>".$value['Contrato_Ficha']."</td>";
								echo "<td>".date("d/m/Y H:i:s", strtotime($value['DtUltAcio_Ficha']))."</td>";
								echo "</tr>";
							}
						}else{
							Erro("Pesquisa não retornou resultados", INFO);
						}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<div class='card mb-3'>
		<div class='card-body form-group'>
			<div class='form-row justify-content-md-center'>
				<div class='col-sm-4'>
					<a href="?p=Cadastro/Pessoas" class="btn btn-outline-danger form-control">Descartar</a>
				</div>
				<div class='col-sm-4'>
					<button type="submit" name='Salvar' class="btn btn-success form-control" value='Editar'>Salvar</button>
				</div>
			</div>
		</div>
	</div>
</form>

	<div class="modal fade" id="AddFone" tabindex="-1" role="dialog" aria-labelledby="AddFone" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered " role="document">
			<div class="modal-content">
				<form method='POST'>
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				
					<div class="modal-body">
						<div class='form-group'>
							<label>Fone:</label>
							<input class='form-control' type='text' placeholder='Fone' maxlength='11' name='Fone' pattern="[0-9]+$" required="required">
						</div>
						
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
						<button type="submit" class="btn btn-success" name='SalvaFone'>Salvar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="AddEmail" tabindex="-1" role="dialog" aria-labelledby="AddFone" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered " role="document">
			<div class="modal-content">
				<form method='POST'>
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				
					<div class="modal-body">
						<div class='form-group'>
							<label>E-mail:</label>
							<input class='form-control' type='email' placeholder='E-mail' name='Email' pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
						</div>
						
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
						<button type="submit" class="btn btn-success" name='SalvaEmail'>Salvar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="AddEnd" tabindex="-1" role="dialog" aria-labelledby="AddFone" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<form method='POST'>
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Adicionar Endereço</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				
					<div class="modal-body">
						<div class='form-group'>
							<label>Logradouro</label>
							<input class='form-control' type='text' placeholder='Logradouro' name='Logradouro_End' required>
						</div>
						
						<div class='form-group row'>
							<div class='col-sm-3'>
								<label>Numero</label>
								<input class='form-control' type='text' placeholder='Numero' name='Numero_End' required>
							</div>
							
							<div class='col-sm'>
								<label>Complemento</label>
								<input class='form-control' type='text' placeholder='Complemento' name='Complemento_End' required>
							</div>
						</div>
						
						<div class='form-group'>
							<label>Bairro</label>
							<input class='form-control' type='text' placeholder='Cidade' name='Bairro_End' required>
						</div>
						
						<div class='form-group row'>
							<div class='col-sm'>
								<label>Cidade</label>
								<input class='form-control' type='text' placeholder='Cidade' name='Cidade_End' required>
							</div>
							
							<div class='col-sm-3'>
								<label>Cep</label>
								<input class='form-control' type='text' placeholder='Cep' name='Cep_End' required>
							</div>
						</div>
						
						
						
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
						<button type="submit" class="btn btn-success" name='SalvaEnd'>Salvar</button>
					</div>
				</form>
			</div>
		</div>
	</div>