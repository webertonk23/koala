<?php
	$Read = new Read;
	
	if(!empty($_POST)){
		
		$Query = "
			SELECT
				numero_venda AS adesão,
				nomecli_excom AS cliente,
				cpfcli_excom AS cpf,
				dtpag_excom AS 'pgto',
				Nome_user AS usuario,
				banco_excom AS banco,
				produto_excom As produto,
				CASE status_excom WHEN 1 THEN 'pago' ELSE 'estorno' END AS status,
				status_excom * vlcom_excom AS valor
			FROM
				VENDAS INNER JOIN extratocomissao ON numero_venda = ade_excom
				INNER JOIN usuarios ON iduser_venda = id_user
		";
		
		$Termos = "WHERE dtpag_excom BETWEEN :DataDe AND :DataAte";
		
		$Termos .= ($_SESSION['Usuario']['Nivel_user'] == 1) ? " AND iduser_venda = :iduser" : "";
		
		$Places = "DataDe={$_POST['DataDe']}&DataAte={$_POST['DataAte']}";
		
		$Places .= ($_SESSION['Usuario']['Nivel_user'] == 1) ? "&iduser={$_SESSION['Usuario']['Id_user']}" : "";
		
		$Query .= $Termos;
		
		$Read->FullRead($Query, $Places);
		$Lista = ($Read->GetRowCount()>0) ? $Read->GetResult() : array();
		
		$Query = "
			SELECT
				numero_venda,
				cliente_com AS cliente,
				cpf_com AS cpf,
				dtpag_com as pgto,
				Nome_user AS usuario,
				banco = 'BMG',
				tipocom_com AS produto,
				situacao_com AS satus,
				valor_com AS valor
			FROM
				vendas INNER JOIN comissaobmg ON numero_venda = ade_com
				INNER JOIN usuarios ON iduser_venda = id_user
		";
		
		$Termos = "WHERE dtpag_com BETWEEN :DataDe AND :DataAte";
		
		$Termos .= ($_SESSION['Usuario']['Nivel_user'] == 1) ? " AND iduser_venda = :iduser" : "";
		
		$Places = "DataDe={$_POST['DataDe']}&DataAte={$_POST['DataAte']}";
		
		$Places .= ($_SESSION['Usuario']['Nivel_user'] == 1) ? "&iduser={$_SESSION['Usuario']['Id_user']}" : "";
		
		$Query .= $Termos;
		
		$Read->FullRead($Query, $Places);
		
		if($Read->GetRowCount()>0){
			foreach($Read->GetResult() as $v){
				array_push($Lista, $v);
			}
		}
		
		if(!empty($Lista)){
			$Tabela['header'] = "<tr><th>". implode("</th><th>", array_keys($Lista[0])) ."</th></tr>";
			$Tabela['body'] = "";
		
			foreach($Lista as $k => $v){
				$v['valor'] = number_format($v['valor'], 2, ",", ".");
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