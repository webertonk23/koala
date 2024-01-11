<?php
	class Create extends Conn {
		
		private $Tabela;
		private $Dados;
		private $Resultado = 0;
		
		private $Create;
		
		private $Conn;
		
		
		public function ExeCreate($Tabela, array $Dados){
			$this->Tabela = (string) $Tabela;
			$this->Dados = $Dados;
			
			$this->GetSintax();
			$this->Execute();
		}

		public function GetResult(){
			return $this->Resultado;
		}

		//Metodos Privados
		
		private function Connect(){
			$this->Conn = parent::GetConn();
			$this->Create = $this->Conn->prepare($this->Create);
		}
		
		private function GetSintax(){
			$Fields = implode(', ', array_keys($this->Dados));
			$Places = ':'.implode(', :', array_keys($this->Dados));
			$this->Create = "INSERT INTO {$this->Tabela} ({$Fields}) VALUES ({$Places})";
		}
		
		private function Execute(){
			$this->Connect();
			
			try{
				$this->Create->execute($this->Dados);
				$this->Resultado = $this->Conn->lastInsertId();
			}catch (PDOException $ex){
				PHPErro($ex->getCode(), $ex->getMessage(), $ex->getFile(), $ex->getLine());
				var_dump($this->Create);
				var_dump($this->Dados);
			}
		}
	}

?>