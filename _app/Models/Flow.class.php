<?php
	class Flow{
		
		public $Result;
		public $Erro;
		public $Dados;
		Private $Flow;
		
		public function Exec(){
			$DataDe = date("Y-m-d H:i:s", strtotime('-10 minute'));
			$DataAte = date("Y-m-d H:i:s", strtotime('+10 minute'));
			
			$Read = new Read;
			
			$Read->ExeRead("Flow LEFT JOIN Conexao_Flow ON IdCon_Flow = Id_Con LEFT JOIN Api ON IdApi_Flow = Id_Api", "WHERE ProxExec_Flow BETWEEN :DataDe AND :DataAte", "DataDe={$DataDe}&DataAte={$DataAte}");
			
			if($Read->GetRowCount()>0){
				foreach($Read->GetResult() as $Values){
					if($this->Conn($Values)){
						$this->LinkFor($Values);
					
					
						if($Values['Rotina_Flow'] == 'D'){
							$Up['UltExec_Flow'] = date("Y-m-d H:i:s");
							$Up['ProxExec_Flow'] = date("Y-m-d H:i:s", strtotime('+ 1 days', strtotime($Values['ProxExec_Flow'])));
						}else if($Values['Rotina_Flow'] == 'S'){
							$Up['UltExec_Flow'] = date("Y-m-d H:i:s");
							$Up['ProxExec_Flow'] = date("Y-m-d H:i:s", strtotime('+ 7 days', strtotime($Values['ProxExec_Flow'])));
						}else if($Values['Rotina_Flow'] == 'M'){
							$Up['UltExec_Flow'] = date("Y-m-d H:i:s");
							$Up['ProxExec_Flow'] = date("Y-m-d H:i:s", strtotime('+ 30 days', strtotime($Values['ProxExec_Flow'])));
						}else{
							$Up['UltExec_Flow'] = date("Y-m-d H:i:s");
							$Up['ProxExec_Flow'] = $Values['ProxExec_Flow'];
						}

						$Update = new Update;
						
						$Update->ExeUpdate('Flow', $Up, 'WHERE Id_Flow = :Id', "Id={$Values['Id_Flow']}");
					}
				}
				
			}
			
			Debug($Read->GetRowCount());
			Debug($this->Erro);
			Debug($this->Dados);
		}
		
		private function Conn($Conn){
			Debug($Conn);
			
			$Read = new Read;
			
			$dbhost = $Conn['Host_Con'];  #Nome do host
			$db = $Conn['NomeBanco_Con']; #Nome do banco de dados
			$user = $Conn['Usuario_Con']; #Nome do usuário
			$password = base64_decode($Conn['Senha_Con']);   #Senha do usuário

			if(!$Conn['TipoBanco_Con']){
				$Read->FullRead($Conn['Query_Flow']);
				
				if($Read->GetRowCount()>0){
					$this->Dados = $Read->GetResult();
				}
			
			}else if($Conn['TipoBanco_Con'] == 'MySQL'){
				$MysqlCon = new mysqli($dbhost, $user, $password, $db);
			
				if($MysqlCon->connect_error){
					$this->Erro = "Não foi possivel conectar no banco de dados.";
				}else{
					$query = $MysqlCon->query($Conn['Query_Flow']);
					
					while ($Row = $query->fetch_assoc()){
						$this->Dados[] = $Row;
					}
				}
			}else if($Conn['TipoBanco_Con'] == 'mssql'){
				$conninfo = array("Database" => $db, "UID" => $user, "PWD" => $password);
				$Conexao = sqlsrv_connect($dbhost, $conninfo);
				
				if($Conexao){
					$params = array();
					$options =array("Scrollable" => SQLSRV_CURSOR_KEYSET);
					$consulta = sqlsrv_query($Conexao, $Conn['Query_Flow'], $params, $options);
					$numRegistros = sqlsrv_num_rows($consulta);
					
					if ($numRegistros!=0){			
						while($Row = sqlsrv_fetch_array($consulta, SQLSRV_FETCH_ASSOC)){
							$this->Dados[] = $Row;
						}
						
						//Debug($numRegistros);
					}
				}else{
					$this->Erro = "Não foi possivel conectar no banco de dados.";
				}
			}
			
			if(!$this->Erro){
				return true;
			}else{
				return false;
			}
		}
	
		private function LinkFor($Dados){
			$Dados['Variaveis_Api'] = str_replace('[Usuario]', $Dados['Usuario_Api'], $Dados['Variaveis_Api']);
			$Dados['Variaveis_Api'] = str_replace('[Senha]', base64_decode($Dados['senha_Api']), $Dados['Variaveis_Api']);
			
			
			foreach($this->Dados as $Conteudo){
				$Back = $Dados['Variaveis_Api'];
				
				$Dados['Variaveis_Api'] = str_replace('[Telefone]', $Conteudo['Telefone'], $Dados['Variaveis_Api']);
				
				//$Dados['Texto_Flow'] = str_replace('[Nome_Pes]', $Conteudo['Nome_Pes'], $Dados['Texto_Flow']);
				//$Dados['Texto_Flow'] = str_replace(' ', '%20', $Dados['Texto_Flow'] );
				
				$Texto =  $this->VarTexto($Dados['Texto_Flow'], $Conteudo);
				
				$Dados['Variaveis_Api'] = str_replace('[Texto]', $Texto, $Dados['Variaveis_Api']);
				
				$Link = $Dados['Host_Api']."?".$Dados['Variaveis_Api'];
				
				// Aqui entra o action do formulário - pra onde os dados serão enviados
				$cURL = curl_init($Link);
				curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
				$resultado = curl_exec($cURL);
				curl_close($cURL);
				
				$Log['Idflow_Log'] = $Dados['Id_Flow'];
				$Log['IdCon_Log'] = $Dados['IdCon_Flow'];
				$Log['IdApi_Log'] = $Dados['IdApi_Flow'];
				$Log['Texto_Log'] = str_replace('%20', ' ', $Texto);
				$Log['RespApi_Log'] = $resultado;
				$Log['Link_Log'] = $Link;
				$Log['Erro_Log'] = $this->Erro;
				$Log['VariaveisApi_Log'] = $Dados['Variaveis_Api'];
				
				$Create = new Create;
				
				$Create->ExeCreate('Log', $Log);
				
				$Dados['Variaveis_Api'] = $Back;
			}
			
			$this->Dados = array();
		}
		
		private function VarTexto($Texto, $Variaveis){
			
			if(!empty($Variaveis['Nome_Pes'])) $Texto = str_replace('[Nome_Pes]', $Variaveis['Nome_Pes'], $Texto);
			if(!empty($Variaveis['Nome'])) $Texto = str_replace('[Nome]', $Variaveis['Nome'], $Texto);
			if(!empty($Variaveis['PNome'])) $Texto = str_replace('[PNome]', $Variaveis['PNome'], $Texto);
			if(!empty($Variaveis['LinhaD'])) $Texto = str_replace('[LinhaD]', $Variaveis['LinhaD'], $Texto);
			if(!empty($Variaveis['DtVen'])) $Texto = str_replace('[DtVen]', $Variaveis['DtVen'], $Texto);
			if(!empty($Variaveis['Carteira'])) $Texto = str_replace('[Carteira]', $Variaveis['Carteira'], $Texto);
			if(!empty($Variaveis['Valor'])) $Texto = str_replace('[Valor]', $Variaveis['Valor'], $Texto);
			
			
			$Texto = str_replace(' ', '%20', $Texto);
			
			return($Texto);
			
		}

	}
?>