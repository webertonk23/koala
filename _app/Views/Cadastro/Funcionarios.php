<?php
	if(isset($_POST['ApagaUm'])){
		$ApagaUm = new ControleUsuarios;
		$ApagaUm->Apagar($_POST['ApagaUm']);
		echo $ApagaUm->GetResult();
	}
	
	$Usuario = new read();
	
	if(isset($_POST['Buscar']) and !empty($_POST['Criterio'])){
		
		$Usuario->ExeRead('Funcionarios', 'WHERE NomeCompleto LIKE :Criterio ORDER BY Id', "Criterio={$_POST['Criterio']}%");

		if($Usuario->GetRowCount()>0){
			$Lista = $Usuario->GetResult();
		}
	}else{
		
		$Usuario->ExeRead('Funcionarios', 'ORDER BY Id');
		
		if($Usuario->GetRowCount()>0){
			$Lista = $Usuario->GetResult();
		}
	}
?>

<div class=''>
	<div class='card mb-2'>
		<div class='card-body'>
			<!-- <div class="navbar navbar-expand-lg text-white justify-content-between mb-3" name="ControlBar"> -->
			<h3 class='card-title'>Funcionarios</h3>
			<form class="form-inline" method="POST">	
				<input class='form-control mr-sm-2 col-sm' type='search' name='Criterio' Placeholder='Bucar por Nome'>
				<button class='btn btn-outline-info mr-2' role="button" title="" name='Buscar'><span class="fa fa-search"></span> Buscar</button>
				<a class='btn btn-outline-success' href='?p=Cadastro/Criar_Funcionario' role="button" title="Criar"><span class="fa fa-plus"> Novo</span></a>
			</form>
		</div>
	</div>

	<div class='card'>
		<div class='card-body'>
			<table class='table table-hover table-sm'>
				<thead>
					<tr>
						<th class=''>#ID</th>
						<th>Nome</th>
						<th>Status</th>
						<th class=''>Ação</th>
						
					</tr>
				</thead>
				
				<tbody>
					<form method='POST'>
						<?php
							if(!empty($Lista)){
								foreach ($Lista as $key => $value){
									echo "<tr><td>".$value['Id']."</td>";
									echo "<td>".$value['NomeCompleto']."</td>";
									echo "<td>".$value['Status']."</td>";
									echo "<td><a class='btn btn-info btn-sm mr-2' href='?p=Cadastro/Editar_Funcionario&Id={$value['Id']}' ><span class='fa fa-pencil'></span></a>";
									echo "<a class='btn btn-info btn-sm' href='?p=Cadastro/Fixa_Funcionario&Id={$value['Id']}' ><span class='fa fa-align-justify'></span></a>";
									echo "</td></tr>";
								}
							};
						?>
					</form>
				</tbody>
			</table>
		</div>
	</div>
</div>
