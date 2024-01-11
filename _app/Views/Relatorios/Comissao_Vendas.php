<?php
	$Read = new Read;
	
	if(!empty($_POST)){
		
		$group = $_POST['Agrupamento'];
		
		$Query = "
			SELECT
				DISTINCT {$group}, situacao_com, banco = 'BMG', SUM(valor_com) As Valor_Com
			FROM
				vendas INNER JOIN comissaobmg ON numero_venda = ade_com
				INNER JOIN usuarios ON iduser_venda = id_user
		";
		
		$Termos = "WHERE dtpag_com BETWEEN :DataDe AND :DataAte";
		
		$Places = "DataDe={$_POST['DataDe']}&DataAte={$_POST['DataAte']}";
		
		$Query .= $Termos;
		 
		$Query .= " GROUP BY {$group}, situacao_com ORDER BY {$group}, situacao_com DESC";
		
		$Read->FullRead($Query, $Places);
		if($Read->GetRowCount()>0){
			$Lista = $Read->GetResult();
		
			$Tabela['header'] = "<tr><th>". implode("</th><th>", array_keys($Lista[0])) ."</th></tr>";
			$Tabela['body'] = "";
			foreach($Lista as $k => $v){
				$v['Valor_Com'] = number_format($v['Valor_Com'], 2, ",", ".");
				$Tabela['body'] .= "<tr><td>". implode("</td><td>", $v) ."</td></tr>";
			}
		}
	}
	
	
?>
<h4>Relatório de Vendas</h4>

<div class='card mb-2'>
	<div class='card-body'>
		<form class='form-row' method='POST'>
			<div class='form-group col-sm'>
				<label>Data Ate:</label>
				<input class='form-control' type='date' name='DataDe' required value='<?php echo (!empty($_POST['DataDe'])) ? $_POST['DataDe'] : '';?>'>
			</div>
			
			<div class='form-group col-sm'>
				<label>Data Até:</label>
				<input class='form-control' type='date' name='DataAte' required value='<?php echo (!empty($_POST['DataAte'])) ? $_POST['DataAte'] : '';?>'>
			</div>
			
			<div class='form-group col-sm'>
				<label>Agrupamento</label>
				<select name ='Agrupamento' class='form-control'>
					<option value=0 selected disabled>Selecione</option>
					<option value='nome_user' <?php echo (!empty($_POST['Agrupamento']) AND $_POST['Agrupamento'] == 'nome_user') ? 'selected' : '' ?>>Usuario</option>
					<option value='numero_venda' <?php echo (!empty($_POST['Agrupamento']) AND $_POST['Agrupamento'] == 'numero_venda') ? 'selected' : '' ?>>Numero Venda / ADE</option>
					<option value='nome_user, numero_venda' <?php echo (!empty($_POST['Agrupamento']) AND $_POST['Agrupamento'] == 'nome_user, numero_venda') ? 'selected' : '' ?>>Usuario + Numero Venda / ADE</option>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<label> </label>
				<button class='form-control btn btn-primary' name='Aplicar'>Aplicar</button>
			</div>
		</form>
	</div>
</div>

<?php if(!empty($Tabela)){ ?>
	<div class='card mb-2'>
		<div class='card-body ' id=''>
			<form method='POST' action='/KoalaCRM/_app/views/Relatorios/Exportar.php/?r=Relatorio_de_Vendas'>
				<div class='form-row justify-content-between'>
					<div class='form-group col-sm'>
						<input type='hidden' value="<?php echo" <table class='table' border='1' center>".$Tabela['header'].$Tabela['body']."</table>"; ?>" name='Tabela'/>
						<button type='submit' class='form btn btn-success form-control' name='Exportar'><span class="oi oi-document"></span> Exportar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div class='card'>
		<div class='card-body' id=''>
			<table class='table'>
			<?php
				echo $Tabela['header'];
				echo $Tabela['body'];
			?>
			</table>
		</div>
	</div>
	<?php }?>
</div>