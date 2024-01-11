<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="Weberton Kaic">
		<meta http-equiv="refresh" content="15">
		
		
		<!-- Bootstrap core CSS -->
		
		<link href="../bootstrap-4.4.1/css/bootstrap.min.css" rel="stylesheet">
		
		<!--external css-->
		<link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
		
		<!-- Custom styles for this template -->
		<link href="../css/style2.css" rel="stylesheet">
		
		
		<script src="../lib/vonix-1.6.min.js"></script>
		
		<link href="../css/switch.css" rel="stylesheet" media="screen">
				
		<title>Koala CRM - Grupo Asa (Alimentador)</title>
	</head>
	
	<body class="row justify-content-md-center">
		<br>
		<div class='card col-sm-8'>
			<div class='card-head'>
			
			</div>
			<div class='card-body'>
				<?php
					set_time_limit(6000);
					require('../_app/Config.inc.php');
					
					if(date("H") >= 22){
						require('./Delete.php');
					}elseif(date("H") >= 7 OR date("H") <= 21){
					
						$Read = new Read;
						$Update = new Update;
						$Insert = new Create;
						//$Xml = new TrataXml;
						
						// $DtLogout['dtlogout_sess'] = date("Y-m-d H:i:s");
						
						// $Update->ExeUpdate('session', $DtLogout, "WHERE DATEDIFF(SECOND, ultacao_sess, GETDATE()) > 720 AND dtlogout_sess IS NULL", "");
						
						//$Vonix->GetResultFila();	
						
						//$Xml->SetItens();

						$Read->ExeRead("Fila", "WHERE Ativo_fila = 1 AND Discador_fila = 'Vonix' AND Cart_fila IS NOT NULL  AND Dia_fila LIKE CONCAT('%',DATEPART(weekday, GETDATE()),'%')", "");
						
						if($Read->GetRowCount() > 0){
							$Fila = $Read->GetResult();
							foreach($Fila as $Value){
								echo "<h5 class='card-title'>Fila: {$Value['Desc_fila']} - {$Value['iddisc_fila']}</h5>";
								//$Vonix->GetStatusfila($Value['iddisc_fila']);
								$Read->ExeRead("filadiscador", "WHERE status_filad IS NULL AND descfila_filad = :fila AND DATEDIFF(DAY, dtInc_filad, GETDATE()) <= :dias ", "fila={$Value['iddisc_fila']}&dias={$Value['diasEstoque_fila']}");
								//var_dump($Read);
								
								$Estoque = $Read->GetRowCount();
								//$Estoque = 0;
								
								//var_dump($Estoque);
								
								//$Estoque = (!empty($Vonix->Result["stored_contacts"])) ? $Vonix->Result["stored_contacts"] : 0;
								
								$Qtd = $Value['QtdFicha_fila'] - $Estoque;
								
								$Qtd = ($Qtd > 0) ? ($Qtd < 1000) ? $Qtd : 1000 : 0;
								
								echo "Estoque: $Estoque, Quantidade a enviar: $Qtd. <br>";
								
								$Busca = new Read;
								$IgDDD = (!empty($Value['IgnoraDDD_fila'])) ? explode(",",$Value['IgnoraDDD_fila']) : null;
								$Query = "
									SELECT
										TOP {$Qtd} CONCAT(id_pes,'-',Id_ficha) as id,
										Nome_Pes as contact_name,
										Telefones_Vw as 'to'
									FROM
										pessoas WITH (NOLOCK) INNER JOIN fichas WITH (NOLOCK) ON Id_Pes = IdPes_Ficha
										INNER JOIN fila ON IdFila_ficha = id_fila
										LEFT JOIN FilaDiscador WITH (NOLOCK) ON Id_Pes = IdPes_filad AND DescFila_filad = iddisc_fila AND Status_filad IS NULL
										INNER JOIN Vw_Telefones ON Id_pes = IdPes_Vw
									WHERE
										Final_ficha = 0
										AND IdFila_ficha = ".$Value['Id_fila']."
										AND DtProxAcio_Ficha <= GETDATE()
										AND Id_filad IS NULL
										AND Telefones_Vw IS NOT NULL
									ORDER BY DtProxAcio_Ficha ASC 
								";
								
								$Query .= (!empty($Value['Ordem_fila'])) ? ", {$Value['Ordem_fila']}" : "";
								
								// echo $Query;
								
								$Busca->FullRead($Query);
								
								$Contato = ($Busca->GetRowCount() > 0) ? $Busca->GetResult() : null;
								unset($Busca);
								
								if(!empty($Contato)){
									foreach($Contato as $Key => $Values){
										$idPes = explode("-", $Values['id'])[0];

										$fd['Idpes_filad'] = explode("-", $Values['id'])[0];
										$fd['Descfila_filad'] = $Value['iddisc_fila'];
										
										$Insert->ExeCreate('filadiscador', $fd);
										
										if($Insert->GetResult()){
											$Tel = json_decode($Values['to'], true);
											
											if(!empty($IgDDD)){
												foreach($Tel as $k => $v){
													if(in_array(substr($v['number'],0,2), $IgDDD)){
														unset($Tel[$k]);
													}
												}
											}
											
											if(!empty($Tel)){
												$Contato[$Key]['to'] = $Tel;
												$Contato[$Key]['billing_group_id'] = 1;
											}else{
												unset($Contato[$Key]);
											}
											
										}else{
											unset($Contato[$Key]);
										}
									}
								}
								
								$QtdContatos = (!$Contato) ? 0 : count($Contato);
							
								echo "<p class='card-text'>Enviado {$QtdContatos} fichas para fila</p>";
								
								$Envio = ($QtdContatos > 0) ? $Vonix->SendFicha($Value['iddisc_fila'], $Contato) : null;
								
								if($Envio){
									$Resultado = json_decode($Envio, true);
									Debug($Resultado);
									if(!empty($Resultado['status']) and $Resultado['status'] == 'imported'){
										$Not = (!empty($Resultado['not_imported_count'])) ? $Resultado['not_imported_count'] : 0;
										
										echo "<p class='card-text'>Fichas enviadas com sucesso!</p>";
										echo "<p class='card-text'>Total de fichas recebidas <b>{$Resultado['imported_count']}</b></p>";
										echo "<p class='card-text'>Total de fichas não recebidas <b>{$Not}</b></p>";
									}else{
										echo "<p class='card-text'>Erro: {$Envio}</p>";
										
										foreach($Contato as $v){
											$fd['Idpes_filad'] = explode("-", $v['id'])[0];
											$fd['Descfila_filad'] = $Value['iddisc_fila'];
											
											$Update->ExeUpdate('filadiscador', array('status_filad' => 'erro', 'dtret_filad' => date("Y-m-d H:i:s")), "WHERE idpes_filad = :idpes AND descfila_filad = :desc AND status_filad IS NULL", "idpes={$fd['Idpes_filad']}&desc={$fd['Descfila_filad']}");
										
											//Debug($Update);
										}
									}
								}
								
								echo "<hr>";
							}
							
							
						}else{
							echo "<p class='card-text'>Nada a processar na fila</p>";
						}
						
					}
							
					echo "<hr>";
					
					echo "<p class='card-text'>Tempo de processamento: ".ToHora(time() - $_SERVER['REQUEST_TIME'])."</p>";
				?>
			</div>
		</div>
	</body>
</html>