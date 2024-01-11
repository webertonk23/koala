<?php
	$Read = new read();
	
	if(!empty($_POST['Criterio'])){
		$_POST['Criterio'] = utf8_encode($_POST['Criterio']."%");
		//echo $_POST['Criterio'];
		$Query = "
			SELECT
				p1.Id_user,
				p1.Usuario_user,
				p1.Nome_user,
				p2.Nome_user AS Supervisor,
				desc_equipe,
				p1.Ativo_user
			FROM
				usuarios AS p1 LEFT JOIN usuarios AS p2 ON p1.IdSuper_user = p2.Id_user
				LEFT JOIN equipe ON p1.idequipe_user = id_equipe
			WHERE
				p1.nome_user LIKE :nome
			ORDER BY
				p1.Nome_user
		";
		$Read->FullRead($Query, "nome={$_POST['Criterio']}");
		
		//var_dump($Read);
	}else{
		$Query = "
			SELECT
				p1.Id_user,
				p1.Usuario_user,
				p1.Nome_user,
				p2.Nome_user AS Supervisor,
				desc_equipe,
				p1.Ativo_user
			FROM
				usuarios AS p1 LEFT JOIN usuarios AS p2 ON p1.IdSuper_user = p2.Id_user
				LEFT JOIN equipe ON p1.idequipe_user = id_equipe
			ORDER BY
				p1.Nome_user
		";
		$Read->FullRead($Query);
	}
	
	if($Read->GetRowCount()>0){
		$Usuarios = $Read->GetResult();
	}
	
?>
<div class="">
	<div class='card mb-2'>
		<div class='card-body'>
			<h3 class='card-title'>Usuarios</h3>
			<form class="form-inline" name="" method="POST">	
				<input class='form-control mr-sm-2 col-sm' type='search' name='Criterio' Placeholder='Bucar Usuario' value='<?php echo (!empty($_POST['Criterio'])) ? str_replace("%", "", $_POST['Criterio']) : ""?>'>
				<button class='btn btn-success mr-sm-2' role="button" title="" name='Buscar'><span class="fa fa-search"></span></button>
				<span class='mr-sm-2'>|</span>
				<a class='btn btn-primary' href='?p=Cadastro/Criar_Usuario' role="button" title="Criar"><span class="fa fa-plus"></span></a>
			</form>
		</div>
	</div>
	
	<div class='card'>
		<div class='card-body'>
			<table class='table table-hover table-sm'>
				<thead>
					<tr>
						<th>#Id</th>
						<th>Usuario</th>
						<th>Nome</th>
						<th>Equipe</th>
						<th>Supervisor</th>
						<th>Ação</th>
					</tr>
				</thead>
				
				<tbody>
					<form method='POST'>
						<?php
							if(!empty($Usuarios)){
								foreach ($Usuarios as $key => $value){
									$i = ($value['Ativo_user'] == 0) ? 'danger' : '';
									echo "<tr class='table-$i'><td>".$value['Id_user']."</td>";
									echo "<td>".$value['Usuario_user']."</td>";
									echo "<td>".$value['Nome_user']."</td>";
									echo "<td>".$value['desc_equipe']."</td>";
									echo "<td>".$value['Supervisor']."</td>";
									echo "<td><a class='btn btn-info btn-sm' href='?p=Cadastro/Editar_Usuario&Id=".$value['Id_user']."'><span class='fa fa-pencil-square-o'></span></button></td></tr>";
									
								}
							};	
						?>
					</form>
				</tbody>
			</table>
		</div>
	</div>
</div>
