<?php
	class TrataXml{
		
		public $Result;
		public $Erro;
		public $Dados;
		public $Dir = "./Retorno/";
		
		public function SetItens(){
			$Update = new Update;
			$Inert = new Create;
			$Check = new Check;
			$Tab = new Tabulador();
			
			$diretorio = dir($this->Dir);
		
			while($arquivo = $diretorio -> read()){
				if(substr($arquivo,-4) == ".xml"){
					$tamanho = ((filesize($this->Dir.$arquivo)/1024) > 1) ? round((filesize($this->Dir.$arquivo)/1024), 2)." KB " : round(((filesize($this->Dir.$arquivo)/1024)/1024), 2)." MB ";
					
					$xml = simplexml_load_file($this->Dir.$arquivo);
					
					foreach($xml as $v){
						$post['status_filad'] = $v['status'];
						$post['DtRet_filad'] = date("Y-m-d H:i:s");
						
						$Update->ExeUpdate('FilaDiscador', $post, "WHERE idpes_filad = :IdPes AND descfila_filad = :DescFila AND status_filad IS NULL", "IdPes=".explode("-", $v['id'])[0]."&DescFila={$v['queue']}");
						
						foreach($v as $a){
							if($a != 0){
								//Debug($a);
								if($a == 1){
									$Update->ExeUpdate(
										"telefones",
										array('status_tel' => -1),
										"WHERE id_tel = :IdTel AND status_tel = 0",
										"IdTel={$a['id']}"
									);
								}
								
								$Ret = (!empty($a['ivr_digit'])) ? (int) $a['ivr_digit'] : null;
								
								$Tab->IncHistorico(
									explode("-", $v['id'])[0],
									$Tab->GetTabIsdn($a),
									(int) $a['id'],
									null,
									(!empty(explode("-", $v['id'])[1])) ? explode("-", $v['id'])[1] : null,
									date("Y-m-d H:i:s", strtotime($Check->DataI2($a['dialed_at']))),
									"Retorno de discador<br>numero: {$a['destination']}<br>Arquivo: {$a['callfilename']}",
									str_replace(".WAV", "", $a['callfilename']),
									(string) $v['queue'],
									$Ret
								);
							}
						}
					}
					
					rename($this->Dir.$arquivo, $this->Dir."Tratados/".$arquivo);
					echo $arquivo.": ". $tamanho . "Tempo de execução: ".ToHora(time() - $_SERVER['REQUEST_TIME']). "<br>";
					break;
				}
			}
			$diretorio -> close();
			
		}
		
	}


?>