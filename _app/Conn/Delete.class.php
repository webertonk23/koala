<?php
	class Delete extends Conn {
		
		private $Tabela;
		private $Termos;
		private $Places;
		private $Resultado;
		
		private $Delete;
		
		private $Conn;
		
		
		public function ExeDelete($Tabela, $Termos, $ParseString){
			$this->Tabela = (string) $Tabela;
			$this->Termos = (string)$Termos;
			
			parse_str($ParseString, $this->Places);
						
			$this->GetSintax();
			$this->Execute();
		}
		
		public function GetResult(){
			return $this->Resultado;
		}
		
		public function GetRowCount(){
			return $this->Delete->rowCount();  
		}
		
		public function SetPlaces($ParseString){
			parse_str($ParseString, $this->Places);
			$this->GetSintax();
			$this->Execute();
		}

		//Metodos Privados
		
		private function Connect(){
			$this->Conn = parent::GetConn();
			$this->Delete = $this->Conn->prepare($this->Delete);
		}
		
		private function GetSintax(){
			$this->Delete = "DELETE FROM {$this->Tabela} {$this->Termos}";
		}
		
		private function Execute(){
			$this->Connect();
				$this->Delete->Execute($this->Places);
				$this->Resultado = True;
			try{
				
				
			}catch (PDOException $ex){
				PHPErro($ex->getCode(), $ex->getMenssage(), $ex->getFile(), $ex->getLine());
			}
		}
	}

?>