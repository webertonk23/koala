<?php
	$Read = new read();
	$Update = new Update;
	$Create = new Create;
	$Tabulador = new Tabulador();
	
	if(!empty($_POST['Pos'])){
		$statusTel['Status_tel'] = $_POST['Pos'];
		$IdFone = $_POST['IdTel'];
		
		$Read->ExeRead('Telefones WITH (NOLOCK)', "WHERE Id_tel = :Id AND Status_tel != :Status", "Id={$IdFone}&Status={$statusTel['Status_tel']}");
		
		if($Read->GetRowCount()>0){
			$_POST['IdUser'] = $_SESSION['Usuario']['Id_user'];
			$_POST['Obs'] = "Status do telefone alterado de {$Read->GetResult()[0]['Status_tel']} para {$statusTel['Status_tel']}.";
			
			$Update->ExeUpdate('Telefones', $statusTel, 'WHERE Id_tel = :IdFone', "IdFone={$IdFone}");
			
			$Tabulador->IncHistorico($_POST['IdPes'], 0, $_POST['IdTel'], $_POST['IdUser'], null, null, $_POST['Obs'], null);
			echo "<script> window.location.replace('?".$_SERVER['QUERY_STRING']."') </script>";
		}	
	}
	
	if(isset($_POST['whats'])){
		$statusTel['whatsapp_tel'] = (!empty($_POST['whats'])) ? 0 : 1;
		$IdFone = $_POST['IdTel'];
		
		$Read->ExeRead('Telefones WITH (NOLOCK)', "WHERE Id_tel = :Id", "Id={$IdFone}");
		
		if($Read->GetRowCount()>0){
			$_POST['IdUser'] = $_SESSION['Usuario']['Id_user'];
			$_POST['Obs'] = "marcação de whatsapp do telefone alterado de {$Read->GetResult()[0]['whatsapp_tel']} para {$statusTel['whatsapp_tel']}.";
			
			$Update->ExeUpdate('Telefones', $statusTel, 'WHERE Id_tel = :IdFone', "IdFone={$IdFone}");
			
			$Tabulador->IncHistorico($_POST['IdPes'], 0, $_POST['IdTel'], $_POST['IdUser'], null, null, $_POST['Obs'], null);
			echo "<script> window.location.replace('?".$_SERVER['QUERY_STRING']."') </script>";
		}	
	}
	
	if(isset($_POST['AddFone'])){	
		$_POST['idpes_tel'] = $_POST['AddFone'];
		
		$_POST['ddd_tel'] = (int) $_POST['ddd_tel'];
		$_POST['Telefone_tel'] = (int) $_POST['Telefone_tel'];
		$_POST['idpes_tel'] = (int) $_POST['idpes_tel'];
		$_POST['origem_tel'] = 'Operação';
		
		$Read->ExeRead('telefones WITH (NOLOCK)', "WHERE ddd_tel = :ddd AND telefone_tel = :fone AND idpes_tel = :idpes", "ddd={$_POST['ddd_tel']}&fone={$_POST['Telefone_tel']}&idpes={$_POST['AddFone']}");
		
		if(empty($Read->GetRowCount())){
			unset($_POST['AddFone']);
			$Create->ExeCreate('telefones', $_POST);
			
			$_POST['IdUser'] = $_SESSION['Usuario']['Id_user'];
			$_POST['Obs'] = "Novo telefone incluido";
			$_POST['IdTel'] = $Create->GetResult();
			
			
			$Tabulador->IncHistorico($_POST['idpes_tel'], 0, $_POST['IdTel'], $_POST['IdUser'], null, null, $_POST['Obs'], null);
			echo "<script> window.location.replace('?".$_SERVER['QUERY_STRING']."') </script>";
		}
	}
	
	if(isset($_POST['SalvarDados'])){	
		$idF = $_POST['SalvarDados'];
		unset($_POST['SalvarDados']);
		
		$Read->ExeRead('fichas WITH (NOLOCK)', "WHERE id_ficha = :idficha", "idficha={$idF}");
		if($Read->GetRowCount()>0){
		
			$Update->ExeUpdate('fichas', $_POST, "WHERE id_ficha = :idficha", "idficha={$idF}");
			
			$_POST['idpes'] = $Read->GetResult()[0]['IdPes_Ficha'];
			$_POST['IdUser'] = $_SESSION['Usuario']['Id_user'];
			$_POST['Obs'] = "Dados bancarios alterados<br>
				Banco {$Read->GetResult()[0]['Banco_ficha']} -> {$_POST['Banco_ficha']}<br>
				Agência {$Read->GetResult()[0]['Agencia_ficha']} -> {$_POST['Agencia_ficha']}<br>
				Conta {$Read->GetResult()[0]['Cc_ficha']} -> {$_POST['Cc_ficha']}<br>
				Digito {$Read->GetResult()[0]['CcDv_ficha']} -> {$_POST['CcDv_ficha']}";

			//Debug($_POST);
			
			$Tabulador->IncHistorico($_POST['idpes'], 0, null, $_POST['IdUser'], null, null, $_POST['Obs'], null);
			echo "<script> window.location.replace('?".$_SERVER['QUERY_STRING']."') </script>";
		}
	}
	
	if(isset($_POST['SalvarEnd'])){	
		$idP = $_POST['SalvarEnd'];
		unset($_POST['SalvarEnd']);
			
		$Read->ExeRead('Pessoas WITH (NOLOCK)', "WHERE id_pes = :id_pes", "id_pes={$idP}");
		if($Read->GetRowCount()>0){
		
			$Update->ExeUpdate('Pessoas', $_POST, "WHERE id_pes = :id_pes", "id_pes={$idP}");
			
			$_POST['IdUser'] = $_SESSION['Usuario']['Id_user'];
			$_POST['Obs'] = "Endereço alterado<br>
				Logradouro {$Read->GetResult()[0]['Logradouro_Pes']} -> {$_POST['Logradouro_Pes']}<br>
				Nº {$Read->GetResult()[0]['Numero_Pes']} -> {$_POST['Numero_Pes']}<br>
				Complemento {$Read->GetResult()[0]['Complemento_Pes']} -> {$_POST['Complemento_Pes']}<br>
				Bairro {$Read->GetResult()[0]['Bairro_Pes']} -> {$_POST['Bairro_Pes']}<br>
				Cidade {$Read->GetResult()[0]['Cidade_Pes']} -> {$_POST['Cidade_Pes']}<br>
				Uf {$Read->GetResult()[0]['Estado_Pes']} -> {$_POST['Estado_Pes']}<br>
				CEP {$Read->GetResult()[0]['Cep_Pes']} -> {$_POST['Cep_Pes']}<br>";
			$Tabulador->IncHistorico($idP, 0, null, $_POST['IdUser'], null, null, $_POST['Obs'], null);
			echo "<script> window.location.replace('?".$_SERVER['QUERY_STRING']."') </script>";
		}
	}
	
	if(!empty($_GET['Id'])){
		$IdPes = explode("-", $_GET['Id'])[0];
		$Idficha = (!empty(explode("-", $_GET['Id'])[1])) ? explode("-", $_GET['Id'])[1] : null;
		
		$Read->ExeRead("Pessoas WITH (NOLOCK)", "WHERE Id_Pes = :Id", "Id={$IdPes}");
		if($Read->GetRowCount()>0){
			$Cliente = $Read->GetResult();
		}
		
		$Read->ExeRead("Fichas WITH (NOLOCK) INNER JOIN carteira ON IdCart_ficha = Id_Cart", "WHERE IdPes_ficha = :Id", "Id={$IdPes}");
		
		$Fichas = ($Read->GetRowCount() > 0) ? $Fichas = $Read->GetResult() : null;
		
		$Read->ExeRead("Telefones WITH (NOLOCK)", "WHERE IdPes_tel = :Id", "Id={$IdPes}");
		
		$Telefones = ($Read->GetRowCount() > 0) ? $Read->GetResult() : null;
		
		$IdTab = array();
		
		foreach($Fichas as $Values){
			$IdTab = explode(",", $Values['Tab_Cart']);
			
			foreach($IdTab as $Id){
				$Id = str_replace("'", "", $Id);
				
				$Read->FullRead("SELECT * FROM Tabulacao WITH (NOLOCK) WHERE Id_tab = :Id AND Ativo_tab = 1 AND Origem_tab = 'OPERADOR'", "Id={$Id}");
				$Tabulacao[] = ($Read->GetRowCount() > 0) ? $Read->GetResult()[0] : null;

			}
		}
		
		$Tabulacao = array_unique($Tabulacao, SORT_REGULAR);		
		
	}
	
	if(!empty($_GET['Fila'])){
		$Read->FullRead("SELECT * FROM Fila WITH (NOLOCK) WHERE iddisc_fila = :IdFila", "IdFila={$_GET['Fila']}");
		$Fila = ($Read->GetRowCount() > 0) ? $Read->GetResult()[0] : null;
		$consloe = json_encode($Read);
	}else if(!empty($_SESSION['Usuario']['IdFila_User'])){
		$Read->FullRead("SELECT * FROM Fila WITH (NOLOCK) WHERE id_fila = :IdFila", "IdFila={$_SESSION['Usuario']['IdFila_User']}");
		$Fila = ($Read->GetRowCount() > 0) ? $Read->GetResult()[0] : null;
	}
	
	unset($_POST);
