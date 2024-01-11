<?php
	$Read = new read();
	
	$Update = new Update;
	
	if(!empty($_POST['power'])){
		$d = explode('-', $_POST['power']);
		
		if($d[0] === '0'){
			$Disc['Ativo_fila'] = 1;
		}else if($d[0] === '1'){
			$Disc['Ativo_fila'] = 0;
		}
		
		$Update->ExeUpdate('Fila', $Disc, "WHERE id_fila = :IdFila", "IdFila={$d[1]}");
	}
	
	$Read->ExeRead('fila', "ORDER BY Ativo_fila DESC, Id_fila ASC");
	if($Read->GetRowCount()>0){
		$Fila = $Read->GetResult();
	}

	if(!empty($_POST['Criterio'])){
		$Read->ExeRead('fila', "WHERE Desc_fila = :fila ORDER BY Ativo_fila DESC, Id_fila ASC", "fila={$_POST['Criterio']}");
		if($Read->GetRowCount()>0){
			$Fila = $Read->GetResult();
		}
	}
?>
<div class="">
	<div class='card mb-2'>
		<div class='card-body'>
			<h3 class='card-title'>Filas</h3>
			<form class="form-inline" name="" method="POST">	
				<input class='form-control mr-sm-2 col-sm' type='search' name='Criterio' Placeholder='Bucar Fila'>
				<button class='btn btn-success mr-sm-2' role="button" title="" name='Buscar'><span class="fa fa-search"></span></button>
				<span class='mr-sm-2'>|</span>
				<a class='btn btn-primary' href='?p=Cadastro/Criar_Fila' role="button" title="Criar"><span class="fa fa-plus"></span></a>
			</form>
		</div>
	</div>
	
	<div class='card'>
		<div class='card-body'>
			<table class='table table-hover table-sm'>
				<thead>
					<tr>
						<th>#Id</th>
						<th>Fila</th>
						<th>Id Disc</th>
						<th>Perfil</th>
						<th>Ação</th>
					</tr>
				</thead>
				
				<tbody>
					<form method='POST'>
						<?php
							if(!empty($Fila)){
								foreach ($Fila as $key => $value){
									echo "<tr><td>".$value['Id_fila']."</td>";
									echo "<td>".$value['Desc_fila']."</td>";
									echo "<td>".$value['iddisc_fila']."</td>";
									echo "<td>".$value['Perfil_fila']."</td>";
									$i = ($value['Ativo_fila']) ? 'success' : 'danger';
									echo "<td><a class='btn btn-info btn-sm' href='?p=Cadastro/Editar_Fila&Id=".$value['Id_fila']."'><span class='fa fa-pencil-square-o'></span></a>
										<button class='btn btn-$i btn-sm' name='power' value='{$value['Ativo_fila']}-{$value['Id_fila']}' ><span class='fa fa-power-off'></span></button></td></tr>";
									
								}
							};	
						?>
					</form>
				</tbody>
			</table>
		</div>
	</div>
</div>
