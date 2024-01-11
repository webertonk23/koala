<?php
	$Produtos = new Produtos;
	
	$Produtos->Listar();
	
	if(!$Produtos->GetErro()){
		$Listar = $Produtos->GetResult();
	}else{
		Erro($Produtos->GetErro()[0], $Produtos->GetErro()[1]);
	}
?>
<div class="">
	<div class='card mb-2'>
		<div class='card-body'>
			<h3 class='card-title'>Produtos</h3>
			<form class="form-inline" name="" method="POST">	
				<input class='form-control mr-sm-2 col-sm' type='search' name='Criterio' Placeholder='Bucar Produto'>
				<button class='btn btn-success mr-sm-2' role="button" title="" name='Buscar'><span class="fa fa-search"></span></button>
				<span class='mr-sm-2'>|</span>
				<a class='btn btn-primary' href='?p=Cadastro/Criar_Produto' role="button" title="Criar"><span class="fa fa-plus"></span></a>
			</form>
		</div>
	</div>
	
	<div class='card'>
		<div class='card-body'>
			<table class='table table-hover table-sm table-bordered'>
				<thead>
					<tr>
						<th>#Id</th>
						<th>Produto</th>
						<th>Ação</th>
					</tr>
				</thead>
				
				<tbody>
					<form method='POST'>
						<?php
							if(!empty($Listar)){
								foreach ($Listar as $key => $value){
									echo "<tr><td class='text-center'>".$value['id_prod']."</td>";
									echo "<td class='col'>".$value['desc_prod']."</td>";
									echo "<td><a class='btn btn-info btn-sm' href='?p=Cadastro/Editar_Produto&Id=".$value['id_prod']."'><span class='fa fa-pencil-square-o'></span></a></tr>";
									
								}
							};	
						?>
					</form>
				</tbody>
			</table>
		</div>
	</div>
</div>
