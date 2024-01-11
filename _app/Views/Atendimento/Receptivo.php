<?php
	
	$PostForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

	$Read = new read;
	
	if(!empty($PostForm['Buscar'])){
		$Campo = $PostForm['Campo'] ;
		
		$Busca = ($PostForm['Campo']=='Id_Pes') ? (int) $PostForm['Buscar'] : $PostForm['Buscar'] ;
		
		
		if($Campo != 'Telefone'){
			$Read->FullRead("SELECT TOP 50 * FROM Pessoas WHERE {$Campo} LIKE :Busca ORDER BY Id_Pes", "Busca={$Busca}%");
		}else{
			$Read->FullRead("SELECT TOP 50 * FROM Telefones join Pessoas ON IdPes_tel = Id_Pes WHERE concat(ddd_tel,Telefone_tel) LIKE :Busca", "Busca={$Busca}%");
		}
		
		if($Read->GetRowCount()>0){
			$Lista = $Read->GetResult();
		}
		
		//Debug($Read);
	}
?>

<div class='card mb-2'>
	<div class='card-body'>
		<h3 class='card-title'>Receptivo</h3>
		<form class="form-inline" name="" method="POST">
			
			<select name='Campo' class='form-control col-sm-2 mr-2'>
				<option value='Id_Pes'>#Id</option>
				<option value='CpfCnpj_Pes'>CPF/CNPJ</option>
				<option value='Nome_Pes'>Nome</option>
				<option value='Telefone'>DDD+Telefone</option>
			</select>
			
			<input class="form-control  col-sm-6  mr-2" Name="Buscar" type="text" placeholder="Buscar" Value="<?php echo (isset($_POST['Buscar'])) ? $_POST['Buscar'] : "" ; ?>">
			
			<button type="submit" class="btn btn-outline-info mr-2" title="Buscar">Buscar</button>
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
					<th scope="col">Ação</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
					if(!empty($Lista)){		
						foreach ($Lista as $key => $value){
							echo "<tr >";
							echo "<td scope='row' >{$value['Id_Pes']}</td>";
							echo "<td>".$value['Nome_Pes']."</td>";
							echo "<td>".$value['CpfCnpj_Pes']."</td>";
							echo "<td>";
							echo "<a href='?p=Atendimento/Acionamento&Id={$value['Id_Pes']}&Tipo=R' class='btn btn-outline-primary btn-sm mr-2'><span class='fa fa-eye'></span></a>";
							echo "</td></tr>";
						}
					}else if(!empty($_POST['Buscar'])){
						Erro("Pesquisa não retornou resultados", INFO);
					}
				?>
				</form>
			</tbody>
		</table>
	</div>
</div>