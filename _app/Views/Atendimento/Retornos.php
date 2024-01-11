<?php
	$PostForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

	$Read = new read;
	
	$DataDe = date("Y-m-d 00:00:00");
	$DataAte = date("Y-m-d 23:59:59");
	
	if(!empty($PostForm['Feito_Ret'])){
		$Updade = new Update();
		
		$Ret['Feito_Ret'] = 1;
		
		$Updade->ExeUpdate('Retornos', $Ret, "WHERE Id_Ret = :Id", "Id={$PostForm['Feito_Ret']}");
		
		if($Update->GetResult()){
			Erro("Retorno confirmado com sucesso", SUCESSO);
		}
	}
	
	if(!empty($PostForm['DataAte']) AND !empty($PostForm['DataDe'])){
		$DataDe = $PostForm['DataDe']." 00:00:00";
		$DataAte = $PostForm['DataAte']." 23:59:59";
	}
	
	if(!empty($PostForm['Busca'])){
		$Campo = $PostForm['Campo'] ;
		
		$Busca = ($PostForm['Campo']=='Id_Pes') ? (int) $PostForm['Buscar'] : $PostForm['Buscar'] ;
		
		//Debug($_SESSION);
		if($Campo != 'Telefone'){
			$Read->FullRead("
				SELECT TOP 50 * 
				FROM 
					Pessoas INNER JOIN Retornos ON idpes_ret = id_pes
				WHERE 
					{$Campo} LIKE :Busca
					AND iduser_ret = :IdUser
					AND Feito_Ret = 0
					AND Data_Ret BETWEEN '".$DataDe."' AND '".$DataAte."'
				ORDER BY Data_Ret",
				
				"IdUser={$_SESSION['Usuario']['Id_user']}&Busca={$Busca}%");
		}else{
			$Read->FullRead("
				SELECT TOP 50 *
				FROM
					Telefones join Pessoas ON IdPes_tel = Id_Pes
					INNER JOIN Retornos ON idpes_ret = id_pes
				WHERE
					concat(ddd_tel,Telefone_tel) LIKE :Busca 
					AND iduser_ret = :IdUser
					AND Feito_Ret = 0
					AND Data_Ret BETWEEN '".$DataDe."' AND '".$DataAte."'
				ORDER BY
					Data_Ret",
				"IdUser={$_SESSION['Usuario']['Id_user']}&Busca={$Busca}%");
		}
	}else{
		$Read->FullRead("
			SELECT TOP 50 *
			FROM
				Pessoas INNER JOIN Retornos ON idpes_ret = id_pes
			WHERE
				iduser_ret = :IdUser
				AND Feito_Ret = 0 
				AND Data_Ret BETWEEN '".$DataDe."' AND '".$DataAte."'
			ORDER BY Data_Ret", "IdUser={$_SESSION['Usuario']['Id_user']}");
	}
	
	if($Read->GetRowCount()>0){
		$Lista = $Read->GetResult();
	}

?>

<div class='card mb-2'>
	<div class='card-body'>
		<h3 class='card-title'>Retornos</h3>
		<form class="form-inline" name="" method="POST">
			
			<select name='Campo' class='form-control col-sm mr-2'>
				<option value='Id_Pes'>#Id</option>
				<option value='CpfCnpj_Pes'>CPF/CNPJ</option>
				<option value='Nome_Pes'>Nome</option>
				<option value='Telefone'>DDD+Telefone</option>
			</select>
			
			<input class="form-control col-sm-5  mr-2" Name="Buscar" type="text" placeholder="Buscar" Value="<?php echo (isset($_POST['Buscar'])) ? $_POST['Buscar'] : "" ; ?>">
			<input class="form-control col-sm  mr-2" type='date' Name="DataDe">
			<input class="form-control col-sm  mr-2" type='date' Name="DataAte">
			<button type="submit" class="btn btn-outline-info mr-2" title="Buscar" name='b'>Buscar</button>
		</form>
	</div>
</div>

<div class='card col-sm'>
	<div class='card-body'>
		<table class='table table-hover table-sm table-striped'>
			<thead class="">
				<tr>
					<th scope="col">#ID</th>
					<th scope="col">Nome</th>
					<th scope="col">CPF/CNPJ</th>
					<th scope="col">Dt Retorno</th>
					<th scope="col">Motivo</th>
					<th scope="col">Ação</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
					if(!empty($Lista)){
						echo "<form method='POST'>";
						foreach ($Lista as $key => $value){
							echo "<tr >";
							echo "<td scope='row' >{$value['Id_Pes']}</td>";
							echo "<td>".$value['Nome_Pes']."</td>";
							echo "<td>".$value['CpfCnpj_Pes']."</td>";
							echo "<td>".$Check->Data($value['Data_Ret'])."</td>";
							echo "<td>".$value['Motivo_Ret']."</td>";
							echo "<td>";
							echo "<a href='?p=Atendimento/Acionamento&Id={$value['Id_Pes']}&Tipo=Rt' class='btn btn-outline-primary btn-sm mr-2'><span class='fa fa-eye'></span></a>";
							echo "<button class='btn btn-outline-success btn-sm mr-2' name='Feito_Ret' value='".$value['Id_Ret']."'><span class='fa fa-check'></span></button>";
							echo "</td></tr>";
						}
						echo "</form>";
					}else if(!empty($_POST['Buscar'])){
						Erro("Pesquisa não retornou resultados", INFO);
					}
				?>
				</form>
			</tbody>
		</table>
	</div>
</div>