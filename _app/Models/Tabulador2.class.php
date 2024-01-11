<?php
	class Tabulador2{
		
		public $Result;
		public $Erro;
		
		public function SetItens($Dados = null){			
			$Dados = $Dados;
		}
		
		
		private function GetTabulacao($IdTab = int){
			$Read = new Read;
			$Read->ExeRead('tabulacao', "WHERE id_tab = :Id", "Id={$IdTab}");
			
			return ($Read->GetRowCount() > 0) ? $Read->GetResult()[0] : null;
		}
		
		public function GetTabIsdn($Isdn = int){
			$Read = new Read;
			$Read->ExeRead('tabulacao', "WHERE Isdn_tab = :Id", "Id={$Isdn}");
			
			//var_dump($Read->GetResult());
			
			return ($Read->GetRowCount() > 0) ? $Read->GetResult()[0]['Id_tab'] : 0;
		}
		
		public function IncHistorico($IdPes, $IdTab, $IdTel = null, $IdUser = null, $IdFicha = null, $DtOco = null, $Obs = null, $CallId = null, $IdDisc = null, $DigRet = null, $Tipo = null){
			$Check = new Check();
			
			$Create = new Create;
			$Dados['IdPes_hist'] = $IdPes;
			$Dados['IdTab_hist'] = $IdTab;
			$Dados['Tipo_hist'] = $Tipo;
			$Dados['DtOco_hist'] = ($DtOco) ? $DtOco : date("Y-m-d H:i:s");
			
			if(!empty($IdUser)){
				$Dados['IdUser_hist'] = $IdUser;
			}
			
			if(!empty($IdFicha)){
				$Dados['IdFicha_hist'] = $IdFicha;
			}
			
			if(!empty($Obs)){
				$Dados['Obs_hist'] = str_replace(" Br ", "<br>", $Check->Name($Obs));
			}
			
			if(!empty($IdTel)){
				$Dados['IdTel_hist'] = $IdTel;
			}
			
			if(!empty($CallId)){
				$Dados['IdDisc_hist'] = $CallId;
			}

			if(!empty($IdDisc)){
				$Dados['IdDiscFila_hist'] = $IdDisc;
			}

			if(!empty($DigRet)){
				$Dados['DigUraRet_hist'] = $DigRet;
			}

			$Create->ExeCreate("Historico", $Dados);
			
			$Tab = $this->GetTabulacao($IdTab);
			if(!empty($IdFicha)){
				$this->AtualizaFicha($IdFicha, $IdTab, $Dados['DtOco_hist'], $IdPes);
			}
			
		}
		
		private function AtualizaFicha($IdFicha, $IdTab, $DtOco = null, $IdPes = null){
			$Update = new Update;
			$Read = new Read;
			$Tab = $this->GetTabulacao($IdTab);
			
			if($IdFicha){
				$Read->ExeRead("Fichas LEFT JOIN tabulacao ON IdTab_ficha = Id_tab", "WHERE Id_ficha = :Id AND Final_ficha = 0", "Id={$IdFicha}");
							
				$DtOco = ($DtOco) ? $DtOco : date("Y-m-d H:i:s");
				
				Debug($Read);
				Debug($Tab);
				Debug($Read->GetRowCount());
				
				
				if($Read->GetRowCount() > 0){
					if($Tab['Origem_tab'] == 'Operador'){ 
						$Dados['DtUltacio_ficha'] = $DtOco;
						$Dados['DtProxAcio_ficha'] = date("Y-m-d H:i:s", strtotime("+ {$Tab['Agendamento_tab']} Seconds", strtotime($Dados['DtUltacio_ficha'])));
						$Dados['UltTab_ficha'] = $Tab['Tabulacao_tab'];
						$Dados['IdTab_ficha'] = $Tab['Id_tab'];
						$Dados['Final_ficha'] = $Tab['Finaliza_tab'];
					}else if($Read->GetResult()[0]['Origem_tab'] != 'Operador'){
						$Dados['DtUltacio_ficha'] = $DtOco;
						$Dados['DtProxAcio_ficha'] = date("Y-m-d H:i:s", strtotime("+ {$Tab['Agendamento_tab']} Seconds", strtotime($Dados['DtUltacio_ficha'])));
						$Dados['UltTab_ficha'] = $Tab['Tabulacao_tab'];
						$Dados['IdTab_ficha'] = $Tab['Id_tab'];
						$Dados['Final_ficha'] = $Tab['Finaliza_tab'];
					}else{
						if(date("Y-m-d H:i:s", strtotime("+ {$Tab['Agendamento_tab']} Seconds", strtotime($DtOco))) > $Read->GetResult()[0]['DtProxAcio_Ficha']){
							$Dados['DtProxAcio_ficha'] = date("Y-m-d H:i:s", strtotime("+ {$Tab['Agendamento_tab']} Seconds", strtotime($DtOco)));
						}
					}
					
					Debug($Dados);
					
					if(!empty($Dados)){
						$Update->ExeUpdate("Fichas", $Dados, "WHERE Id_ficha = :IdFicha", "IdFicha={$IdFicha}");
					}
				}
			}
		}
	}


?>