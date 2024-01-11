<?php
	$Read = new Read();
	
	if(isset($_POST['Buscar']) and !empty($_POST['Criterio'])){
		
		$Read->ExeRead("Ativos", "WHERE Etiqueta_ativo = {$_POST['Criterio']} ORDER BY Id_ativo", "");

		if($Read->GetRowCount()>0){
			echo "<div class='card'><div class='card-body'>";
			echo "<table class='table'>";
			foreach($Read->GetResult() as $Values){
				echo "<tr><td>{$Values['Etiqueta_ativo']}</td><td >{$Values['Produto_ativo']}</td><td>{$Values['Fornecedor_ativo']}</td><td>R$ ".number_format($Values['Valor_ativo'], 2, ',', '.')."</td>";
				echo "<td><a class='btn' href='?p=Cadastro/Editar_Ativo&Id={$Values['Id_ativo']}'><span class='fa fa-edit'></span></a></td></tr>";
			}
			echo "</table>";
			echo "</div></div>";
			
			// header("location: ?p=Cadastro/Editar_Ativo&Id={$Read->GetResult()[0]['Id_ativo']}");
		}
	}
	
	$Read->FullRead("SELECT	DISTINCT Produto_Ativo, COUNT(Id_Ativo) as Qtd, SUM(Valor_Ativo) as Valor FROM ativos WHERE Status_Ativo = 1 GROUP BY Produto_Ativo ORDER BY Qtd Desc, Valor Desc");
	
	if($Read->GetRowCount()>0){
		$Resumo = $Read->GetResult();
	}
	
?>

<div class="">
	<div class='card my-2'>
		<div class='card-body'>
			<form class="form-inline" name="" method="POST">	
				<input class='form-control mr-sm-2  col-sm' type='search' name='Criterio' Placeholder='Bucar por N Etiquera'>
				<button class='btn btn-success mr-sm-2' role="button" title="" name='Buscar'><span class="fa fa-search"></span></button>
				<span class='mr-sm-2'>|</span>
				<a class='btn btn-primary' href="?p=Cadastro/Criar_Ativo" role="button" title="Criar"><span class="fa fa-plus"></span></a>
			</form>
			
			<br>
			
			<table class='table'>
				<?php
					if(!empty($Resumo)){
						foreach($Resumo as $Values){
							echo "<tr><td>{$Values['Produto_Ativo']}</td><td >{$Values['Qtd']}</td><td>R$ ".number_format($Values['Valor'], 2, ',', '.')."</td></tr>";
						}
					}
					
				?>
			</table>
		</div>
	</div>
</div>