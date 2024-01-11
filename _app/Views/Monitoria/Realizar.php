<?php

	$Read = new Read;
	// $Pergunta = clone($Busca);
	// $Avaliacao = clone($Busca);
	// $Operador = clone($Busca);
	// $Categoria = clone($Busca);
	
	if(!isset($_GET['Id_M']) AND !isset($_GET['Id_O']) AND !isset($_GET['Id_C'])){
		header('location: ?p=Monitoria');
	}else{
		$Id_M = $_GET['Id_M'];
		$Id_O = $_GET['Id_O'];
		$Id_C = $_GET['Id_C'];
	}
	
	if(isset($_POST['Salvar'])){
		if(!empty($_POST['Acao'])){
			
			$_POST['Id_Av'] = $Id_M;
			$_POST['Data'] = date('Y-m-d');
			$_POST['Id_Avaliador'] = $_SESSION['UsuarioKoala']['Id'];
			$_POST['Id_Func'] = $Id_O;
			$_POST['Id_Chamada'] = trim($Id_C);
			$_POST['Avaliador'] = $_SESSION['UsuarioKoala']['Usuario'];
			$_POST['Obs'] = $Check->Name($_POST['Obs']);
			$Respostas = $_POST['Resposta'];
			
			unset($_POST['Salvar']);
			unset($_POST['Resposta']);
			
			$Realiza = new ControleRealiza;
			$Realiza->Realizar($_POST, $Respostas);
			echo $Realiza->GetResult();
		}else{
			echo "<div class='alert alert-warning alert-dismissible text-center' role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
						<span aria-hidden='true'>&times;</span>
					</button>
					Preencha todos os campos para continuar!
				 </div>";
		}
	}
	unset($_POST);
	
	$Read->ExeRead('Monitoria', 'WHERE Id_Av = :Id', "Id={$Id_M}");
	if($Read->GetRowCount()>0){
		$Monitoria = $Read->GetResult()[0];
	}
	
	$Read->ExeRead('Funcionarios', 'WHERE Id = :Id', "Id={$Id_O}");
	if($Read->GetRowCount()>0){
		$Operador = $Read->GetResult()[0];
	}
	
	$Read->FullRead("SELECT DISTINCT Nome_Cat, Id_Categoria FROM MonitoriaCategorias INNER JOIN MonitoriaPerguntas ON Id_cat = Id_Categoria WHERE Id_Avaliacao = :Id ORDER BY Id_Categoria", "Id={$Id_M}");
	if($Read->GetRowCount()>0){
		$Categorias = $Read->GetResult();
	}
?>
	
	<legend ><h3 >Realizar Monitoria - <?php echo $Monitoria['Nome_Av'];?></h3></legend>
	<form class='row' method="POST">
		<div class="col-sm-4">
			<div class="card mb-3">
				<div class='card-body'>
					<div class='form-group'>
						<Label>Id Ligação (Uniqueid)</Label>
						<input type='text' disabled class='form-control' Name='Id_Chamada' value='<?php echo $Id_C;?>'>
					</div>
			
					<div class='form-group'>
						<Label for='Operador' title=''>Operador a ser avaliado</Label>
						<input type='text' disabled class='form-control' Name='Id_Chamada' value='<?php echo $Operador['NomeCompleto'];?>'>
					</div>
			
					<div class='form-group'>
						<label>Ação</label>
						<select class='form-control' Name='Acao'>
							<option  selected disabled>Selecione uma Ação</option>
							<option  >Sem Ação</option>
							<option  >Feedback</option>
							<option  >Medida discilinar</option>
							<option  >Suspenção 1 Dia</option>
							<option  >Suspenção 2 Dia</option>
						</select>
					</div>
					
					<div class='form-group'>
						<label>Observação</label>
						<textarea class="form-control" rows='5' name='Obs'></textarea> 
					</div>
				</div>
			</div>
		</div>
		
		<div  class='col-sm-8'>
			<div >
				<?php
					if(!empty($Categorias)){
						foreach($Categorias as $chave){
							echo "<div class='card mb-3'>
								<div class='card-header'><h4 class='card-title'>{$chave['Nome_Cat']}</h4></div>
								<div class='card-body'>";
								
								$Read->ExeRead('MonitoriaPerguntas', 'WHERE Id_Avaliacao = :Id_Avaliacao AND Id_Categoria = :Id_Categoria AND Ativo = 1 ORDER BY Id_Categoria', "Id_Avaliacao={$Id_M}&Id_Categoria={$chave['Id_Categoria']}");
								if($Read->GetRowCount()>0){
									$Perguntas = $Read->GetResult();
								}
								
								foreach ($Perguntas as $key => $value){
								$checked = ($value['Resposta'])?'checked':'';
								echo "
									<dl class='row'>
										<dt class='col-sm-10'>".$value['Pergunta']."?</dt>
										<label class='switch'>
											<input type='checkbox' name='Resposta[{$value['Id_Itens']}]' id='{$value['Id_Itens']}'  value='1' $checked >
											<span class='slider round'></span>
										</label>
									</dl>";	
							}
							echo "</div><div class='card-footer'></div></div>";
						}
					}else{
						echo "<div class='danger'><h3 class='text-center'>Não há dados para mostrar, cadastre algumas perguntas para continuar!</h3><br><br></div>";
						$Disabled = 'disabled';
					}
				?>
			</div>
			
			<div class='form-group row'>
				<div class='col-sm-6'>
					<button class='btn btn-success form-control' title = 'Salvar' name='Salvar'>Salvar</button>
				</div>
				
				<div class='col-sm-6'>
					<a href='?p=Monitoria' class='btn btn-danger form-control' title = 'Cancelar' name='Cancelar'>Cancelar</a>
				</div>
			</div>
				
		</div>
	</form>