<div class='row justify-content-center'>
	<div class="card col-sm">
		<div class='card-body'>
			<?php 
				//include_once "ControleOperadores.Class.php";
				
				$Read = new Read;
				
				$Read->ExeRead('Carteira');
				$Carteira = ($Read->GetRowCount()>0) ? $Read->GetResult() : null;
				
				if(isset($_POST['Cancelar'])){
					header("location: ?p=Usuarios/Listar_Funcionarios");
				}

				if(isset($_POST['Salvar'])){
					unset($_POST['Salvar']);
					
					If($_POST['NomeCompleto']==''){
						echo "<div class='alert alert-warning alert-dismissible text-center' role='alert'>
								<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
									<span aria-hidden='true'>&times;</span>
								</button>
								Gentilega Preencher o campo <b>Nome Completo</b> antes de proceguir.
							</div>";
					}else{
						
						$Check = new Check;
						
						$_POST['NomeCompleto'] = $Check->Name($_POST['NomeCompleto']);
						$_POST['DataAdm'] = $_POST['DataAdm'];
						
						$Create = new Create;
						
						unset($_POST['Salvar']);
						
						$Create->ExeCreate('Funcionarios', $_POST);
						
						if($Create->GetResult()){
							echo "<div class='alert alert-success alert-dismissible text-center' role='alert'>
								<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
									<span aria-hidden='true'>&times;</span>
								</button>
								Salvo com sucesso
							</div>";
						}
					}
				}
			?>

			<form class="form" name="Usuarios" method="POST">
				<label><h3 >Criar Funcionario</h3></label>
				
				<fieldset class='border p-2 rounded mb-3'>
					<label><h5 >Dados Pessoais</h5></label>
					<div class='form-row'>
						<div class="form-group col-sm-2">
							<label>Mat</label>
							<input class="form-control  " type='text' id="matricula" name='matricula' Placeholder="Mat" >
						</div>
						
						<div class="form-group col-sm">
							<label>Nome Completo</label>
							<input class="form-control" type="text" id="NomeCompleto" name="NomeCompleto" Placeholder="Nome Completo">
						</div>
						
						<div class="form-group col-sm">
							<label>Nome da Mãe</label>
							<input class="form-control" type="text" id="Mae" name="Mae" Placeholder="Nome da Mãe">
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>CPF</label>
							<input class="form-control" type="text" id="Cpf" name="Cpf" Placeholder="Cpf">
						</div>
						
						<div class="form-group col-sm">
							<label>RG</label>
							<input class="form-control" type="text" id="Rg" name="Rg" Placeholder="RG">
						</div>
						
						<div class="form-group col-sm">
							<label>Nº PIS</label>
							<input class="form-control" type="text" id="Pis" name="Pis" Placeholder="Pis">
						</div>
						
						<div class="form-group col-sm">
							<label>Estado Civil</label>
							<select class="form-control" id="EstadoCivil" name="EstadoCivil">
								<option selected disabled>Selecione</option>
								<option>Solteiro(a)</option>
								<option>Casado(a)</option>
								<option>Divorciado(a)</option>
								<option>Viúvo(a)</option>
								<option>Separado(a)</option>
							</select>
						</div>
						
						<div class="form-group col-sm">
							<label>Escolaridade</label>
							<select class="form-control" id="EstadoCivil" name="EstadoCivil">
								<option selected disabled>Selecione</option>
								<option>Analfabeto</option>
								<option>Fundamental</option>
								<option>Médio</option>
								<option>Superior Em Curso</option>
								<option>Superior Completo</option>
							</select>
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Telefone</label>
							<input class="form-control" type="text" id="Fone" name="Fone" Placeholder="Telefone" >
						</div>
					
						<div class="form-group col-sm">
							<label>E-mail</label>
							<input class="form-control" type="text" id="Email" name="Email" Placeholder="E-Mail">
						</div>
						
						<div class="form-group col-sm">
							<label>Data Nascimento</label>
							<input class="form-control" type="date" id="DataNasc" name="DataNasc" Placeholder="DataNasc">
						</div>
						
						<div class="form-group col-sm">
							<label>
								Sexo
							</label>
							<div class='check'>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type='radio' name='Sexo' value='M' > Masculino</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type='radio' name='Sexo' value='F' > Feminino</label>
							</div>					
						</div>
					</div>
					
				</fieldset>
				
				<fieldset class='border p-2 rounded mb-3'>
					<label><h5 >Dados Profissionais</h5></label>
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Data Admissão</label>
							<input class="form-control" type="date" id="DataAdm" name="DataAdm" Placeholder="DataAdm">
						</div>
						
						<div class="form-group col-sm">
							<label>Cargo</label>
							<select class="form-control" id="Cargo" name="Cargo">
								<option selected disabled>Selecione</option>
								<option>Analista</option>
								<option>Assistente</option>
								<option>Auxiliar Aministrativo</option>
								<option>Back Office</option>
								<option>Coordenador</option>
								<option>Diretor</option>
								<option>Gerente</option>
								<option>Monitor</option>
								<option>Operador</option>
								<option>Planejista</option>
								<option>Supervisor</option>
								<option>Instrutor</option>
							</select>
						</div>
						
						<div class="form-group col-sm">
							<label>Status</label>
							<select class="form-control" id="Status" name="Status">
								<option selected disabled>Selecione</option>
								<option Value='Ativo'>Ativo</option>
							</select>
						</div>
						
						<div class="form-group col-sm">
							<label>Remuneração</label>
							<input class="form-control" type="text" id="Remuneracao" name="Remuneracao" Placeholder="Remuneração">
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Regime de Experiência</label>
							<select class="form-control" id="RegimeExperiencia" name="RegimeExperiencia">
								<option selected disabled>Selecione</option>
								<option>30 + 60</option>
								<option>45 + 45</option>
								<option>60 + 30</option>
								<option>Não Aplica</option>
							</select>
						</div>
						
						<div class="form-group col-sm">
							<label>
								vale Transporte:
							</label>
							<div class='check'>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type='radio' name='valeTransporte' value='1' > Sim</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type='radio' name='valeTransporte' value='0' > Não</label>
							</div>					
						</div>
						
						<div class="form-group col-sm">
							<label>Remuneração</label>
							<input class="form-control" type="text" id="Remuneracao" name="Remuneracao" Placeholder="Remuneração">
						</div>
						
						<div class="form-group col-sm">
							<label>Contrato de Trabalho</label>
							<select class="form-control" id="Contrato" name="Contrato">
								<option selected disabled>Selecione</option>
								<option>CTPS</option>
								<option>Estagio</option>
								<option>Tercerizado</option>
							</select>
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Carga Horária</label>
							<input class="form-control" type="time" id="Horario" name="Horario" Placeholder="Horario" value="<?php echo (!empty($Funcionario['Horario'])) ? $Funcionario['Horario'] : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Horário de entrada</label>
							<input class="form-control" type="time" id="HorarioEntrada" name="HorarioEntrada" Placeholder="HorarioEntrada">
						</div>
						
						<div class="form-group col-sm">
							<label>Horário de Saida</label>
							<input class="form-control" type="time" id="HorarioSaida" name="HorarioSaida" Placeholder="HorarioSaida">
						</div>
					
						<div class="form-group col-sm">
							<label>1ª Pausa - 10 Min</label>
							<input class="form-control" type="time" id="Pausa1" name="Pausa1" Placeholder="Pausa1">
						</div>
						
						<div class="form-group col-sm">
							<label>2ª Pausa - 20 Min</label>
							<input class="form-control" type="time" id="Pausa2" name="Pausa2" Placeholder="Pausa2">
						</div>
						
						<div class="form-group col-sm">
							<label>3ª Pausa - 10 Min</label>
							<input class="form-control" type="time" id="Pausa3" name="Pausa3" Placeholder="Pausa3">
						</div>
					</div>
					
					<div class='form-row'>		
						<div class="form-group col-sm">
							<label>
								Trabalha aos sábados:
							</label>
							<div class='check'>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type='radio' name='Sabado' value='1' > Sim</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type='radio' name='Sabado' value='0' > Não</label>
							</div>					
						</div>
							
						<div class="form-group col-sm">
							<label>Horário de entrada sáb</label>
							<input class="form-control" type="time" id="HorarioEntradaSabado" name="HorarioEntradaSabado" Placeholder="HorarioEntradaSabado">
						</div>
						
						<div class="form-group col-sm">
							<label>Horário de Saida sáb</label>
							<input class="form-control" type="time" id="HorarioSaidaSabado" name="HorarioSaidaSabado" Placeholder="HorarioSaidaSabado">
						</div>
					
						<div class="form-group col-sm">
							<label>1ª Pausa - 10 Min sáb</label>
							<input class="form-control" type="time" id="Pausa1S" name="Pausa1S" Placeholder="Pausa1S">
						</div>
						
						<div class="form-group col-sm">
							<label>2ª Pausa - 20 Min sáb</label>
							<input class="form-control" type="time" id="Pausa2S" name="Pausa2S" Placeholder="Pausa2S">
						</div>
						
						<div class="form-group col-sm">
							<label>3ª Pausa - 10 Min sáb</label>
							<input class="form-control" type="time" id="Pausa3S" name="Pausa3S" Placeholder="Pausa3S">
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Supervisor</label>
							<input class="form-control" type="text" id="Supervisor" name="Supervisor" Placeholder="Supervisor">
						</div>
						
						<div class="form-group col-sm">
							<label>Produto</label>
							<input class="form-control" type="text" id="Produto" name="Produto" Placeholder="Produto">
						</div>
						
						<div class="form-group col-sm">
							<label>Sub Produto</label>
							<input class="form-control" type="text" id="SubProduto" name="SubProduto" Placeholder="SubProduto">
						</div>
					</div>
				</fieldset>
				
				<fieldset class='border p-2 rounded mb-3'>
					<label><h5> Endereço</h5></label>
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Rua</label>
							<input class="form-control  " type='text' id="Rua" name='Rua' Placeholder="Rua">
						</div>
						
						<div class="form-group col-sm-2">
							<label>Número</label>
							<input class="form-control" type="text" id="Numero" name="Numero" Placeholder="Número">
						</div>
						
						<div class="form-group col-sm-3">
							<label>Complemento</label>
							<input class="form-control" type="text" id="Complemento" name="Complemento" Placeholder="Complemento">
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Bairro</label>
							<input class="form-control" type="text" id="Bairro" name="Bairro" Placeholder="Bairro">
						</div>
						
						<div class="form-group col-sm">
							<label>Cidade</label>
							<input class="form-control" type="text" id="Cidade" name="Cidade" Placeholder="Cidade">
						</div>
						
						<div class="form-group col-sm">
							<label>CEP</label>
							<input class="form-control" type="text" id="Cep" name="Cep" Placeholder="Cep">
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
							<label>Setor</label>
							<input class="form-control" type="text" id="Cidade" name="Cidade" Placeholder="Cidade" value="<?php echo (!empty($Funcionario['Setor'])) ? $Funcionario['Setor'] : '';?>">
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
						<button class='btn btn-danger form-control' title = 'Cancelar' name='Cancelar'>Cancelar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>



