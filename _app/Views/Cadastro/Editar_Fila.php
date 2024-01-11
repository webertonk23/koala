<div class='justify-content-center'>
	<div class="card col-sm">
		<div class='card-body'>
			<?php
				if(isset($_POST['Salvar'])){
					unset($_POST['Salvar']);
					
					$_POST['Cart_fila'] = (!empty($_POST['Carteira'])) ? implode(",", $_POST['Carteira']) : null;
					$_POST['Cidades_fila'] = (!empty($_POST['Cidade'])) ? implode(",", $_POST['Cidade']) : null;
					$_POST['Mailing_fila'] = (!empty($_POST['Mailing'])) ? implode(",", $_POST['Mailing']) : null;
					$_POST['Sexo_fila'] =  (!empty($_POST['Sexo'])) ? implode(",", $_POST['Sexo']) : null;
					$_POST['Estado_fila'] =  (!empty($_POST['Estado'])) ? implode(",", $_POST['Estado']) : null;
					$_POST['Ordem_fila'] = trim(implode(", ", array_filter($_POST['Ordem'])));
					$_POST['Dia_fila'] = (!empty($_POST['dia'])) ? trim(implode(",", array_filter($_POST['dia']))) : null;
					$_POST['especie_fila'] = (!empty($_POST['especie'])) ? trim(implode(",", array_filter(array_unique($_POST['especie'])))) : null;
					$_POST['entidade_fila'] = (!empty($_POST['entidade'])) ? trim(implode(",", array_filter(array_unique($_POST['entidade'])))) : null;
					$_POST['convenio_fila'] = (!empty($_POST['convenio'])) ? trim(implode(",", array_filter(array_unique($_POST['convenio'])))) : null;

					unset($_POST['Carteira']);
					unset($_POST['Cidade']);
					unset($_POST['Sexo']);
					unset($_POST['Mailing']);
					unset($_POST['Estado']);
					unset($_POST['Ordem']);
					unset($_POST['dia']);
					unset($_POST['especie']);
					unset($_POST['entidade']);
					unset($_POST['convenio']);
					
					//var_dump($_POST);
					
					$Editar = new Update;
					
					$Editar->ExeUpdate('Fila', $_POST, "WHERE Id_fila = :Id", "Id={$_GET['Id']}");	
					
					//var_dump($Editar);
					
					echo ($Editar->GetResult()) ? "Alteração salva com sucesso!" : "Algo de errado não esta certo.<br>{$Editar->GetErro()}";
				}

				if(isset($_GET['Id'])){
					$Busca = new Read;
					
					$Busca->ExeRead("Fila INNER JOIN carteira ON Perfil_fila = Perfil_cart", "WHERE Id_fila = :Id", "Id={$_GET['Id']}");
					
					$Fila = ($Busca->GetRowCount() > 0) ? $Busca->GetResult() : null;
					
					//var_dump($Fila);
					
					$Ordem = (!empty($Fila[0]["Ordem_fila"])) ? explode(",", $Fila[0]["Ordem_fila"]) : null;
					
					$Busca->FullRead("
						SELECT
							DISTINCT Cidade_pes
						FROM
							Pessoas INNER JOIN Fichas ON Id_pes = IdPes_ficha
							INNER JOIN carteira ON IdCart_ficha = Id_Cart WHERE Perfil_cart = :Perfil", "Perfil={$Fila[0]['Perfil_fila']}");

					$Cidades = ($Busca->GetRowCount() > 0) ? $Busca->GetResult() : null;
					
					$Busca->FullRead("
						SELECT
							DISTINCT ArqInc_Ficha
						FROM
							Fichas INNER JOIN carteira ON IdCart_ficha = Id_Cart WHERE Perfil_cart = :Perfil AND ArqInc_Ficha != '' ORDER BY ArqInc_Ficha DESC",
							"Perfil={$Fila[0]['Perfil_fila']}");
					
					$Mailing = ($Busca->GetRowCount() > 0) ? $Busca->GetResult() : null;
					
					$Busca->FullRead("
						SELECT
							DISTINCT especie_ficha
						FROM 
							fichas INNER JOIN carteira ON IdCart_ficha = Id_Cart
						WHERE
							Perfil_cart = :Perfil
						", "Perfil={$Fila[0]['Perfil_fila']}");
					
					$especie = ($Busca->GetRowCount() > 0) ? $Busca->GetResult() : null;
					
					$Busca->FullRead("
						SELECT
							DISTINCT DesEnt_ficha
						FROM 
							fichas INNER JOIN carteira ON IdCart_ficha = Id_Cart
						WHERE
							Perfil_cart = :Perfil
						", "Perfil={$Fila[0]['Perfil_fila']}");
					
					$entidade = ($Busca->GetRowCount() > 0) ? $Busca->GetResult() : null;
					
					$Busca->FullRead("
						SELECT
							DISTINCT convenio_ficha
						FROM 
							fichas INNER JOIN carteira ON IdCart_ficha = Id_Cart
						WHERE
							Perfil_cart = :Perfil
						", "Perfil={$Fila[0]['Perfil_fila']}");
					
					$convenio = ($Busca->GetRowCount() > 0) ? $Busca->GetResult() : null;
				}
			?>
			
			<form class="form" method="POST">
				<label><h3>Editar Fila</h3></label>
				
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
								<option <?php echo ($Fila[0]['Perfil_fila'] == 'Vendas') ? 'Selected' : '' ?> value='Vendas'>Vendas</option>
								<option <?php echo ($Fila[0]['Perfil_fila'] == 'Receptivo') ? 'Selected' : '' ?> value='Recptivo'>Receptivo</option>
								<option <?php echo ($Fila[0]['Perfil_fila'] == 'Prospeccao') ? 'Selected' : '' ?> value='Prospeccao'>Prospecção</option>
								<option <?php echo ($Fila[0]['Perfil_fila'] == 'Pesquisa') ? 'Selected' : '' ?> value='Pesquisa'>Pesquisa</option>
							</select>
						</div>
						
						<div class="form-group col-sm">
							<label>Ura?</label>
							<select class="form-control" id="Ura_fila" name="Ura_fila">
								<option <?php echo ($Fila[0]['Ura_fila'] == '0') ? 'Selected' : '' ?> value='0'>Não</option>
								<option <?php echo ($Fila[0]['Ura_fila'] == '1') ? 'Selected' : '' ?> value='1'>Sim</option>
							</select>
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Sequência</label>
							<input class="form-control" type="number" id="Seq_fila" name="Seq_fila" Placeholder="Sequência" value="<?php echo (!empty($Fila[0]['Seq_fila'])) ? $Fila[0]['Seq_fila'] : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Discador</label>
							<select class="form-control" id="Discador_fila" name="Discador_fila">
								<option Value='' <?php echo ($Fila[0]['Discador_fila'] == '') ? 'Selected' : '' ?>>Sem Discador</option>
								<option value='Vonix' <?php echo ($Fila[0]['Discador_fila'] == 'Vonix') ? 'Selected' : '' ?>>Vonix</option>
							</select>
						</div>
						
						<div class="form-group col-sm">
							<label>Ignorar DDDs</label>
							<input class="form-control" type="text" id="IgnoraDDD_fila" name="IgnoraDDD_fila" Placeholder="ignorar DDDs, " value="<?php echo (!empty($Fila[0]['IgnoraDDD_fila'])) ? $Fila[0]['IgnoraDDD_fila'] : '';?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Estoque Fichas</label>
							<input class="form-control" type="number" id="QtdFicha_fila" name="QtdFicha_fila" Placeholder="Estoque Fichas" min='100' max='10000' step='1' value="<?php echo (!empty($Fila[0]['QtdFicha_fila'])) ? $Fila[0]['QtdFicha_fila'] : '';?>">
						</div>
						
						<div class='form-group col-sm'>
							<label>Dias do estoque</label>
							<input class='form-control' type='number' id='diasEstoque_fila' name='diasEstoque_fila' placeholder='Dias do estoque' min='1' max='30' value="<?pho echo (!empty($Fila[0]['diasEstoque_fila'])) ? $Fila[0]['diasEstoque_fila'] : ''; ?>">
						</div>
					</div>
				</fieldset>
				
				<fieldset class='border p-2 rounded mb-3'>
					<label><h5 >Expediente</h5></label>
					<div class='form-row'>
						<div class='form-group col-sm'>
							<div class='form-check'>
								<label class='form-check-label'><input class='form-check-input' <?php echo (in_array('1', explode(",", $Fila[0]['Dia_fila']))) ? 'checked' : '' ?> type='checkbox' value="1" name='dia[]'>Domingo</label>
							</div>
						</div>
						
						<div class='form-group col-sm'>
							<div class='form-check'>
								<label class='form-check-label'><input class='form-check-input' <?php echo (in_array('2', explode(",", $Fila[0]['Dia_fila']))) ? 'checked' : '' ?> type='checkbox' value="2" name='dia[]'>Segunda</label>
							</div>
						</div>
						
						<div class='form-group col-sm'>
							<div class='form-check'>
								<label class='form-check-label'><input class='form-check-input' <?php echo (in_array('3', explode(",", $Fila[0]['Dia_fila']))) ? 'checked' : '' ?> type='checkbox' value="3" name='dia[]'>Terça</label>
							</div>
						</div>
						
						<div class='form-group col-sm'>
							<div class='form-check'>
								<label class='form-check-label'><input class='form-check-input' <?php echo (in_array('4', explode(",", $Fila[0]['Dia_fila']))) ? 'checked' : '' ?> type='checkbox' value="4" name='dia[]'>Quarta</label>
							</div>
						</div>
						
						<div class='form-group col-sm'>
							<div class='form-check'>
								<label class='form-check-label'><input class='form-check-input' <?php echo (in_array('5', explode(",", $Fila[0]['Dia_fila']))) ? 'checked' : '' ?> type='checkbox' value="5" name='dia[]'>Quinta</label>
							</div>
						</div>
						
						<div class='form-group col-sm'>
							<div class='form-check'>
								<label class='form-check-label'><input class='form-check-input' <?php echo (in_array('6', explode(",", $Fila[0]['Dia_fila']))) ? 'checked' : '' ?> type='checkbox' value="6" name='dia[]'>Sexta</label>
							</div>
						</div>
						
						<div class='form-group col-sm'>
							<div class='form-check'>
								<label class='form-check-label'><input class='form-check-input' <?php echo (in_array('7', explode(",", $Fila[0]['Dia_fila']))) ? 'checked' : '' ?> type='checkbox' value="7" name='dia[]'>Sabado</label>
							</div>
						</div>
					</div>
				</fieldset>
				
				<fieldset class='border p-2 rounded mb-3'>
					<label><h5 >Carteiras</h5></label>
					<div class='form-row'>
					<?php 
						foreach($Fila as $Values){
							$sel = (in_array("'".$Values['Id_Cart']."'", explode(",", $Fila[0]['Cart_fila']))) ? 'checked' : '';
							echo "<div class='form-group col-sm-3'>
									<div class='form-check'>
										<label class='form-check-label'>
											<input class='form-check-input' type='checkbox' $sel value=\"'{$Values['Id_Cart']}'\" name='Carteira[]'>
											{$Values['Desc_Cart']}
										</label>
									</div>
								</div>";
						}
					?>
					</div>
				</fieldset>
				
				<fieldset class='border p-2 rounded mb-3'>
					<label><h5>Filtros</h5></label>
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Idade de</label>
							<input class="form-control" type='text' name='IdadeDe_fila' Placeholder="Idade De"  value="<?php echo (isset($Fila[0]['IdadeDe_fila'])) ? $Fila[0]['IdadeDe_fila'] : ''?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Idade Até</label>
							<input class="form-control" type="text" name="IdadeAte_fila" Placeholder="Idade Ate" value="<?php echo (!empty($Fila[0]['IdadeAte_fila'])) ? $Fila[0]['IdadeAte_fila'] : ''?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Margem de</label>
							<input class="form-control" type='number' name='MargemDe_fila' step='0.1' Placeholder="Margem De"  value="<?php echo (isset($Fila[0]['MargemDe_fila'])) ? number_format($Fila[0]['MargemDe_fila'], 2, ".", "") : ''?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Margem Até</label>
							<input class="form-control" type="number" name="MargemAte_fila" step='0.1' Placeholder="Margem Ate" value="<?php echo (!empty($Fila[0]['MargemAte_fila'])) ? number_format($Fila[0]['MargemAte_fila'], 2, ".", "") : ''?>">
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Limite de</label>
							<input class="form-control" type='number' name='LimiteDe_fila' step='0.1' Placeholder="Limite De"  value="<?php echo (isset($Fila[0]['LimiteDe_fila'])) ? number_format($Fila[0]['LimiteDe_fila'], 2, ".", "") : ''?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Limite Até</label>
							<input class="form-control" type="number" name="LimiteAte_fila" step='0.1' Placeholder="Limite Ate" value="<?php echo (!empty($Fila[0]['LimiteAte_fila'])) ? number_format($Fila[0]['LimiteAte_fila'], 2, ".", "") : ''?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Salário De</label>
							<input class="form-control" type='number' name='SalarioDe_fila' step='0.1' Placeholder="Salario De"  value="<?php echo (isset($Fila[0]['SalarioDe_fila'])) ? number_format($Fila[0]['SalarioDe_fila'], 2, ".", "") : ''?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Salario Até</label>
							<input class="form-control" type="number" name="SalarioAte_fila" step='0.1' Placeholder="Salario Ate" value="<?php echo (!empty($Fila[0]['SalarioAte_fila'])) ? number_format($Fila[0]['SalarioAte_fila'], 2, ".", "") : ''?>">
						</div>
					</div>
					
					<div class='form-row'>
						<div class="form-group col-sm">
							<label>Qtd Contratos De</label>
							<input class="form-control" type='number' name='QtdConDe_fila' step='1' Placeholder="Qtd Contratos De"  value="<?php echo (isset($Fila[0]['QtdConDe_fila'])) ? $Fila[0]['QtdConDe_fila'] : ''?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Qtd Contratos Ate</label>
							<input class="form-control" type="number" name="QtdConAte_fila" step='1' Placeholder="Qtd Contratos Ate" value="<?php echo (!empty($Fila[0]['QtdConAte_fila'])) ? $Fila[0]['QtdConAte_fila'] : ''?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Score De</label>
							<input class="form-control" type='number' name='ScoreDe_fila' step='1' Placeholder="Score De"  value="<?php echo (isset($Fila[0]['ScoreDe_fila'])) ? $Fila[0]['ScoreDe_fila'] : ''?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Score Até</label>
							<input class="form-control" type="number" name="ScoreAte_fila" step='1' Placeholder="Score Ate" value="<?php echo (!empty($Fila[0]['ScoreAte_fila'])) ? $Fila[0]['ScoreAte_fila'] : ''?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Dt Atualização De</label>
							<input class="form-control" type='date' name='DtAtuDe_fila' value="<?php echo (isset($Fila[0]['DtAtuDe_fila'])) ? $Fila[0]['DtAtuDe_fila'] : ''?>">
						</div>
						
						<div class="form-group col-sm">
							<label>Dt Atualização Até</label>
							<input class="form-control" type="date" name="DtAtuAte_fila" value="<?php echo (!empty($Fila[0]['DtAtuAte_fila'])) ? $Fila[0]['DtAtuAte_fila'] : ''?>">
						</div>
					</div>
					
					<div class='form-row cols-3'>
						<div class="form-group col-sm-2">
							<label>Sexo</label>
							<select multiple class="form-control" id="Sexo" name="Sexo[]">
								<option <?php echo (in_array("'M'", explode(",", $Fila[0]['Sexo_fila']))) ? 'selected' : '' ?> value="'M'">Masculino</option>
								<option <?php echo (in_array("'F'", explode(",", $Fila[0]['Sexo_fila']))) ? 'selected' : '' ?> value="'F'">Feminino</option>
								<option <?php echo (in_array("'I'", explode(",", $Fila[0]['Sexo_fila']))) ? 'selected' : '' ?> value="'I'">Indefinido</option>
							</select>
						</div>
						
						<div class="form-group col-sm">
							<label>Cidades</label>
							<select multiple rows='6' class="form-control" id="Cidade" name="Cidade[]" <?php echo (empty($Fila[0]['Cidades_fila'])) ? 'disabled' : '';?> >
								<?php
									foreach($Cidades as $Values){
										$sel = (in_array("'".$Values['Cidade_pes']."'", explode(",", $Fila[0]['Cidades_fila']))) ? 'selected' : '';
										echo "<option $sel value=\"'{$Values['Cidade_pes']}'\">{$Values['Cidade_pes']}</option>";
									}
								?>
							</select>
							<div class='form-check'>
								<label class='form-check-label'>
									<?php $sel = (empty($Fila[0]['Cidades_fila'])) ? 'checked' : '';?>
									<input class='form-check-input' type='checkbox' value="0" name='Cidade[]' id="CidadeC" onclick="habilitar()" <?php echo $sel;?>>
									Todas
								</label>
							</div>
						</div>
						
						<div class="form-group col-sm">
							<label>Estado</label>
							<select multiple rows='6' class="form-control" id="Estado" name="Estado[]">
								<option <?php echo (in_array("'Ac'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Ac'">Acre</option>
								<option <?php echo (in_array("'Al'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Al'">Alagoas</option>
								<option <?php echo (in_array("'Ap'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Ap'">Amapá</option>
								<option <?php echo (in_array("'Am'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Am'">Amazonas</option>
								<option <?php echo (in_array("'Ba'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Ba'">Bahia</option>
								<option <?php echo (in_array("'Ce'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Ce'">Ceará</option>
								<option <?php echo (in_array("'Df'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Df'">Distrito Federal</option>
								<option <?php echo (in_array("'Es'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Es'">Espírito Santo</option>
								<option <?php echo (in_array("'Go'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Go'">Goiás</option>
								<option <?php echo (in_array("'Ma'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Ma'">Maranhão</option>
								<option <?php echo (in_array("'Mt'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Mt'">Mato Grosso</option>
								<option <?php echo (in_array("'Ms'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Ms'">Mato Grosso do Sul</option>
								<option <?php echo (in_array("'Mg'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Mg'">Minas Gerais</option>
								<option <?php echo (in_array("'Pa'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Pa'">Pará</option>
								<option <?php echo (in_array("'Pb'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Pb'">Paraíba</option>
								<option <?php echo (in_array("'Pr'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Pr'">Paraná</option>
								<option <?php echo (in_array("'Pe'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Pe'">Pernabuco</option>
								<option <?php echo (in_array("'Pi'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Pi'">Piauí</option>
								<option <?php echo (in_array("'Rj'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Rj'">Rio de Janeiro</option>
								<option <?php echo (in_array("'Rn'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Rn'">Rio Grande do Norte</option>
								<option <?php echo (in_array("'Rs'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Rs'">Rio Grande do Sul</option>
								<option <?php echo (in_array("'Ro'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Ro'">Rondônia</option>
								<option <?php echo (in_array("'Rr'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Rr'">Roraima</option>
								<option <?php echo (in_array("'Sc'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Sc'">Santa Catarina</option>
								<option <?php echo (in_array("'Sp'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Sp'">São Paulo</option>
								<option <?php echo (in_array("'Se'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'Se'">Sergipe</option>
								<option <?php echo (in_array("'To'", explode(",", $Fila[0]['Estado_fila']))) ? 'selected' : '' ?> value="'To'">Tocantins</option>
							</select>
						</div>
					</div>
					<div class='form-row cols-3'>
						<div class="form-group col-sm">
							<label>Especies</label>
							<select multiple rows='6' class="form-control" name="especie[]" >
								<?php
									foreach($especie as $Values){
										$sel = (in_array("'".$Values['especie_ficha']."'", explode(",", $Fila[0]['especie_fila']))) ? 'selected' : '';
										echo "<option $sel value=\"'{$Values['especie_ficha']}'\">{$Values['especie_ficha']}</option>";
									}
								?>
							</select>
						</div>
						
						<div class="form-group col-sm">
							<label>Entidade</label>
							<select multiple rows='6' class="form-control" name="entidade[]" >
								<?php
									foreach($entidade as $Values){
										$sel = (in_array("'".$Values['DesEnt_ficha']."'", explode(",", $Fila[0]['entidade_fila']))) ? 'selected' : '';
										echo "<option $sel value=\"'{$Values['DesEnt_ficha']}'\">{$Values['DesEnt_ficha']}</option>";
									}
								?>
							</select>
						</div>
						
						<div class="form-group col-sm">
							<label>Convenio</label>
							<select multiple rows='6' class="form-control" name="convenio[]" >
								<?php
									foreach($convenio as $Values){
										$sel = (in_array("'".$Values['convenio_ficha']."'", explode(",", $Fila[0]['convenio_fila']))) ? 'selected' : '';
										echo "<option $sel value=\"'{$Values['convenio_ficha']}'\">{$Values['convenio_ficha']}</option>";
									}
								?>
							</select>
						</div>
					</div>
					
				</fieldset>

				<fieldset class='border p-2 rounded mb-3'>
					<label><h5>Ordem</h5></label>
					<div class='form-row'>
						<div class="form-group col-sm">
							<select class="form-control" name="Ordem[0]">
								<option value=''>Selecione</option>
								<option <?php echo (isset($Ordem[0]) AND $Ordem[0] == "salario_ficha ASC") ? "selected" : "" ?> value="salario_ficha ASC">Salário Crescente</option>
								<option <?php echo (isset($Ordem[0]) AND $Ordem[0] == "salario_ficha DESC") ? "selected" : "" ?> value="salario_ficha DESC">Salário Decrescente</option>
								<option <?php echo (isset($Ordem[0]) AND $Ordem[0] == "QtdEmp_ficha ASC") ? "selected" : "" ?> value="QtdEmp_ficha ASC">Qtd Contratos Crescente</option>
								<option <?php echo (isset($Ordem[0]) AND $Ordem[0] == "QtdEmp_ficha DESC") ? "selected" : "" ?> value="QtdEmp_ficha DESC">Qtd Contratos Decrescente</option>
							</select>
						</div>

						<div class="form-group col-sm">
							<select class="form-control" name="Ordem[1]">
								<option value=''>Selecione</option>
								<option <?php echo (isset($Ordem[1]) AND $Ordem[1] == "salario_ficha ASC") ? "selected" : "" ?> value="salario_ficha ASC">Salário Crescente</option>
								<option <?php echo (isset($Ordem[1]) AND $Ordem[1] == "salario_ficha DESC") ? "selected" : "" ?> value="salario_ficha DESC">Salário Decrescente</option>
								<option <?php echo (isset($Ordem[1]) AND $Ordem[1] == "QtdEmp_ficha ASC") ? "selected" : "" ?> value="QtdEmp_ficha ASC">Qtd Contratos Crescente</option>
								<option <?php echo (isset($Ordem[1]) AND $Ordem[1] == "QtdEmp_ficha DESC") ? "selected" : "" ?> value="QtdEmp_ficha DESC">Qtd Contratos Decrescente</option>
							</select>
						</div>
						
						<div class="form-group col-sm">
							<select class="form-control" name="Ordem[2]">
								<option value=''>Selecione</option>
								<option <?php echo (isset($Ordem[2]) AND $Ordem[2] == "salario_ficha ASC") ? "selected" : "" ?> value="salario_ficha ASC">Salário Crescente</option>
								<option <?php echo (isset($Ordem[2]) AND $Ordem[2] == "salario_ficha DESC") ? "selected" : "" ?> value="salario_ficha DESC">Salário Decrescente</option>
								<option <?php echo (isset($Ordem[2]) AND $Ordem[2] == "QtdEmp_ficha ASC") ? "selected" : "" ?> value="QtdEmp_ficha ASC">Qtd Contratos Crescente</option>
								<option <?php echo (isset($Ordem[2]) AND $Ordem[2] == "QtdEmp_ficha DESC") ? "selected" : "" ?> value="QtdEmp_ficha DESC">Qtd Contratos Decrescente</option>
							</select>
						</div>
					</div>
				</fieldset>
				
				<fieldset class='border p-2 rounded mb-3'>
					<label><h5 >Mailing (Total de arquivos: <?php echo count($Mailing) ?>)</h5></label>
					<div class='form-row'>
						<div class='form-group col-sm-4'>
							<div class='form-check'>
								<label class='form-check-label'>
									<input class='form-check-input' type='checkbox' value="0" name='Mailing[]' id="MailingC" onclick="habilitar()">
									Todas
								</label>
							</div>
						</div>
					<?php
						foreach($Mailing as $Values){
							$sel = (in_array("'".$Values['ArqInc_Ficha']."'", explode(",", $Fila[0]['Mailing_fila']))) ? 'checked' : '';
							echo "<div class='form-group col-sm-4'>
									<div class='form-check'>
										<label class='form-check-label'>
											<input class='form-check-input' id='Mailing' type='checkbox' $sel value=\"'{$Values['ArqInc_Ficha']}'\" name='Mailing[]'>
											{$Values['ArqInc_Ficha']}
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
						<a class='btn btn-danger form-control' href='?p=Cadastro/Filas' title = 'Cancelar' name='Cancelar'>Cancelar</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	function habilitar(){  
		if(document.getElementById('CidadeC').checked){  
			document.getElementById('Cidade').disabled = true;  
		} else {  
			document.getElementById('Cidade').disabled = false;  
		}
		
		if(document.getElementById('MailingC').checked){  
			lista = document.getElementsByName("Mailing[]");
			for ( var i = 0 ; i < lista.length ; i++ ){
				lista[i].checked = true;
			};
			
		} else {  
			lista = document.getElementsByName("Mailing[]");
			for ( var i = 0 ; i < lista.length ; i++ ){
				lista[i].checked = false;
			};
		}  
	} 
</script>