<?php
	class ControleRealiza{
		

		private function SetResult ($Tipo, $Msg){
			$this->Resultado = "<div class='alert alert-$Tipo alert-dismissible text-center' role='alert'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
										<span aria-hidden='true'>&times;</span>
									</button>
									$Msg
								</div>";
		}
		
		Public function GetResult (){
			return $this->Resultado;
		}		
		
		
		function Realizar(array $Dados, array $Respostas){
			
			
			$Verifica = new Read;
			$Verifica->ExeRead('MonitoriaRealizada', 'WHERE Id_Chamada = :Id_Chamada AND id_avaliador = :Id_Avaliador', "Id_Chamada={$Dados['Id_Chamada']}&Id_Avaliador={$Dados['Id_Avaliador']}");
			if($Verifica->GetRowCount()>0){
				$this->SetResult("danger", "Avaliação já realizada por você para esta chamada!");
			}else{
				$Salvar = new Create;
				$Salvar->ExeCreate('MonitoriaRealizada', $Dados);
				
				$RespostaSalvar = clone($Salvar);
				
				if($Salvar->GetResult()>0){
					$Verifica->ExeRead("MonitoriaPerguntas", "WHERE Id_Avaliacao = :Id_Avaliacao AND Ativo = 1", "Id_Avaliacao={$Dados['Id_Av']}");
					if($Verifica->GetRowCount()>0){
						$Certas = 0;
						$Total = 0;
						
						$Coringa = 0;
						
						foreach($Verifica->GetResult() as $Key => $Value){
							if(!isset($Respostas[$Value['Id_Itens']])){
								$Respostas[$Value['Id_Itens']] = '0';
							}
							
							if($Respostas[$Value['Id_Itens']] == $Value['Resposta']){
								$Certas += 1;
							}elseif($Value['Coringa']){						
								$Coringa += $Value['Peso'];
								$Certas += 1;
							}
							
							$Total += 1;
						}
						
						$Resultado['Nota'] = (($Certas/$Total)*100)-$Coringa;
						
						$Resultado['Nota'] = ($Resultado['Nota']<0) ? 0 : $Resultado['Nota'];
						
						$SalvaNota = new Update;
						
						$SalvaNota->ExeUpdate('MonitoriaRealizada', $Resultado, "WHERE Id_R = :Id_R", "Id_R={$Salvar->GetResult()}");
						
						foreach($Respostas as $Key => $Value){
							$Resposta['Id_Pergunta']= $Key;
							$Resposta['Resposta']= $Value;
							$Resposta['Id_Realizado'] = $Salvar->GetResult();

							$RespostaSalvar->ExeCreate("MonitoriaRespostas", $Resposta);
						}
						
						$this->SetResult("success", "Avaliação Salva com sucesso! <b>NOTA: ".number_format($Resultado['Nota'], 2, ',', '')."%");
					}
				}
				
			}
		}
		
		public function Apagar ($Id){
			$Delete = new Delete;
			$Delete->ExeDelete('MonitoriaRespostas', "WHERE Id_Realizado = :Id", "Id={$Id}");
			if($Delete->GetResult()){
				$Delete->ExeDelete('MonitoriaRealizada', "WHERE Id_R = :Id", "Id={$Id}");	
				if($Delete->GetResult()){
					$this->SetResult("success", "Registo <b>{$Id}</b> Deletado com sucesso!");
				}
			}
		}
	}