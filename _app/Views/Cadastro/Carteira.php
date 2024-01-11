<?php
	// $Carteira = new Carteira;
	
	// if(!empty($_POST)){
		
	// }
	
	$Read = new read();
	
	$Read->ExeRead('Carteira');
	if($Read->GetRowCount()>0){
		$Carteira = $Read->GetResult();
	}
	
?>
<div class="">
	<div class='card mb-2'>
		<div class='card-body'>
			<h3 class='card-title'>Carteiras</h3>
			<form class="form-inline" name="" method="POST">	
				<input class='form-control mr-sm-2 col-sm' type='search' name='desc_cart' Placeholder='Bucar Carteira'>
				<button class='btn btn-success mr-sm-2' role="button" title=""><span class="fa fa-search"></span></button>
				<span class='mr-sm-2'>|</span>
				<a class='btn btn-primary' href='?p=Cadastro/Criar_Carteira' role="button" title="Criar"><span class="fa fa-plus"></span></a>
			</form>
		</div>
	</div>
	
	<div class='card'>
		<div class='card-body'>
			<table class='table table-hover table-sm'>
				<thead>
					<tr>
						<th>#Id</th>
						<th>Carteira</th>
						<th>CNPJ</th>
						<th>Perfil</th>
						<th>Ação</th>
					</tr>
				</thead>
				
				<tbody>
					<form method='POST'>
						<?php
							if(!empty($Carteira)){
								foreach ($Carteira as $key => $value){
									echo "<tr><td>".$value['Id_Cart']."</td>";
									echo "<td>".$value['Desc_Cart']."</td>";
									echo "<td>".$value['CNPJ_Cart']."</td>";
									echo "<td>".$value['Perfil_Cart']."</td>";
									echo "<td><a class='btn btn-info btn-sm' href='?p=Cadastro/Editar_Carteira&Id=".$value['Id_Cart']."'><span class='fa fa-pencil-square-o'></span></button></td></tr>";
									
								}
							};	
						?>
					</form>
				</tbody>
			</table>
		</div>
	</div>
</div>
