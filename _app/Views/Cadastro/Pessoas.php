<?php
	
	$PostForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

	$Read = new read;
	
	if(!empty($PostForm['Buscar'])){
		$Campo = $PostForm['Campo'] ;
		
		$Busca = ($PostForm['Campo']=='Id_Pes') ? (int) $PostForm['Buscar'] : $PostForm['Buscar'] ;
		
		
		$Read->FullRead("SELECT TOP 30 * FROM Pessoas WHERE {$Campo} LIKE :Busca ORDER BY Id_Pes", "Busca={$Busca}%");
		
		if($Read->GetRowCount()>0){
			$Lista = $Read->GetResult();
		}
		
		//Debug($Read);
	}
?>

<div class='card mb-2'>
	<div class='card-body'>
		<h3 class='card-title'>Pessoas</h3>
		<form class="form-inline" name="" method="POST">
			
			<select name='Campo' class='form-control col-sm-2 mr-2'>
				<option value='Id_Pes'>#Id</option>
				<option value='CpfCnpj_Pes'>CPF/CNPJ</option>
				<option value='Nome_Pes'>Nome</option>
			</select>
			
			<input class="form-control  col-sm-6  mr-2" Name="Buscar" type="text" placeholder="Buscar" Value="<?php echo (isset($_POST['Buscar'])) ? $_POST['Buscar'] : "" ; ?>">
			
			<button type="submit" class="btn btn-outline-info mr-2" title="Buscar"><span class="fa fa-magnifying-glass"></span> Buscar</button>
			<a class="btn btn-outline-success" href="?p=Fichas/Incluir" role="button" title="Novo" ><span class="fa fa-plus"></span> Novo</a>
		</form>
	</div>
</div>

<div class='card col-sm'>
	<div class='card-body'>
		<table class='table table-hover table-sm table-striped'>
			<thead class="thead-light">
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
							echo "<a href='?p=Cadastro/Editar_Pessoa&Id={$value['Id_Pes']}' class='btn btn-outline-primary btn-sm mr-2' name='Editar' title='Editar'><span class='fa fa-pencil'></span></a>";
							echo "<a href='?p=Fichas/Remover&Id={$value['Id_Pes']}' class='btn btn-outline-danger btn-sm' name='Remover' title='Remover'><span class='fa fa-trash-o'></span></a>";
							echo "</td></tr>";
						}
					}else{
						Erro("Pesquisa não retornou resultados", INFO);
					}
				?>
				</form>
			</tbody>
		</table>
	</div>
</div>