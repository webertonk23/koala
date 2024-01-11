<?php
	$Read = new Read;
	
	$Read->ExeRead('equipe');
	if($Read->GetRowCount()>0){
		$Equipe = $Read->GetResult();
	}
	
	if(!empty($_POST)){
		$e = (!empty($_POST['idequipe'])) ? " AND idequipe_user = {$_POST['idequipe']}" : '';
		
		$Query = "
			SELECT
				CONVERT (CHAR(10), DtLogin_sess, 103) AS Data,
				COUNT(*) As 'Qtd',
				CONVERT (CHAR(5), MIN(DtLogin_sess), 108) AS 'Entrada',
				CONVERT (CHAR(5), MAX(DtLogOut_sess), 108) AS 'Saida',
				Nome_user,
				desc_equipe
			FROM 
				[session] INNER JOIN usuarios ON iduser_sess = Id_user
				LEFT JOIN equipe ON idequipe_user = id_equipe
			WHERE
				dtlogin_sess BETWEEN '{$_POST['DataDe']} 00:00:00' AND '{$_POST['DataAte']} 23:59:59'
				AND Nivel_user = 1
				{$e}
			GROUP BY
				CONVERT (CHAR(10), DtLogin_sess, 103), Nome_user, desc_equipe
			ORDER BY
				data,
				Nome_user
		";
		
		$Read->FullRead($Query);
		if($Read->GetRowCount()>0){
			$Lista = $Read->GetResult();
		}
		
		$Tabela = "<table class='table table-sm table-bordered text-center'>";
		
		$THead = "<thead class=''><tr><th>Data</th><th>Qtd Logins</th><th>Entrada</th><th>Saida</th><th>Tempo</th><th>Nome</th><th>Equipe</th></tr></thead>";
		
		$TBody = "<tbody><tr class=''>";
		
		if(!empty($Lista)){
			foreach($Lista as $Key => $Value){
				$TBody .= "<td>".$Value['Data']."</td>";
				$TBody .= "<td>".$Value['Qtd']."</td>";
				$TBody .= "<td>".$Value['Entrada']."</td>";
				$TBody .= "<td>{$Value['Saida']}</td>";
				$TBody .= "<td>". substr(ToHora(strtotime($Value['Saida']) - strtotime($Value["Entrada"])), 0,  -3) ."</td>";
				$TBody .= "<td>{$Value['Nome_user']}</td>";
				$TBody .= "<td>{$Value['desc_equipe']}</td></tr>";
			}
		}

		$Tabela .= $THead.$TBody."</tbody></table>";
	}
?>

<div class='card mb-2'>
	<div class='card-body'>
		<h4>Relatório de Login de operador</h4>
		<form class='form-row' method='POST'>
			<div class='form-group col-sm'>
				<label>Data Ate:</label>
				<input class='form-control' type='date' name='DataDe' required value='<?php echo (!empty($_POST['DataDe'])) ? $_POST['DataDe'] : '';?>'>
			</div>
			
			<div class='form-group col-sm'>
				<label>Data Até:</label>
				<input class='form-control' type='date' name='DataAte' required value='<?php echo (!empty($_POST['DataAte'])) ? $_POST['DataAte'] : '';?>'>
			</div>
			
			<div class="form-group col-sm">
				<label>Equipe</label>
				<select class="form-control" id="idequipe" name="idequipe" required>
					<option disabled selected  >selecione</option> 
					<?php
						foreach($Equipe as $Values){
							$sel = ($Values['id_equipe'] == $_POST['idequipe']) ? 'selected' : '';
							if($_SESSION['Usuario']['Nivel_user'] != '5'){
								echo "<option value='{$Values['id_equipe']}' $sel>{$Values['desc_equipe']}</option>";
							}else if($Values['id_equipe'] == 5){
								echo "<option value='{$Values['id_equipe']}' $sel>{$Values['desc_equipe']}</option>";
							}
						}
					
					?>
				</select>
			</div>
		
			<div class='form-group col-sm'>
				<label class='text-white'>.</label>
				<button class='form-control btn btn-primary' name='Aplicar'>Aplicar</button>
			</div>
		</form>
	</div>
</div>
	
<div class='card'>
	<div class='card-body' id='Tabela'>
		<?php if(!empty($Tabela)){ ?>
		<form method='POST' action='/KoalaCRM/_app/views/Relatorios/Exportar.php/?r=Relatorio_de_Acionamentos'>
			<div class='form-row justify-content-between'>
				<div class='form-group col-sm-3'>
					<label class='font-weight-bold'>Período de: </label>
					<span><?php echo  date("d/m/Y", strtotime($_POST['DataDe']))?></span>
				</div>	
				
				<div class='form-group col-sm-3'>
					<label class='font-weight-bold'>Período Até: </label>
					<span><?php echo date("d/m/Y", strtotime($_POST['DataAte']))?></span>
				</div>
				
				<div class='form-group col-sm-3'>
					<label class='font-weight-bold'>Quantidade: </label>
					<span><?php echo number_format((!empty($Lista)) ? Count($Lista) : 0, 0,',','.');?></span>
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