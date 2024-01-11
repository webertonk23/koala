<?php
	class Carteira{
		public $Result;
		public $Erro;
		private $Read;
		private $Insert;
		private $Update;
		
		public function GetResult(){
			return $this->Result;
		}
		
		public function GetErro(){
			return $this->Erro;
		}
		
		public function __construct(){
			$this->Erro = false;
			$this->Read = new Read;
			$this->Insert = new Create;
			$this->Update = new Update;
		}
		
		public function Listar($Id = null){
			if(!empty($Id)){
				$this->Read->ExeRead('Carteira', "WHERE Id_Cart IN (".$Id.")");
			}else{
				$this->Read->ExeRead('Carteira');
			}

			if($this->Read->GetRowCount()>0){
				$this->Result = $this->Read->GetResult();
				$this->Erro = false;
			}else{
				$this->Erro = array ('Sem resultado para exibir!', INFO);
			}
		}
		
		public function NovaCarteira($Dados){
			if(!empty($Dados['desc_cart'])){
				$this->Read->ExeRead('Carteira', "WHERE desc_cart = :desc", "desc={$Dados['desc_cart']}");
				if($this->Read->GetRowCount() == 0){
					$this->Insert->ExeCreate('Carteira', $Dados);
					if($this->Insert->GetResult()){
						$this->Result = $this->Insert->GetResult();
						$this->Erro = false;
					}else{
						$this->Erro = array ('Não foi possível cadastrar a Carteira!', ERRO);
					}
				}else{
					$this->Erro = array ('Carteira já cadastrado!', ERRO);
				}
			}else{
				$this->Erro = array ('Gentileza preeencher o campo de descrição!', ERRO);
			}
		}
		
		public function AlterarCarteira($Id, $Dados){
			if(!empty($Dados['desc_cart'])){
				$this->Read->ExeRead('Carteira', "WHERE desc_cart = :desc", "desc={$Dados['desc_cart']}");
				if($this->Read->GetRowCount() == 0){
					$this->Update->ExeUpdate('Carteira', $Dados, "WHERE id_cart = :id", "id={$Id}");
					if($this->Update->GetResult()){
						$this->Result = $this->Insert->GetResult();
						$this->Erro = false;
					}else{
						$this->Erro = array ('Não foi possível cadastrar a carteira!', ERRO);
					}
				}else{
					$this->Erro = array ('já existe uma carteira cadastrado com esta descrição!', ERRO);
				}
			}else{
				$this->Erro = array ('Gentileza preeencher o campo de descrição!', ERRO);
			}
		}
		
		
	}
	
?>