?>

<div class='card mb-2 text-center'>
	<div class='card-body'>
		<h3 style="margin-bottom: 0px;">
		<?php
			if(!empty($_GET['Tipo'])){
				switch($_GET['Tipo']){
					case 'R':
						$t = 'Receptivo';
					break;
					
					case 'A':
						$t = 'Ativo';
					break;
					
					case 'Rt':
						$t = 'Retorno';
					break;
					
					case 'I':
						$t = 'Indicação';
					break;
				}
				
			}
			echo (!empty($t)) ? $t : '' ?></h3>
	</div>
</div>

<div class="card-deck mb-2">
	<div class="card col-sm-8 px-0">
		<div class="card-header">
			<ul class="nav nav-tabs card-header-tabs">
				<li class="nav-item">
					<a class="nav-link active" id="Cliente-tab" data-toggle="tab" href="#Cliente" role="tab" aria-controls="Cliente" aria-selected="true">Cliente</a>
				</li>
				
				<li class="nav-item">
					<a class="nav-link" id="Ficha-tab" data-toggle="tab" href="#Ficha" role="tab" aria-controls="Ficha" aria-selected="false">Fichas</a>
				</li>
				
				<li class="nav-item">
					<a class="nav-link" id="End-tab" data-toggle="tab" href="#EndsAd" role="tab" aria-controls="EndsAd" aria-selected="false">Endereço</a>
				</li>
			</ul>
		</div>
		
		<div class='tab-content' id="myTabContent">
			<div class="tab-pane fade show active" id="Cliente" role="tabpanel" aria-labelledby="Cliente-tab">
				<div class='card-body'>
					<h5 class='card-title'><?php echo $Cliente[0]['Nome_Pes'] ?></h5>
					<div class='form-row'>
						<div class="form-group col-sm-4">
							<label>CPF / CNPJ</label>
							<label class="form-control" ><?php echo (!empty($Cliente[0]['CpfCnpj_Pes'])) ? $Cliente[0]['CpfCnpj_Pes'] : '' ?></label>
						</div>
						
						<div class="form-group col-sm">
							<label>Dt Nascimento</label>
							<label class="form-control" ><?php echo (!empty($Cliente[0]['DtNasc_Pes'])) ? date("d/m/Y", strtotime($Cliente[0]['DtNasc_Pes'])) : '' ?></label>
						</div>
						
						<div class="form-group col-sm">
							<label>Idade</label>
							<label class="form-control" ><?php echo (!empty($Cliente[0]['DtNasc_Pes'])) ? floor((strtotime(date("Y-m-d")) - strtotime($Cliente[0]['DtNasc_Pes']))/31536000) : 0 ?> Anos</label>
						</div>
						
						<div class="form-group col-sm">
							<label>Sexo</label>
							<label class="form-control" ><?php echo (!empty($Cliente[0]['Sexo_Pes'])) ? $Cliente[0]['Sexo_Pes'] : '' ?></label>
						</div>					
					</div>
					
					<table class='table table-sm table-striped' style='overflow-x: scroll;'>
						<thead>
							<tr>
								<th>Carteira</th>
								<th>Contrato / Benefício</th>
								<th>Entidade</th>
								<th>Espécie</th>
								<th>Convenio</th>
								<th>Salário</th>
								<th>Margem</th>
								<th>Limite Saque</th>
								<th></th>
							</tr>
						</thead>
						
						<tbody>
								
							<?php
								foreach($Fichas as $Values){
									echo "<tr>";
									echo (!empty($Values['Desc_Cart'])) ? "<td><small>{$Values['Desc_Cart']}</small></td>" : "<td></td>" ;
									echo (!empty($Values['Contrato_Ficha'])) ? "<td><small>{$Values['Contrato_Ficha']}</small></td>" : "<td></td>" ;
									echo ( !empty($Values['DesEnt_ficha'])) ? "<td><small>".$Values['Ent_ficha'] ." - ". $Values['DesEnt_ficha']."</small></td>" : "<td></td>";
									echo ( !empty($Values['Especie_ficha'])) ? "<td><small>".$Values['CodEsp_ficha'] ." - ". $Values['Especie_ficha']."</small></td>" : "<td></td>";
									echo ( !empty($Values['convenio_ficha'])) ? "<td><small>".$Values['convenio_ficha']."</small></td>" : "<td></td>";
									echo (!empty($Values['Salario_ficha'])) ? "<td><small>".number_format($Values['Salario_ficha'], 2, ",", ".")."</small></td>" : "<td></td>" ;
									echo (!empty($Values['Margem_ficha'])) ? "<td><small>".number_format($Values['Margem_ficha'], 2, ",", ".")."</small></td>" : "<td></td>" ;
									echo (!empty($Values['LimiteSaque_ficha'])) ? "<td><small>".number_format($Values['LimiteSaque_ficha'], 2, ",", ".")."</small></td>" : "<td></td>" ;
									echo "</tr>";
							
								}
							?>
						</tbody>
					</table>
					
				</div>
			</div>
			
			<div class="tab-pane fade" id="Ficha" role="tabpanel" aria-labelledby="Ficha-tab">
				<div class='card-body'>
					<table class='table table-sm table-striped table-responsive'>
						<thead>
							<tr>
								<th>Carteira</th>
								<th>Contrato / Benefício</th>
								<th>Dt. Ult. Acio.</th>
								<th>Dt. Prox. Acio.</th>
								<th>Ult Tabulação</th>
								<th>Arquivo</th>
								<th></th>
							</tr>
						</thead>
						
						<tbody>
								
							<?php
								foreach($Fichas as $Values){
									echo "<tr>";
									echo (!empty($Values['Desc_Cart'])) ? "<td><small>{$Values['Desc_Cart']}</small></td>" : "<td></td>" ;
									echo (!empty($Values['Contrato_Ficha'])) ? "<td><small>{$Values['Contrato_Ficha']}</small></td>" : "<td></td>" ;
									echo (!empty($Values['DtUltAcio_Ficha'])) ? "<td><small>". explode(".", $Check->Data($Values['DtUltAcio_Ficha']))[0]. "<small></td>" : "<td></td>" ;
									echo (!empty($Values['DtProxAcio_Ficha'])) ? "<td><small>". explode(".", $Check->Data($Values['DtProxAcio_Ficha']))[0]. "<small></td>" : "<td></td>" ;
									echo (!empty($Values['UltTab_Ficha'])) ? "<td><small>{$Values['UltTab_Ficha']}</small></td>" : "<td></td>" ;
									echo (!empty($Values['ArqInc_Ficha'])) ? "<td><small>{$Values['ArqInc_Ficha']}</small></td>" : "<td></td>" ;
									echo "<td><button type='button' class='btn btn-sm' data-toggle='modal' data-target='#Expandir{$Values['Id_Ficha']}'><span class='fa fa-plus'></span></a>";
									echo "<button type='button' class='btn btn-sm' value='{$Values['Contrato_Ficha']}' onclick='getDados(this.value)'><span class='fa fa-search'></span></button></td>";
									echo "</tr>";
							?>
						
						
							<div class="modal fade" id="Expandir<?php echo $Values['Id_Ficha']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<form method='POST'>
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLongTitle"></h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class='modal-body'>
												
												<!--Dados Beneficio-->
													
												<div class='form-row'>
													<div class="form-group col-sm-6">
														<label>Especie de Benefício</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['CodEsp_ficha'])) ? $Values['CodEsp_ficha'] ." - ". $Values['Especie_ficha'] : "" ; ?>'>
													</div>
													
													<div class="form-group col-sm-6">
														<label>Entidade</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['Ent_ficha'])) ? $Values['Ent_ficha'] ." - ". $Values['DesEnt_ficha'] : "" ; ?>'>
													</div>
												</div>
												
												<div class='form-row'>
													<div class="form-group col-sm-6">
														<label>Meio de pagamento</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['MeioPgt_ficha'])) ? $Values['MeioPgt_ficha'] ." - ". $Values['MeioPgtDesc_ficha'] : "" ; ?>'>
													</div>
													
													<div class="form-group col-sm-6">
														<label>Uf Atual</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['UfAtual_ficha'])) ? $Values['UfAtual_ficha'] : "" ; ?>'>
													</div>
												</div>
							
												<!-- Dados Bancarios -->
												<div class='form-row'>
													<div class="form-group col-sm">
														<label>Banco</label>
														<input type='text' name='Banco_ficha' class='form-control' value='<?php echo (isset($Values['Banco_ficha'])) ? $Values['Banco_ficha'] : "" ; ?>'>
													</div>
													
													<div class="form-group col-sm">
														<label>Agência</label>
														<input type='text' name='Agencia_ficha' class='form-control' value='<?php echo (isset($Values['Agencia_ficha'])) ? $Values['Agencia_ficha'] : "" ; ?>'>
													</div>
													
													<div class="form-group col-sm">
														<label>Conta</label>
														<input type='text' name='Cc_ficha' class='form-control' value='<?php echo (isset($Values['Cc_ficha'])) ? $Values['Cc_ficha'] : "" ; ?>'>
													</div>
													
													<div class="form-group col-sm">
														<label>Conta Dv</label>
														<input type='text' name='CcDv_ficha' class='form-control' value='<?php echo (isset($Values['CcDv_ficha'])) ? $Values['CcDv_ficha'] : "" ; ?>'>
													</div>
												</div>
												
												<!-- Dados Operação -->
												<div class='form-row'>
													<div class="form-group col-sm">
														<label>Salário</label>
														<div class="input-group mb-3">
															<div class="input-group-prepend">
																<span class="input-group-text">R$</span>
															</div>
															<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['Salario_ficha'])) ? number_format($Values['Salario_ficha'], 2, ',', '.') : "" ; ?>'>
														</div>
													</div>
													
													<div class="form-group col-sm">
														<label>Limite</label>
														
														<div class="input-group mb-3">
															<div class="input-group-prepend">
																<span class="input-group-text">R$</span>
															</div>
															<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['Limite_Ficha'])) ? number_format($Values['Limite_Ficha'], 2, ',', '.') : "" ; ?>'>
														</div>
													</div>
													
													<div class="form-group col-sm">
														<label>Limite Saque</label>
														<div class="input-group mb-3">
															<div class="input-group-prepend">
																<span class="input-group-text">R$</span>
															</div>
															<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['LimiteSaque_ficha'])) ? number_format($Values['LimiteSaque_ficha'], 2, ',', '.') : "" ; ?>'>
														</div>
													</div>
													
													<div class="form-group col-sm">
														<label>Margem</label>
														<div class="input-group mb-3">
															<div class="input-group-prepend">
																<span class="input-group-text">R$</span>
															</div>
															<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['Margem_ficha'])) ? number_format($Values['Margem_ficha'], 2, ',', '.') : "" ; ?>'>
														</div>
															
													</div>
												</div>
										
												<div class='form-row'>
													<div class="form-group col-sm">
														<label>Qtd Emp</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['QtdEmp_ficha'])) ? $Values['QtdEmp_ficha'] : "" ; ?>'>
													</div>
													
													<div class="form-group col-sm">
														<label>Soma Parc</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['SomaParc_ficha'])) ? $Values['SomaParc_ficha'] : "" ; ?>'>
													</div>
													
													<div class="form-group col-sm">
														<label>Valor Op</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['ValorOp_ficha'])) ? "R$ ". number_format($Values['ValorOp_ficha'], 2, ",", ".")  : "" ; ?>'>
													</div>
													
													<div class="form-group col-sm">
														<label>Contrato</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['Contr_ficha'])) ? $Values['Contr_ficha'] : "" ; ?>'>
													</div>
													
													<div class="form-group col-sm">
														<label>Assessoria</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['Assessoria_ficha'])) ? $Values['Assessoria_ficha'] : "" ; ?>'>
													</div>
												</div>
												
												<div class='form-row'>
													<div class="form-group col-sm">
														<label>Valor Desconto Divida</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['VlDesc_ficha'])) ? "R$ ". number_format($Values['VlDesc_ficha'], 2, ",", ".")  : "" ; ?>'>
													</div>
													
													<div class="form-group col-sm">
														<label>Valor Margem Compl</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['VlMargemComp_ficha'])) ? "R$ ". number_format($Values['VlMargemComp_ficha'], 2, ",", ".")  : "" ; ?>'>
													</div>
													
													<div class="form-group col-sm">
														<label>Valor Lib Margem Compl</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['VlLibMargemComp_ficha'])) ? "R$ ". number_format($Values['VlLibMargemComp_ficha'], 2, ",", ".")  : "" ; ?>'>
													</div>
													
													<div class="form-group col-sm">
														<label>Dt Vencimento</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['Venc_ficha'])) ? date("d/m/Y", strtotime($Values['Venc_ficha']))  : "" ; ?>'>
													</div>
												</div>

												<div class='form-row'>
													<div class="form-group col-sm">
														<label>Valor Pmt</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['Valorpmt_ficha'])) ? "R$ ". number_format($Values['Valorpmt_ficha'], 2, ',', '.') : "" ; ?>'>
													</div>
													
													<div class="form-group col-sm">
														<label>Prazo</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['Prazo_ficha'])) ? $Values['Prazo_ficha'] : "" ; ?>'>
													</div>
													
													<div class="form-group col-sm">
														<label>Qtd Pagas</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['Qtdpmtpagas_ficha'])) ? "R$ ". number_format($Values['Qtdpmtpagas_ficha'], 2, ",", ".")  : "" ; ?>'>
													</div>
													
													<div class="form-group col-sm">
														<label>Pmt Venc</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['Pmtvencidas_ficha'])) ? $Values['Pmtvencidas_ficha'] : "" ; ?>'>
													</div>
													
													<div class="form-group col-sm">
														<label>Pri Vencimento</label>
														<input type='text' class='form-control' readonly value='<?php echo (!empty($Values['Primeirovcto_ficha'])) ? date("d/m/Y", strtotime($Values['Primeirovcto_ficha'])) : "" ; ?>'>
													</div>
												</div>
											</div>	
											
											<div class='modal-footer'>
												<button type="submit" class="btn btn-success" name='SalvarDados' value='<?php echo $Values['Id_Ficha']?>'>Salvar</button>
												<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						
							<?php
								}
							?>
						</tbody>
					</table>		
				</div>
			</div>
			
			<div class="tab-pane fade" id="EndsAd" role="tabpanel" aria-labelledby="End-tab">
				<div class='card-body'>
					<form method='POST'>
						<div class='form-row'>
							<div class="form-group col-sm-6">
								<label>Logradouro</label>
								<input type='text' name='Logradouro_Pes' class="form-control" value='<?php echo (!empty($Cliente[0]['Logradouro_Pes'])) ? $Cliente[0]['Logradouro_Pes'] : '' ?>'/>
							</div>
							
							<div class="form-group col-sm-2">
								<label>Nº</label>
								<input type='text' name='Numero_Pes' class="form-control" value='<?php echo (!empty($Cliente[0]['Numero_Pes'])) ? $Cliente[0]['Numero_Pes'] : '' ?>'/>
							</div>
							
							<div class="form-group col-sm">
								<label>Complemento</label>
								<input type='text' name='Complemento_Pes' class="form-control" value='<?php echo (!empty($Cliente[0]['Complemento_Pes'])) ? $Cliente[0]['Complemento_Pes'] : '' ?>'/>
							</div>
						</div>

						<div class='form-row'>
							<div class="form-group col-sm">
								<label>Bairro</label>
								<input type='text' name='Bairro_Pes' class="form-control" value='<?php echo (!empty($Cliente[0]['Bairro_Pes'])) ? $Cliente[0]['Bairro_Pes'] : '' ?>'/>
							</div>
							
							<div class="form-group col-sm">
								<label>Cidade</label>
								<input type='text' name='Cidade_Pes' class="form-control" value='<?php echo (!empty($Cliente[0]['Cidade_Pes'])) ? $Cliente[0]['Cidade_Pes'] : '' ?>'/>
							</div>
							
							<div class="form-group col-sm">
								<label>Estado</label>
								<input type='text' name='Estado_Pes' class="form-control" value='<?php echo (!empty($Cliente[0]['Estado_Pes'])) ? $Cliente[0]['Estado_Pes'] : '' ?>'/>
							</div>
							
							<div class="form-group col-sm">
								<label>CEP</label>
								<input type='text' name='Cep_Pes' class="form-control" value='<?php echo (!empty($Cliente[0]['Cep_Pes'])) ? $Cliente[0]['Cep_Pes'] : '' ?>'/>
							</div>
						</div>
						
						<button type="submit" class="btn btn-success" name='SalvarEnd' value='<?php echo $IdPes?>'>Salvar</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="card col-sm-4 px-0">
		<div class="card-header">
			<ul class="nav nav-tabs card-header-tabs">
				<li class="nav-item">
					<a class="nav-link active" id="Fones-tab" data-toggle="tab" href="#Fones" role="tab" aria-controls="Fones" aria-selected="false">Fones</a>
				</li>
				
				<li class="nav-item">
					<a class="nav-link" id="AddFone-tab" data-toggle="tab" href="#AddFones" role="tab" aria-controls="Fones" aria-selected="false">Novo</a>
				</li>
			</ul>
		</div>
			
		<div class='tab-content' id="myTabContent">
			<div class="tab-pane fade active show" id="Fones" role="tabpanel" aria-labelledby="Fones-tab">
				<div class='card-body'>
					<?php 
						if(!empty($Telefones)){
							foreach ($Telefones as $key => $value){
								echo "<div class='row align-items-center mb-1'>";
								echo (!empty($Fila)) ? "<button class='btn btn-outline-primary btn-sm col-sm-1' onClick=\"vonix.doDial('0{$value['ddd_tel']}{$value['Telefone_tel']}', '{$Cliente[0]['Nome_Pes']}', '{$Fila['iddisc_fila']}', 1, '{$Cliente[0]['Id_Pes']}');\">&#x0260F;</button>" : "";
								echo "<h6 class='col-6'>({$value['ddd_tel']}) {$value['Telefone_tel']}</h6>";
								$pclass = ($value['Status_tel'] == 1) ? "" : "-outline" ;
								$nclass = ($value['Status_tel'] == -1) ? "" : "-outline" ;
								$wclass = ($value['whatsapp_tel'] == 1) ? "" : "-outline" ;
								echo "<form method='POST' class='col-sm-4' ><button class='btn btn$pclass-success btn-sm mr-1' name='Pos' value='1'><span class='fa fa-plus'></span></button>";
								echo "<button class='btn btn$nclass-danger btn-sm mr-1' name='Pos' value='-1'><span class='fa fa-minus'></span></button>";
								echo "<button class='btn btn$wclass-info btn-sm ' name='whats' value='{$value['whatsapp_tel']}'><span class='fa fa-whatsapp'></span></button>";
								echo "<input type='hidden' name='IdPes' value='{$value['IdPes_tel']}'>";
								echo "<input type='hidden' name='IdTel' value='{$value['Id_tel']}'>";
								echo "</form></div>";
							}
						}else{
							echo "<br><h2 class='card-text text-center'>Sem Fones</h2><br>";
						}
					?>
				</div>
			</div>
			
			<div class="tab-pane fade" id="AddFones" role="tabpanel" aria-labelledby="AddFone-tab">
				<div class='card-body'>
					<form method='POST'>
						<div class='form-row'>
							<div class="form-group col-sm-3 mx-1">
								<label>DDD</label>
								<input class="form-control" type="number" id="ddd_tel" name="ddd_tel" Placeholder="DDD" required min='11' max='99' step='1'>
							</div>
							
							<div class="form-group col-sm">	
								<label>Fone</label>
								<input class="form-control" type="number" id="Telefone_tel" name="Telefone_tel" Placeholder="Telefone" min='11111111' max='999999999' step='1'>
							</div>
							
							<div class="form-group col-sm-2">	
								<label class='text-white'>.</label>
								<button class='btn btn-success btn-sm form-control' name='AddFone' value='<?php echo $IdPes; ?>'><span class='fa fa-check'></span></button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>	
	</div>
