<div class='row justify-content-center'>
	<div class="card col-sm">
		<div class='card-body'>
			<?php
				if(isset($_POST['Salvar'])){
					unset($_POST['Salvar']);
					
					If($_POST['NomeCompleto']==''){
					echo "<div class='alert alert-warning alert-dismissible text-center' role='alert'>
							<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
								<span aria-hidden='true'>&times;</span>
							</button>
							Gentilega Preencher o campo <b>NOME</b> antes de proceguir.
						</div>";
					}else{
						$Check = new Check;
						
						$_POST['NomeCompleto'] = $Check->Name($_POST['NomeCompleto']);
						$_POST['DataNasc'] = ($_POST['DataNasc']) ? $_POST['DataNasc'] : null;
						$_POST['Email'] = ($Check->Email($_POST['Email'])) ? strtoupper($_POST['Email']) : '';
						
						$Editar = new Update;
						
						unset($_POST['Salvar']);
						
						$Editar->ExeUpdate('Funcionarios', $_POST, "WHERE Id = :Id", "Id={$_GET['Id']}");	
						
						echo $Editar->GetResult();
					}
					
				}

				if(isset($_GET['Id'])){
					$Busca = new Read;
					
					$Busca->ExeRead("Funcionarios", "WHERE Id = :Id", "Id={$_GET['Id']}");
					
					$Funcionario = ($Busca->GetRowCount() > 0) ? $Busca->GetResult()[0] : null;
				}
			?>
			
			<form class="form" name="Usuarios" method="POST" enctype="multipart/form-data">
				<label><h3>Editar Funcionario</h3></label>
				
				<fieldset class='border p-2 rounded mb-3'>
					<div class='row'>
						<!--<div class="col-sm-2 ml-2">
							<div class='form-group'>
								<img class='col mt-3' src='./img/fotos/<?php echo (file_exists("./img/fotos/".$Funcionario['matricula'].".png")) ? $Funcionario['matricula'] : "0"?>.png' alt="./img/fotos/0.png">
								
							</div>
							
							<div class='form-group'>
								<label>Arquivo</label>
								<input type="hidden" name="MAX_FILE_SIZE" value="41943040‬"/>
								<input type='file' class='form-control'  name='File' accept="image/png"/>
							</div>
						</div>
						-->
						<div class='col-sm'>
							<label><h5 >Dados Pessoais</h5></label>
							<div class='form-row'>
								<div class="form-group col-sm-2">
									<label>Cod</label>
									<input class="form-control  " disabled type='text' id="Id" name='Id' Placeholder="#Id"  value="<?php echo (!empty($Funcionario['Id'])) ? str_pad($Funcionario['Id'], 4, '0', STR_PAD_LEFT) : '';?>">
								</div>
								
								<div class="form-group col-sm-2">
									<label>Mat</label>
									<input class="form-control  " type='text' id="Id" name='matricula' Placeholder="Mat"  value="<?php echo (!empty($Funcionario['matricula'])) ? str_pad($Funcionario['matricula'], 4, '0', STR_PAD_LEFT) : '';?>">
								</div>
								
								<div class="form-group col-sm">
									<label>Nome Completo</label>
									<input class="form-control" type="text" id="NomeCompleto" name="NomeCompleto" Placeholder="Nome Completo" value="<?php echo (!empty($Funcionario['NomeCompleto'])) ? $Funcionario['NomeCompleto'] : '';?>">
								</div>
								
								<div class="form-group col-sm">
									<label>Nome da Mãe</label>
									<input class="form-control" type="text" id="Mae" name="Mae" Placeholder="Nome da Mãe" value="<?php echo (!empty($Funcionario['Mae'])) ? $Funcionario['Mae'] : '';?>">
								</div>
							</div>
							
							<div class='form-row'>
								<div class="form-group col-sm">
									<label>CPF</label>
									<input class="form-control" type="text" id="Cpf" name="Cpf" Placeholder="Cpf" value="<?php echo (!empty($Funcionario['Cpf'])) ? $Funcionario['Cpf'] : '';?>">
								</div>
								
								<div class="form-group col-sm">
									<label>RG</label>
									<input class="form-control" type="text" id="Rg" name="Rg" Placeholder="RG" value="<?php echo (!empty($Funcionario['Rg'])) ? $Funcionario['Rg'] : '';?>">
								</div>
								
								<div class="form-group col-sm">
									<label>Nº PIS</label>
									<input class="form-control" type="text" id="Pis" name="Pis" Placeholder="Pis" value="<?php echo (!empty($Funcionario['Pis'])) ? $Funcionario['Pis'] : '';?>">
								</div>
								
								<div class="form-group col-sm">
									<label>Estado Civil</label>
									<select class="form-control" id="EstadoCivil" name="EstadoCivil">
										<option selected disabled>Selecione</option>
										<option <?php echo ($Funcionario['EstadoCivil'] == 'Solteiro(a)') ? 'Selected' : '' ?> >Solteiro(a)</option>
										<option <?php echo ($Funcionario['EstadoCivil'] == 'Casado(a)') ? 'Selected' : '' ?> >Casado(a)</option>
										<option <?php echo ($Funcionario['EstadoCivil'] == 'Divorciado(a)') ? 'Selected' : '' ?> >Divorciado(a)</option>
										<option <?php echo ($Funcionario['EstadoCivil'] == 'Viúvo(a)') ? 'Selected' : '' ?> >Viúvo(a)</option>
										<option <?php echo ($Funcionario['EstadoCivil'] == 'Separado(a)') ? 'Selected' : '' ?> >Separado(a)</option>
									</select>
								</div>
								
								<div class="form-group col-sm">
									<label>Escolaridade</label>
									<select class="form-control" id="Escolaridade" name="Escolaridade">
										<option selected disabled>Selecione</option>
										<option <?php echo ($Funcionario['Escolaridade'] == 'Analfabeto') ? 'Selected' : '' ?> >Analfabeto</option>
										<option <?php echo ($Funcionario['Escolaridade'] == 'Fundamental') ? 'Selected' : '' ?> >Fundamental</option>
										<option <?php echo ($Funcionario['Escolaridade'] == 'Médio') ? 'Selected' : '' ?> >Médio</option>
										<option <?php echo ($Funcionario['Escolaridade'] == 'Superior Em Curso') ? 'Selected' : '' ?> >Superior Em Curso</option>
										<option <?php echo ($Funcionario['Escolaridade'] == 'Superior Completo') ? 'Selected' : '' ?> >Superior Completo</option>
									</select>
								</div>
							</div>
							
							<div class='form-row'>
								<div class="form-group col-sm">
									<label>Telefone</label>
									<input class="form-control" type="text" id="Fone" name="Fone" Placeholder="Telefone"  value="<?php echo (!empty($Funcionario['Fone'])) ? $Funcionario['Fone'] : '';?>" >
								</div>
							
								<div class="form-group col-sm">
									<label>E-mail</label>
									<input class="form-control" type="text" id="Email" name="Email" Placeholder="E-Mail" value="<?php echo (!empty($Funcionario['Email'])) ? $Funcionario['Email'] : '';?>">
								</div>
								
								<div class="form-group col-sm">
									<label>Data Nascimento</label>
									<input class="form-control" type="date" id="DataNasc" name="DataNasc" Placeholder="DataNasc" value="<?php echo (!empty($Funcionario['DataNasc'])) ? $Funcionario['DataNasc'] : '';?>">
								</div>
								
								<div class="form-group col-sm">
									<label>Idade</label>
									<input class="form-control" disabled value="<?php echo floor((strtotime(date("Y-m-d")) - strtotime($Funcionario['DataNasc']))/31536000)?> Anos">
								</div>
								
								<div class="form-group col-sm">
									<label>
										Sexo
									</label>
									<div class='check'>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type='radio' name='Sexo' value='M'  <?php echo ($Funcionario['Sexo'] == 'M') ? 'checked' : '' ?> > Masculino</label>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type='radio' name='Sexo' value='F'  <?php echo ($Funcionario['Sexo'] == 'F') ? 'checked' : '' ?> > Feminino</label>
									</div>					
								</div>
							</div>
						</div>
					</div>
				</fieldset>
				
				<fieldset class='border p-2 rounded mb-3'>
					<label><h5 >Dados Profissionais</h5></label>
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Data Admissão</label>
							<input class="form-control" type="date" id="DataAdm" name="DataAdm" Placeholder="DataAdm" value="<?php echo (!empty($Funcionario['DataAdm'])) ? $Funcionario['DataAdm'] : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Data Desligamento</label>
							<input class="form-control" type="date" id="DtDeslig" name="DtDeslig" Placeholder="DtDeslig" value="<?php echo (!empty($Funcionario['DtDeslig'])) ? $Funcionario['DtDeslig'] : null;?>">
						</div>
						
						
						
						<div class="form-group col-sm">
							<label>Status</label>
							<select class="form-control" id="Status" name="Status">
								<option selected disabled>Selecione</option>
								<option Value='Ativo' <?php echo ($Funcionario['Status'] == 'Ativo') ? 'Selected' : '' ?>>Ativo</option>
								<option Value='Inativo' <?php echo ($Funcionario['Status'] == 'Inativo') ? 'Selected' : '' ?>>Inativo</option>
								<option value='Ferias' <?php echo ($Funcionario['Status'] == 'Ferias') ? 'Selected' : '' ?>>Férias</option>
							<option Value='Afastado INSS' <?php echo ($Funcionario['Status'] == 'Afastado INSS') ? 'Selected' : '' ?>>Afastado INSS</option>
							<option value='Licenca Maternidade' <?php echo ($Funcionario['Status'] == 'Licenca Maternidade') ? 'Selected' : '' ?>>Licença maternidade</option>
							<option value='Desligado' <?php echo ($Funcionario['Status'] == 'Desligado') ? 'Selected' : '' ?>>Desligado</option>
							</select>
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Cargo</label>
							<select class="form-control" id="Cargo" name="Cargo">
								<option selected disabled>Selecione</option>
								<option <?php echo ($Funcionario['Cargo'] == 'Analista') ? 'Selected' : '' ?> >Analista</option>
								<option <?php echo ($Funcionario['Cargo'] == 'Assistente') ? 'Selected' : '' ?> >Assistente</option>
								<option <?php echo ($Funcionario['Cargo'] == 'Auxiliar Aministrativo') ? 'Selected' : '' ?> >Auxiliar Aministrativo</option>
								<option <?php echo ($Funcionario['Cargo'] == 'Backoffice') ? 'Selected' : '' ?> >Backoffice</option>
								<option <?php echo ($Funcionario['Cargo'] == 'Coordenador') ? 'Selected' : '' ?> >Coordenador</option>
								<option <?php echo ($Funcionario['Cargo'] == 'Diretor') ? 'Selected' : '' ?> >Diretor</option>
								<option <?php echo ($Funcionario['Cargo'] == 'Gerente') ? 'Selected' : '' ?> >Gerente</option>
								<option <?php echo ($Funcionario['Cargo'] == 'Monitor') ? 'Selected' : '' ?> >Monitor</option>
								<option <?php echo ($Funcionario['Cargo'] == 'Operador') ? 'Selected' : '' ?> >Operador</option>
								<option <?php echo ($Funcionario['Cargo'] == 'Planejista') ? 'Selected' : '' ?> >Planejista</option>
								<option <?php echo ($Funcionario['Cargo'] == 'Supervisor') ? 'Selected' : '' ?> >Supervisor</option>
								<option <?php echo ($Funcionario['Cargo'] == 'Instrutor') ? 'Selected' : '' ?> >Instrutor</option>
							</select>
						</div>
						
						<div class="form-group col-sm">
							<label>Remuneração</label>
							<input class="form-control" type="number" min="0.00" step="0.01" id="Remuneracao" name="Remuneracao" Placeholder="Remuneração" value="<?php echo (!empty($Funcionario['Remuneracao'])) ? number_format($Funcionario['Remuneracao'], 2, '.', '') : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Regime de Experiência</label>
							<select class="form-control" id="RegimeExperiencia" name="RegimeExperiencia">
								<option selected disabled>Selecione</option>
								<option <?php echo ($Funcionario['RegimeExperiencia'] == '30+60') ? 'Selected' : '' ?>>30+60</option>
								<option <?php echo ($Funcionario['RegimeExperiencia'] == '45+45') ? 'Selected' : '' ?>>45+45</option>
								<option <?php echo ($Funcionario['RegimeExperiencia'] == '60+30') ? 'Selected' : '' ?>>60+30</option>
								<option <?php echo ($Funcionario['RegimeExperiencia'] == 'Não Aplica') ? 'Selected' : '' ?>>Não Aplica</option>
							</select>
						</div>
						
						<div class="form-group col-sm">
							<label>Contrato de Trabalho</label>
							<select class="form-control" id="Contrato" name="Contrato">
								<option selected disabled>Selecione</option>
								<option <?php echo ($Funcionario['Contrato'] == 'CTPS') ? 'Selected' : '' ?>>CTPS</option>
								<option <?php echo ($Funcionario['Contrato'] == 'Estagio') ? 'Selected' : '' ?>>Estagio</option>
								<option <?php echo ($Funcionario['Contrato'] == 'Tercerizado') ? 'Selected' : '' ?>>Tercerizado</option>
							</select>
						</div>

						
						<div class="form-group col-sm">
							<label>
								vale Transporte:
							</label>
							<div class='check'>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type='radio' name='ValeTransporte' value='1' <?php echo ($Funcionario['ValeTransporte'] == '1') ? 'checked' : '' ?> > Sim</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type='radio' name='ValeTransporte' value='0' <?php echo ($Funcionario['ValeTransporte'] == '0') ? 'checked' : '' ?> > Não</label>
							</div>					
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Carga Horária</label>
							<input class="form-control" type="time" id="Horario" name="Horario" Placeholder="Horario" value="<?php echo (!empty($Funcionario['Horario'])) ? date("H:i:s", strtotime($Funcionario['Horario'])) : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Horário de entrada</label>
							<input class="form-control" type="time" id="HorarioEntrada" name="HorarioEntrada" Placeholder="HorarioEntrada" value="<?php echo (!empty($Funcionario['HorarioEntrada'])) ? date("H:i:s", strtotime($Funcionario['HorarioEntrada'])) : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Horário de Saida</label>
							<input class="form-control" type="time" id="HorarioSaida" name="HorarioSaida" Placeholder="HorarioSaida" value="<?php echo (!empty($Funcionario['HorarioSaida'])) ? date("H:i:s", strtotime($Funcionario['HorarioSaida'])) : '';?>">
						</div>
					
						<div class="form-group col-sm">
							<label>1ª Pausa - 10 Min</label>
							<input class="form-control" type="time" id="Pausa1" name="Pausa1" Placeholder="Pausa1" value="<?php echo (!empty($Funcionario['Pausa1'])) ? date("H:i:s", strtotime($Funcionario['Pausa1'])) : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>2ª Pausa - 20 Min</label>
							<input class="form-control" type="time" id="Pausa2" name="Pausa2" Placeholder="Pausa2" value="<?php echo (!empty($Funcionario['Pausa2'])) ? date("H:i:s", strtotime($Funcionario['Pausa2'])) : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>3ª Pausa - 10 Min</label>
							<input class="form-control" type="time" id="Pausa3" name="Pausa3" Placeholder="Pausa3" value="<?php echo (!empty($Funcionario['Pausa3'])) ? date("H:i:s", strtotime($Funcionario['Pausa3'])) : '';?>">
						</div>
					</div>
					
					<div class='form-row'>		
						<div class="form-group col-sm">
							<label>
								Trabalha aos sábados:
							</label>
							<div class='check'>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type='radio' name='Sabado' value='1' <?php echo ($Funcionario['ValeTransporte'] == '1') ? 'checked' : '' ?> > Sim</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type='radio' name='Sabado' value='0' <?php echo ($Funcionario['ValeTransporte'] == '0') ? 'checked' : '' ?> > Não</label>
							</div>					
						</div>
							
						<div class="form-group col-sm">
							<label>Horário de entrada sáb</label>
							<input class="form-control" type="time" id="HorarioEntradaSabado" name="HorarioEntradaSabado" Placeholder="HorarioEntradaSabado" value="<?php echo (!empty($Funcionario['HorarioEntradaSabado'])) ? date("H:i:s", strtotime($Funcionario['HorarioEntradaSabado'])) : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Horário de Saida sáb</label>
							<input class="form-control" type="time" id="HorarioSaidaSabado" name="HorarioSaidaSabado" Placeholder="HorarioSaidaSabado" value="<?php echo (!empty($Funcionario['HorarioSaidaSabado'])) ? date("H:i:s", strtotime($Funcionario['HorarioSaidaSabado'])) : '';?>">
						</div>
					
						<div class="form-group col-sm">
							<label>1ª Pausa - 10 Min sáb</label>
							<input class="form-control" type="time" id="Pausa1S" name="Pausa1S" Placeholder="Pausa1S" value="<?php echo (!empty($Funcionario['Pausa1S'])) ? date("H:i:s", strtotime($Funcionario['Pausa1S'])) : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>2ª Pausa - 20 Min sáb</label>
							<input class="form-control" type="time" id="Pausa2S" name="Pausa2S" Placeholder="Pausa2S" value="<?php echo (!empty($Funcionario['Pausa2S'])) ? date("H:i:s", strtotime($Funcionario['Pausa2S'])) : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>3ª Pausa - 10 Min sáb</label>
							<input class="form-control" type="time" id="Pausa3S" name="Pausa3S" Placeholder="Pausa3S" value="<?php echo (!empty($Funcionario['Pausa3S'])) ? date("H:i:s", strtotime($Funcionario['Pausa3S'])) : '';?>">
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Supervisor</label>
							<input class="form-control" type="text" id="Supervisor" name="Supervisor" Placeholder="Supervisor" value="<?php echo (!empty($Funcionario['Supervisor'])) ? $Funcionario['Supervisor'] : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Produto</label>
							<input class="form-control" type="text" id="Produto" name="Produto" Placeholder="Produto" value="<?php echo (!empty($Funcionario['Produto'])) ? $Funcionario['Produto'] : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Sub Produto</label>
							<input class="form-control" type="text" id="SubProduto" name="SubProduto" Placeholder="SubProduto" value="<?php echo (!empty($Funcionario['SubProduto'])) ? $Funcionario['SubProduto'] : '';?>">
						</div>
					</div>
				</fieldset>
				
				<fieldset class='border p-2 rounded mb-3'>
					<label><h5> Endereço</h5></label>
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Rua</label>
							<input class="form-control  " type='text' id="Rua" name='Rua' Placeholder="Rua" value="<?php echo (!empty($Funcionario['Rua'])) ? $Funcionario['Rua'] : '';?>">
						</div>
						
						<div class="form-group col-sm-2">
							<label>Número</label>
							<input class="form-control" type="text" id="Numero" name="Numero" Placeholder="Número" value="<?php echo (!empty($Funcionario['Numero'])) ? $Funcionario['Numero'] : '';?>">
						</div>
						
						<div class="form-group col-sm-3">
							<label>Complemento</label>
							<input class="form-control" type="text" id="Complemento" name="Complemento" Placeholder="Complemento" value="<?php echo (!empty($Funcionario['Complemento'])) ? $Funcionario['Complemento'] : '';?>">
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Bairro</label>
							<input class="form-control" type="text" id="Bairro" name="Bairro" Placeholder="Bairro" value="<?php echo (!empty($Funcionario['Bairro'])) ? $Funcionario['Bairro'] : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Cidade</label>
							<input class="form-control" type="text" id="Cidade" name="Cidade" Placeholder="Cidade" value="<?php echo (!empty($Funcionario['Cidade'])) ? $Funcionario['Cidade'] : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>CEP</label>
							<input class="form-control" type="text" id="Cep" name="Cep" Placeholder="Cep" value="<?php echo (!empty($Funcionario['Cep'])) ? $Funcionario['Cep'] : '';?>">
						</div>
					</div>
				</fieldset>	
				
				<fieldset class='border p-2 rounded mb-3'>	
					<label><h5>Dados de Trabalho</h5></label>
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Login</label>
							<input class="form-control" type="text" id="Login" name="Login" Placeholder="Login" value="<?php echo (!empty($Funcionario['Login'])) ? $Funcionario['Login'] : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Id Sistema</label>
							<input class="form-control" type="text" id="IdSistema" name="IdSistema" Placeholder="Id Sistema" value="<?php echo (!empty($Funcionario['IdSistema'])) ? $Funcionario['IdSistema'] : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Setor</label>
							<input class="form-control" type="text" id="Setor" name="Setor" Placeholder="Setor" value="<?php echo (!empty($Funcionario['Setor'])) ? $Funcionario['Setor'] : '';?>">
						</div>
					</div>
						
					<div class='form-row'>	
						<div class="form-group col-sm">
							<label>Obs</label>
							<textarea class="form-control" type="text" id="Obs" name="Obs" Placeholder="Obs"><?php echo (!empty($Funcionario['Obs'])) ? $Funcionario['Obs'] : '';?></textarea>
						</div>
					</div>
				</fieldset>

				<div class="form-group row">
					<div class='col-sm-6'>
						<button class='btn btn-success form-control' title = 'Salvar' name='Salvar'>Salvar</button>
					</div>
					
					<div class='col-sm-6'>
						<a class='btn btn-danger form-control' href='<?php echo "?p=".base64_encode("Cadastro/Funcionarios") ?>' title = 'Cancelar' name='Cancelar'>Cancelar</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>