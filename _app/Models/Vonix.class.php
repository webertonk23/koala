<?php
	class Vonix{
		
		public $Result;
		public $Erro;
		public $Dados;
		public $cURL;
		public $Link;
		
		public function SetItens(){
			$this->SetLink();
			$this->cURL = curl_init();
			curl_setopt($this->cURL, CURLOPT_USERPWD, "koala:n3jVls@q");
			curl_setopt($this->cURL, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($this->cURL, CURLOPT_POST, true);
			
		}
		
		public function SetLink($Sub = null, $Ext = null){
			$Ext = ($Ext) ? $Ext : '';
			
			$this->Link = "http://10.20.10.220:8003/{$Ext}";
			$this->Link = ($Sub != null) ? str_replace(":8003", "", $this->Link) : $this->Link;

		}
		
		//Recupera pilha de contatos realizados discagem e o resultado da discagem.
		public function GetResultFila(){
			$Link = $this->Link."results";
			curl_setopt($this->cURL, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($this->cURL, CURLOPT_URL, $Link );
			
			$this->Result = curl_exec($this->cURL);
			$info = curl_getinfo($this->cURL);
			//var_dump($info);
			
			$Arquivo = "Retorno/".date("YmdHis").".xml";
			
			$this->Result;
			
			if($info['size_download'] > 68){	
				$fp = fopen($Arquivo, 'w+');
				fwrite($fp, $this->Result);
				fclose($fp);
			}else{
				echo "Retornos vaizios!";
			}
		}
		
		//Envia Contatos para o discador vonix
		public function SendFicha($fila, $Contato = array()){
			$c = "[";
			
			foreach($Contato as $Values){
				$c .= json_encode($Values).",";
			}
			
			$c = substr($c, 0, -1);
			
			$c .= "]";
			
			// $Contato = json_encode($Contato);
			
			$headers = array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($c)
			);
			
			curl_setopt($this->cURL, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($this->cURL, CURLOPT_CUSTOMREQUEST, "POST");
			$Link = $this->Link."contacts/{$fila}";
			curl_setopt($this->cURL, CURLOPT_URL, $Link );
			curl_setopt($this->cURL, CURLOPT_POST, true);
			curl_setopt($this->cURL, CURLOPT_POSTFIELDS, $c);
			
			//Debug($c);
			
			$this->Result = curl_exec($this->cURL);
			$info = curl_getinfo($this->cURL);
			//echo "Up: ".round(($info["speed_upload"] / 1024),2)." MB/s";
			if($info['http_code'] != 200){
				$resposta = "Http Code: <span class='text-danger'>".$info['http_code']."</span><br>".$this->Result;
			}else{
				$resposta = $this->Result;
			}
			return $resposta;
		}
		
		//Deslogar agente
		public function DeslogarAgent(){
			$this->SetLink('callcenter', "api/agent/{$_SESSION['Usuario']['Agent_user']}/logoff");
			$Link = $this->Link;
			curl_setopt($this->cURL, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($this->cURL, CURLOPT_URL, $Link );
			
			$this->Result = curl_exec($this->cURL);
			$info = curl_getinfo($this->cURL);
		}
		
		//Logar agente
		public function LogarAgent($R){
			$this->SetLink('callcenter', "api/agent/{$_SESSION['Usuario']['Agent_user']}/login");
			$Link = $this->Link;
			$Ramal['location'] = $R;
			
			curl_setopt($this->cURL, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($this->cURL, CURLOPT_POSTFIELDS, $Ramal);
			curl_setopt($this->cURL, CURLOPT_URL, $Link );
			
			$this->Result = curl_exec($this->cURL);
			$info = curl_getinfo($this->cURL);
		}
		
		//Pausar Agente
		public function PausaAgent($CodPausa){
			$this->SetLink('callcenter', "api/agent/{$_SESSION['Usuario']['Agent_user']}/pause");
			$Link = $this->Link;
			
			$Pausa['reason_id'] = $CodPausa;
			
			curl_setopt($this->cURL, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($this->cURL, CURLOPT_POSTFIELDS, $Pausa);
			curl_setopt($this->cURL, CURLOPT_URL, $Link );
			
			$this->Result = curl_exec($this->cURL);
			$info = curl_getinfo($this->cURL);
			
		}
		
		//Despausar Agente
		public function DespausaAgent(){
			$this->SetLink('callcenter', "api/agent/{$_SESSION['Usuario']['Agent_user']}/unpause");
			$Link = $this->Link;
			
			curl_setopt($this->cURL, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($this->cURL, CURLOPT_URL, $Link );
			
			$this->Result = curl_exec($this->cURL);
			$info = curl_getinfo($this->cURL);
			
		}
		
		//Ver estado do agent
		public function GetStatusAgent($Agent = null){
			$Agent = ($Agent) ? $Agent : $_SESSION['Usuario']['Agent_user'];
			
			$this->SetLink('callcenter', "api/agent/{$Agent}/status.json");
			$Link = $this->Link;
			
			curl_setopt($this->cURL, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($this->cURL, CURLOPT_URL, $Link );
			
			$this->Result = curl_exec($this->cURL);
			$info = curl_getinfo($this->cURL);
		}
		
		public function GetStatusFila($Fila){
			$Link = $this->Link."queue/{$Fila}/status";
			
			curl_setopt($this->cURL, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($this->cURL, CURLOPT_URL, $Link );
			
			$this->Result = json_decode(json_encode(simplexml_load_string(curl_exec($this->cURL))),true);
			$info = curl_getinfo($this->cURL);
		}
		
		public function GetResumoAgent($Agent = null){
			$Agent = ($Agent) ? $Agent : $_SESSION['Usuario']['Agent_user'];
			
			$this->SetLink('callcenter', "api/agent/{$Agent}/summary.json");
			$Link = $this->Link;
			
			curl_setopt($this->cURL, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($this->cURL, CURLOPT_URL, $Link );
			
			$this->Result = curl_exec($this->cURL);
			$info = curl_getinfo($this->cURL);
			
			$this->Result = json_decode($this->Result);
		}
		
		//Deletar um contato da fila
		public function RemoveFicha($Id = int){
			$Link = $this->Link."contact/{$Id}";
			curl_setopt($this->cURL, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($this->cURL, CURLOPT_URL, $Link );
			
			$this->Result = curl_exec($this->cURL);
			$info = curl_getinfo($this->cURL);
			
			return($this->Result);
		}
	
		//Deletar um contato da fila
		public function LimparFila($Fila){
			$Link = $this->Link."contacts/{$Fila}";
			curl_setopt($this->cURL, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($this->cURL, CURLOPT_URL, $Link );
			
			$this->Result = curl_exec($this->cURL);
			$info = curl_getinfo($this->cURL);
			//var_dump($info);
			return($this->Result);
		}
	}
?>