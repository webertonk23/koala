<?php
	$Read = new Read;
	
	$Query = "select
		carteira,
		fichas.ulttabulacao,
		Nome_Grupo,
		tabulacao,
		count(fichas.id) as Volume
		from
			fichas LEFT JOIN Tabulacao ON fichas.ulttabulacao = tabulacao.id
			left join grupo_tabulacao on tabulacao.id_grupo = grupo_tabulacao.id
			LEFT JOIN carteira on fichas.IdCarteira = carteira.Id
		GROUP BY tabulacao, carteira
		ORDER BY Carteira, ulttabulacao";
	$Read->FullRead($Query);
	
	if($Read->GetRowCount()>0){
		$Lista = $Read->GetResult();
	}
	
	$Tabela = "<table class='table'>";
	
	$THead = "<thead><tr><th>Carteira</th><th>Tabulação</th><th>Volume</th></tr></thead>";
	
	$TBody = "<tbody><tr class='align-middle'>";
	
	$VTotal = 0;
	
	if(!empty($Lista)){
			foreach($Lista as $Key => $Value){
				
				$VTotal += $Value['Volume'];
				
				$TBody .= "<td>".$Value['carteira']."</td>";
				($Value['ulttabulacao']) ? $TBody .= "<td>".$Value['Nome_Grupo']." -> ".$Value['tabulacao'] : $TBody .= "<td>Não Trabalhado</td>";
				$TBody .= "<td>".number_format($Value['Volume'], 0, ',', '.')."</td></td></tr>";
			}
		}

		$Tabela .= $THead.$TBody."</tbody></table>";
	
	
	$Read->ExeRead('carteira', "WHERE perfil='Vendas'");
	if($Read->GetRowCount()>0){
		$Carteiras = $Read->GetResult();
	}
	
	$Read->FullRead('SELECT Produtos.Id, Produtos.Produto, Carteira.Carteira FROM Produtos LEFT JOIN Carteira ON Produtos.id_Carteira = Carteira.id');
	if($Read->GetRowCount()>0){
		$Produtos = $Read->GetResult();
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
				<label>Carteiras</label>
				<select class='form-control' name='Carteira'>
					<option value='0' <?php echo (!empty($_POST['Carteira']) AND $_POST['Carteira'] == 0) ? 'selected' : '';?> >Todas</option>
					<?php
						if(!empty($Carteiras)){
							foreach($Carteiras as $Value){
								$Selected = (!empty($_POST['Carteira']) AND $_POST['Carteira'] == $Value['Id']) ? 'selected' : '';
								echo "<option $Selected value='{$Value['Id']}'>{$Value['Carteira']}</option>";
							}
						}
					?>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<label>Produto</label>
				<select class='form-control' name='Produto'>
					<option value='0' <?php echo (!empty($_POST['Produto']) AND $_POST['Produto'] == 0) ? 'selected' : '';?> >Todos</option>
					<?php
						if(!empty($Produtos)){
							foreach($Produtos as $Value){
								$Selected = (!empty($_POST['Produto']) AND $_POST['Produto'] == $Value['Id']) ? 'selected' : '';
								echo "<option $Selected value='{$Value['Id']}'>{$Value['Carteira']} -> {$Value['Produto']}</option>";
							}
						}
					?>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<label> </label>
				<button class='form-control btn btn-primary' name='Aplicar'>Aplicar</button>
			</div>
		</form>
	</div>
</div>
	
<div class='card'>
	<div class='card-body' id='Tabela'>
		<?php if(!empty($Tabela)){ ?>
		<form method='POST' action='/KoalaCRM/_app/views/Relatorios/Exportar.php/?r=Volume_de_mailing'>
			<div class='form-row justify-content-between'>
				<div class='form-group col-sm'>
					<label class='font-weight-bold'>Volume de Fichas: </label>
					<span><?php echo number_format($VTotal, 0, ',','.');?></span>
				</div>
				
				<div class='form-group col-sm-3'>
					<input type='hidden' value="<?php echo $Tabela; ?>" name='Tabela'/>
					<button type='submit' class='form btn btn-success form-control' name='Exportar'><span class="oi oi-document"></span> Exportar</button>
				</div>
			</div>
		</form>
		<?php
			echo $Tabela;
		}
		?>
	</div>
</div>