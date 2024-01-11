<?php
	class Sms{
		private $User;
		private $Senha;
		private $Erro;
		private $Result;
		
		private $Host;
		

		public function __Construct(){
			$Read = new Read;
			$Read->ExeRead('integrador', "WHERE tipo_int = 'sms' AND ativo_int = 1", "");
			
			$rest = ($Read->GetRowCount()>0) ? $Read->GetResult()[0] : null;
			
			$this->User = $rest['user_int'];
			$this->Senha = $rest['senha_int'];
			$this->Host = $rest['host_int'];
			
			$this->Result = false;
		}
		
		public function GetResult(){
			return $this->Result;
		}
		
		public function Enviar($para, $Mensagem) { 
			
			
			if(strlen($Mensagem) < 161){
			
				$Mensagem = str_replace(' ', '+', $Mensagem);
				$Link = $this->Host."?Usuario={$this->User}&senha={$this->Senha}&Operacao=ENVIO&Tipo=SMS&Destino=55".trim($para)."&mensagem={$Mensagem}&Rota=PREMIO";
			
				$cURL = curl_init($Link);
				curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
				$resultado = curl_exec($cURL);
				curl_close($cURL);
			
				$this->Result = "Envio SMS ". date('Y-m-d H:i:s')." Para: {$para},".PHP_EOL ."Link: {$Link}".PHP_EOL ."Texto: ". str_replace('+', ' ', trim($Mensagem))."
". strip_tags($resultado);
			}else{
				$this->Result = "Envio SMS ". date('Y-m-d H:i:s')." Para: {$para},".PHP_EOL ."Link: {$Link}".PHP_EOL ."Texto: ". str_replace('+', ' ', trim($Mensagem))."
Mensagem possui mais de 160 caracteres";
			}
		}
	}
?>