</div>	

	<div class='card'>
		<div class="card-header">
			<ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="Acionamentos-tab" data-toggle="tab" href="#Acionamentos" role="tab" aria-controls="Acionamentos" aria-selected="true">Histórico de Acionamentos</a>
				</li>
				
				<?php
					$a = array();
					foreach($Fichas as $Values){
						if(!in_array($Values['Perfil_Cart'], $a)){
							echo "<li class='nav-item'>
									<a class='nav-link' id='{$Values['Perfil_Cart']}-tab' data-toggle='tab' href='#{$Values['Perfil_Cart']}' role='tab' aria-controls='{$Values['Perfil_Cart']}' aria-selected='false'>{$Values['Perfil_Cart']}</a>
								</li>";
							$a[] = $Values['Perfil_Cart'];
						}
					}
				?>
			</ul>
		</div>
		
		<div class='tab-content' id="myTabContent">
			<div class="tab-pane fade show active" id="Acionamentos" role="tabpanel" aria-labelledby="Acionamentos-tab">
				<div class='card-body'>
					<button class='btn btn-outline-success mb-sm-2' role="button" name='AddAcionamento' data-toggle="modal" data-target="#AddAcionamento"><span class="oi oi-plus"></span>Adicionar Acionamento</button>
					<table class='table table-hover table-sm'>
						<thead>
							<tr>
								<th>Data</th>
								<th>Tabulacao</th>
								<th>Telefone</th>
								<th>Obs</th>
								<th>Usuario</th>								
								<th>Carteira</th>								
								<th>Tipo</th>								
							</tr>
						</thead>
					
						<tbody>
							<form  method='POST' action='?p=Acionamento\submit'>
								<?php
									$Read->ExeRead(
										"Historico WITH (NOLOCK) LEFT JOIN Usuarios ON IdUser_hist = Id_User LEFT JOIN Tabulacao ON Idtab_hist = Id_tab LEFT JOIN Telefones ON Idtel_hist = Id_tel LEFT JOIN fichas ON IdFicha_hist = Id_Ficha LEFT JOIN carteira ON IdCart_Ficha = Id_Cart",
										"WHERE IdPes_hist = :IdPes ORDER BY DtOco_hist DESC",
										"IdPes={$IdPes}"
									);
									
									$Lista = ($Read->GetRowCount() > 0) ? $Read->GetResult() : null;
									
									if(!empty($Lista)){
										foreach ($Lista as $key => $value){
											echo "<tr><td>".date("d/m/Y H:i:s", strtotime($value['DtOco_hist']))."</td>";
											echo (!empty($value['Tabulacao_tab'])) ? "<td>".$value['Origem_tab']." -> ".$value['Tabulacao_tab']."</td>" : "<td></td>";
											echo (!empty($value['Telefone_tel'])) ? "<td>({$value['ddd_tel']}){$value['Telefone_tel']}</td>" : "<td></td>";
											echo "<td>".$value['Obs_hist']."</td>";
											echo "<td>".$value['Nome_user']."</td>";
											echo "<td>".$value['Desc_Cart']."</td>";
											
											switch($value['Tipo_hist']){
												case 'A': echo "<td>Ativo</td>";
												break;
												case 'R': echo "<td>Recepitivo</td>";
												break;
												case 'Rt': echo "<td>Retorno</td>";
												break;
												case 'I': echo "<td>Indicação</td>";
												break;
												default: echo "<td></td>";
											}
									
											echo "</tr>";
										}
									};
									
								?>
							</form>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="tab-pane fade" id="Agendamentos" role="tabpanel" aria-labelledby="Agendamentos-tab">
				<div class='card-body'>
					<button class='btn btn-outline-success mb-sm-2' role="button" name='AddAgenda' data-toggle="modal" data-target="#AddAgenda"><span class="oi oi-plus"></span> Adicionar Agenda</button>
					<table class='table table-hover table-sm'>
						<thead>
							<tr>
								<th>Data</th>
								<th>Hora</th>
								<th>Produto</th>
								<th>Usuario</th>								
							</tr>
						</thead>
					
						<tbody>
							<form  method='POST' action='?p=Acionamento\submit'>
								<?php
									if(!empty($Agendas)){
										foreach ($Agendas as $key => $Value){
											echo "<tr><td>".$Check->Data($Value['Data'])."</td>";
											echo "<td>".$Value['Hora']."</td>";
											echo "<td>".$Value['Produto']."</td>";
											echo "<td>".$Value['Usuario']."</td></tr>";
										}
									};
									
								?>
							</form>
						</tbody>
					</table>				
				</div>
			</div>
			
			<div class="tab-pane fade" id="Pesquisa" role="tabpanel" aria-labelledby="Pesquisa-tab">
				<div class='card-body'>
					<button class='btn btn-outline-success mb-sm-2' role="button" name='AddAgenda' data-toggle="modal" data-target="#AddAgenda"><span class="oi oi-plus"></span> Adicionar Agenda</button>
					<table class='table table-hover table-sm'>
						<thead>
							<tr>
								<th>Data</th>
								<th>Hora</th>
								<th>Produto</th>
								<th>Usuario</th>								
							</tr>
						</thead>
					
						<tbody>
							<form  method='POST' action='?p=Acionamento\submit'>
								<?php
									if(!empty($Agendas)){
										foreach ($Agendas as $key => $Value){
											echo "<tr><td>".$Check->Data($Value['Data'])."</td>";
											echo "<td>".$Value['Hora']."</td>";
											echo "<td>".$Value['Produto']."</td>";
											echo "<td>".$Value['Usuario']."</td></tr>";
										}
									};
									
								?>
							</form>
						</tbody>
					</table>				
				</div>
			</div>
			
			<div class="tab-pane fade" id="Vendas" role="tabpanel" aria-labelledby="Vendas-tab">
				<div class='card-body'>
					<button class='btn btn-outline-success mb-sm-2' role="button" name='AddVenda' data-toggle="modal" data-target="#AddVenda"><span class="oi oi-plus"></span>Adicionar Venda</button>
					<table class='table table-hover table-sm'>
						<thead>
							<tr>
								<th>Data</th>
								<th>Nº Venda</th>
								<th>Valor</th>
								<th>Status</th>
								<th>Produto</th>
								<th>Motivo</th>
								<th>Carteira</th>
								<th>Usuario</th>								
							</tr>
						</thead>
					
						<tbody>
							<form  method='POST' action='?p=Acionamento/submit'>
								<?php
									$Vendas = new Vendas;
	
									$Vendas->Listar(array('Id_Pes' => $IdPes));
									
									if(!$Vendas->GetErro()){
										$Listar = $Vendas->GetResult();
									}

									if(!empty($Listar)){
										foreach ($Listar as $key => $Value){
											echo "<tr><td>".$Check->Data($Value['dtvenda_venda'])."</td>";
											echo "<td>".$Value['numero_venda']."</td>";
											echo "<td>R$ ".number_format($Value['valor_venda'], 2, ',', '.')."</td>";
											echo "<td>".$Value['status_venda']."</td>";
											echo "<td>".$Value['desc_prod']."</td>";
											echo "<td>".$Value['motivost_venda']."</td>";
											echo "<td>".$Value['Desc_Cart']."</td>";
											echo "<td>".$Value['Nome_user']."</td></tr>";
										}
									};
									
								?>
							</form>
						</tbody>
					</table>
				</div>		
			</div>

			<div class="tab-pane fade" id="Retornos" role="tabpanel" aria-labelledby="Retornos-tab">
				<div class='card-body'>
					<button class='btn btn-outline-success mb-sm-2' role="button" name='AddRetorno' data-toggle="modal" data-target="#AddRetorno"><span class="oi oi-plus"></span>Adicionar Retorno</button>
					<table class='table table-hover table-sm'>
						<thead>
							<tr>
								<th>Data</th>
								<th>Hora</th>
								<th>Motivo</th>
								<th>Usuario</th>								
							</tr>
						</thead>
					
						<tbody>
							<form method='POST'>
								<?php
									if(!empty($Retornos)){
										foreach ($Retornos as $key => $Value){
											echo "<tr><td>".$Check->Data($Value['Data'])."</td>";
											echo "<td>".$Value['Hora']."</td>";
											echo "<td>".$Value['Motivo']."</td>";
											echo "<td>".$Value['Usuario']."</td></tr>";
										}
									};
								?>
							</form>
						</tbody>
					</table>
				</div>		
			</div>	
		</div>		
	</div>

	
	<div class="modal fade" id="AddAcionamento" tabindex="-1" role="dialog" aria-labelledby="AddAcionamentolabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="AddAcionamentolabel">Incluir Tabulação</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form class="form" method="POST" action="?p=Atendimento\submit">
					<div class="modal-body">
							<?php
							if(empty($Idficha)){?>
								<div class="form-group">
									<label>Ficha</label>
									<select class="form-control" id="IdFicha" name="IdFicha" required>
										<?php
											if(!empty($Fichas)){
												foreach($Fichas as $Value){
													$sel = ($Value['Id_Ficha'] == $Idficha) ? 'Selected' : '';
													echo "<option value='{$Value['Id_Ficha']}' {$sel}>{$Value['Contrato_Ficha']} - {$Value['Desc_Cart']}</option>";
												}
											
											}
										?>
									</select>
								</div>
							<?php }else{?>
								<input type='hidden' name='IdFicha' value='<?php echo $Idficha; ?>'>
							<?php }?>
							
							<div class="form-group form-row">
								<label>tabulação</label>
								<select class="form-control" id="IdTab" name="IdTab" required>
									<option selected disabled value='0'>Selecione</option>
									<?php
										foreach($Tabulacao as $Value){
											echo "<option value='{$Value['Id_tab']}'>{$Value['Tabulacao_tab']}</option>";
										}
									?>
									
								</select>
							</div>
							
							<div class="form-group form-row">
								<label>Telefones</label>
								<select class="form-control" id="IdTel" name="IdTel" required>
									<option selected disabled value=0>Selecione</option>
									<?php
										if(!empty($Telefones)){
											foreach ($Telefones as $key => $value){
												$sel = (!empty($_GET['Fone']) AND $_GET['Fone'] == $value['ddd_tel'].$value['Telefone_tel']) ? 'selected' : '';
												echo "<option value='{$value['Id_tel']}' $sel>({$value['ddd_tel']}) {$value['Telefone_tel']}</option>";
											}
										}
									?>
									
								</select>
							</div>
							<div class="form-group form-row">
								<label class="form-check"><input class="form-check-input" type="checkbox" id="AgendaOn" onclick="habilitar()" > Agendar Retorno</label>
								<input type='datetime-local' class="form-control" id="Data_Ret" name='Data_Ret' disabled>
							</div>
							<div class="form-group form-row">
								<label>Obs</label>
								<textarea class="form-control" type="text" id="Obs" name="Obs" Placeholder="Obs" rows='7'></textarea>
							</div>
							<input type='hidden' name='IdPes' value='<?php echo $IdPes?>'>
							<input type='hidden' name='IdUser' value='<?php echo $_SESSION['Usuario']['Id_user']?>'>
							<input type='hidden' name='Call_Id' value='<?php echo (!empty($_GET['Call_Id'])) ? $_GET['Call_Id'] : ""; ?>'>
							<input type='hidden' name='Tipo' value='<?php echo (!empty($_GET['Tipo'])) ? $_GET['Tipo'] : 0; ?>'>
							<input type='hidden' name='Fila' value='<?php echo (!empty($_GET['Fila'])) ? $_GET['Fila'] : null; ?>'>
							
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-primary" title = 'Incluir ' name='Incluir' value='Incluir Registro' />
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="AddVenda" tabindex="-1" role="dialog" aria-labelledby="AddVendalabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="AddVendalabel">Incluir Venda</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form class="form" method="POST" action='?p=Submit'>
					<div class="modal-body">
						<div class="form-group">
							<label>Ficha</label>
							<select class="form-control" id="idficha_venda" name="idficha_venda" required>
								<option disabled selected  value='0'>Selecione um contrato</option>
								<?php
									if(!empty($Fichas)){
										foreach($Fichas as $Value){
											if($Value['Perfil_Cart'] == 'Vendas'){
												echo "<option value='{$Value['Id_Ficha']}-{$Value['IdCart_Ficha']}'>{$Value['Contrato_Ficha']} - {$Value['Desc_Cart']}</option>";
											}
										}
									
									}
								?>
								
							</select>
						</div>
						
						<div class="form-group">
							<?php
									$Produtos = new Produtos;
	
									$Produtos->Listar();
									
									if(!$Produtos->GetErro()){
										$Listar = $Produtos->GetResult();
									}
								
							?>
							<label>Produto</label>
							<select class="form-control" id="idprod_venda" name="idprod_venda" required>
								<option disabled selected >Selecione um produto</option>
								<?php
									if(!empty($Listar)){
										foreach($Listar as $Value){
											echo "<option value='{$Value['id_prod']}'>{$Value['desc_prod']}</option>";
										}
									
									}
								?>
								
							</select>
						</div>
						
						<div class="form-group">
							<label>Nº Venda / ADE</label>
							<input class="form-control" type="text" id="numero_venda" name="numero_venda" Placeholder="Nº Venda" required>
						</div>
						
						<div class="form-group">
							<label>Valor</label>
							<input class="form-control" type="number" id="Valor_venda" name="Valor_venda" Placeholder="Valor" min='0' step='0.01'>
						</div>
					</div>
					
					<input type="hidden" name="Tabela" value='Vendas'>
					<input type="hidden" name="iduser_venda" value='<?php echo $_SESSION['Usuario']['Id_user']; ?>'>
					<input type="hidden" name="idpes_venda" value='<?php echo $IdPes; ?>'>
					<input type="hidden" name="Page" value='<?php echo $_SERVER['QUERY_STRING'];?>'>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
						<button type="submit" class="btn btn-primary" title = 'Incluir Venda ' name='Salvar' value='Criar' >Incluir Venda</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="AddAgenda" tabindex="-1" role="dialog" aria-labelledby="AddAgendalabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="AddAgendalabel">Incluir Agenda</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<form class="form" method="POST">
					<div class="modal-body">
						<div class="form-group">
							<label>Produto</label>
							<select class="form-control" id="Produto" name="Produto">
								<?php
									foreach($Produtos as $Value){
										echo "<option value='{$Value['Id']}'>{$Value['Produto']}</option>";
									}
								?>
							</select>
						</div>
						
						<div class="form-group">
							<label>Data</label>
							<input class="form-control" type="datetime-local" id="Data" name="Data">
						</div>
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
						<input type="submit" class="btn btn-primary" title = 'Incluir Agenda ' name='IncluirAgenda' value='Incluir Agenda' />
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="AddRetorno" tabindex="-1" role="dialog" aria-labelledby="AddRetornolabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="AddRetornolabel">Incluir Retorno</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form class="form" method="POST">
					<div class="modal-body">
						<div class="form-group">
							<label>Data</label>
							<input class="form-control" type="datetime-local" id="Data" name="Data">
						</div>
						
						<div class="form-group">
							<label>Usuario</label>
							<select class="form-control" id="Usuario" name="Usuario">
								<?php
									foreach($Usuarios as $Value){
										$sel = ($Value['Id'] == $_SESSION['UsuarioKoala']['Id']) ? 'Selected' : '';
										echo "<option $sel value='{$Value['Id']}'>{$Value['Usuario']}</option>";
									}
								?>
							</select>
						</div>
						
						<div class="form-group form-row">
							<div class="form-group col-sm">
								<label>Motivo</label>
								<textarea class="form-control" type="text" id="Motivo" name="Motivo" Placeholder="Motivo" rows='8' ></textarea>
							</div>
						</div>
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
						<input type="submit" class="btn btn-primary" title = 'Incluir Retorno ' name='IncluirRetorno' value='Incluir Retorno' />
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<script type="text/javascript" src="./js/consultaNB.js"></script>
	
	<script>
		function habilitar(){  
			if(document.getElementById('AgendaOn').checked){  
				document.getElementById('Data_Ret').disabled = false;  
			} else {  
				document.getElementById('Data_Ret').disabled = true;  
			}
		}
		
		
	</script>
