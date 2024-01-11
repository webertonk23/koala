<?php
	if(!empty($_GET['Id'])){
		$Produto = new Produtos;
		
		$Produto->Listar($_GET['Id']);
	
		if(!$Produto->GetErro()){
			$Lista = $Produto->GetResult()[0];
		}else{
			Erro($Produto->GetErro()[0], $Produto->GetErro()[1]);
		}
	}
?>

<div class='row justify-content-center'>
	<div class="card col-8">
		<div class='card-body'>
			<form class="form" name="Produtos" method="POST" action='?p=Submit'>
				<?php
					if(isset($_GET['Msg']) AND isset($_GET['Err'])){
						Erro($_GET['Msg'], $_GET['Err']);
					}
					
				?>
				<label ><h3 >Editar Produto</h3></label>
				
				<div class='form-row'>
					<div class="form-group col-sm-1 ">
						<label>#Id</label>
						<input class="form-control" readonly type='text' id="Id" name='Id' Placeholder="#Id" value = '<?php echo (!empty($Lista)) ? $Lista['id_prod'] : null; ?>'>
					</div>
				
					<div class="form-group col-sm">
						<label>Produto</label>
						<input class="form-control" type="text" id="Desc_Cart" name="desc_prod" Placeholder="Produto" value = '<?php echo (!empty($Lista)) ? $Lista['desc_prod'] : null; ?>'>
					</div>
					
					<input type="hidden" name="Tabela" value='Produtos'>
					<input type="hidden" name="Page" value='<?php echo $_SERVER['QUERY_STRING'];?>'>
				</div>
				
				<div class="form-group row">
					<div class='col-sm-6'>
						<button class='btn btn-success form-control' title = 'Salvar' name='Salvar' value='Editar'>Salvar</button>
					</div>
					
					<div class='col-sm-6'>
						<a class='btn btn-danger form-control' title = 'Cancelar' href='?p=Cadastro/Produtos'>Cancelar</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>



