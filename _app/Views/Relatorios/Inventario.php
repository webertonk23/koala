<?php
	$Read = new Read;
	
	$Query = "Select * From ativos";
	
	$Termos = "";
	$Places = "";
	
	$Query .= $Termos;
	
	$Read->FullRead($Query, $Places);
	if($Read->GetRowCount()>0){
		$Lista = $Read->GetResult();
	}
	
	$Tabela = "<table class='table'>";

	$THead = "
		<thead>
			<tr>
				<th>Etiqueta</th>
				<th>Produto</th>
				<th>Descrição</th>
				<th>Setor</th>
				<th>Dt Entrada</th>
				<th>Dt Baixa</th>
				<th>Fornecedor</th>
				<th>Valor</th>
			</tr>
		</thead>";
	
	$TBody = "<tbody>";
	
	if(!empty($Lista)){
		foreach($Lista as $Key => $Value){
			
			$TBody .= "<tr class='align-middle '><td>".$Value['Etiqueta_ativo']."</td>";
			$TBody .= "<td>".$Value['Produto_ativo']."</td>";
			$TBody .= "<td>".$Value['Descricao_ativo']."</td>";
			$TBody .= "<td>".$Value['Setor_ativo']."</td>";
			$TBody .= "<td>".date("d/m/Y", strtotime($Value['DtEnt_ativo']))."</td>";
			$TBody .= (!empty($Value['DtBaixa_ativo'])) ? "<td>".date("d/m/Y", strtotime($Value['DtBaixa_ativo']))."</td>" : "<td></td>" ;
			$TBody .= "<td>".$Value['Fornecedor_ativo']."</td>";
			$TBody .= "<td>".number_format($Value['Valor_ativo'], 2, ",", ".")."</td></tr>";
		}
	}

	$Tabela .= $THead.$TBody."</tbody></table>";
?>
<div class='card mb-2'>
	<div class='card-body' id='Tabela'>
		<h4 class='card-title'>Relatório de ativos</h4>
		<form method='POST' action='_app/Views/Relatorios/Exportar.php/?r=ativos'>
			<div class='form-row justify-content-between'>
				<div class='form-group col-sm'>
					<label class='font-weight-bold'>Quantidade: </label>
					<span><?php echo (!empty($Lista)) ? Count($Lista) : 0;?></span>
				</div>
				
				<div class='form-group col-sm'>
					<input type='hidden' value="<?php echo $Tabela; ?>" name='Tabela'/>
					<button type='submit' class='form btn btn-success form-control' name='Exportar'><span class="oi oi-document"></span> Exportar</button>
				</div>
			</div>
		</form>
		
		<?php echo (!empty($Tabela)) ? $Tabela : ""; ?>
	</div>
</div>