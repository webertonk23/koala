<?php
	
	class Read extends Conn {
		
		private $Select;
		private $Places;
		private $Resultado;
		private $Erro;
		
		private $Read;
		
		private $Conn;
		
		
		public function ExeRead($Tabela, $Termos = Null, $ParseString = Null){
			if(!empty($ParseString)):
				parse_str($ParseString, $this->Places);
			endif;
			
			$this->Select = "SELECT * FROM {$Tabela} {$Termos}";
			$this->Execute();
		}
		
		public function GetResult(){
			return $this->Resultado;
		}
		
		public function GetErro(){
			return $this->Erro;
		}
		
		public function GetRowCount(){
			return $this->Read->rowCount();  
		}
		
		public function FullRead($Query, $ParseString = Null){
			$this->Select = (string) $Query;
			if(!empty($ParseString)):
				parse_str($ParseString, $this->Places);
			endif;
			
			$this->Execute();
		}
		
		public function SetPlaces($ParseString){
			parse_str($ParseString, $this->Places);
			$this->Execute();
		}

		//Metodos Privados
		
		private function Connect(){
			$this->Conn = parent::GetConn();
			$this->Read = $this->Conn->prepare($this->Select);
			$this->Read->setFetchMode(PDO::FETCH_ASSOC);
		}
		
		private function GetSintax(){
			if($this->Places):
				foreach($this->Places as $Vinculo => $Valor):
					if($Vinculo == 'limit' || $Vinculo == 'offset'):
						$Valor = (int) $Valor;
					endif;
					
					$this->Read->bindValue(":{$Vinculo}", $Valor, (is_int($Valor)? PDO::PARAM_INT : PDO::PARAM_STR));
				endforeach;
			endif;
		}
		
		private function Execute(){
			$this->Connect();
			
			try{
				$this->GetSintax();
				$this->Read->Execute();
				$this->Resultado = $this->Read->fetchAll();
				$this->Erro = 0;
			}catch (PDOException $ex){
				PHPErro($ex->getCode(), $ex->getMessage(), $ex->getFile(), $ex->getLine());
				$this->Erro = 1;
			}
		}
	}

?>