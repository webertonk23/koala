<?php
	//set_time_limit(5);
	
	if(!empty($_POST['Incluir'])){
		$Tab = new Tabulador2();
		$Create = new Create();
		$Read = new Read;
		$sms = new sms;
		
		if($_POST['Incluir'] == 'Incluir Registro'){
			if(!empty($_POST['Data_Ret'])){
				$Ret = array(
					'Data_Ret' => str_replace("T", " ", $_POST['Data_Ret']),
					'IdPes_Ret' => $_POST['IdPes'],
					'IdFicha_Ret' => $_POST['IdFicha'],
					'IdUser_Ret' => $_POST['IdUser'],
					'Motivo_Ret' => $_POST['Obs']
				);
				
				$Create->ExeCreate('Retornos', $Ret);
			}
			
			$Tab->IncHistorico($_POST['IdPes'], $_POST['IdTab'], $_POST['IdTel'], $_POST['IdUser'], $_POST['IdFicha'], null, $_POST['Obs'], $_POST['Call_Id'], (!empty($_POST['Fila'])) ? $_POST['Fila'] : null, null, $_POST['Tipo']);
			
			// Debug($_POST);
			// $IdPes, $IdTab, $IdTel = null, $IdUser = null, $IdFicha = null, $DtOco = null, $Obs = null, $CallId = null
			
			$Read->ExeRead('telefones', "WHERE tipo_tel = 'c' and status_tel = 1 and id_tel = :id", "id={$_POST['IdTel']}");
			$tel = ($Read->GetRowCount()>0) ? $Read->GetResult()[0]['ddd_tel'].$Read->GetResult()[0]['Telefone_tel'] : null;
			
			$Read->ExeRead('tabulacao INNER JOIN PerfilSms ON idperfsms_tab = id_perf', 'WHERE id_tab = :id', "id={$_POST['IdTab']}");
			
			// if(!empty($Read->GetResult()[0]['texto_perf']) and !empty($tel)){
				// $sms->Enviar($tel, $Read->GetResult()[0]['texto_perf'] );
			// }
			
			if($_POST['Tipo'] == 'R'){
				echo "<script> window.location.replace('?p=Atendimento/Receptivo') </script>";
			}else if($_POST['Tipo'] == 'A'){
				echo "<script> window.location.replace('?p=Atendimento/Ativo') </script>";
			}else if($_POST['Tipo'] == 'Rt'){
				echo "<script> window.location.replace('?p=Atendimento/Retornos') </script>";
			}
		}
	}

?>