<?php
	class Produtos{
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
				$this->Read->ExeRead('Produto', "WHERE Id_prod IN (".$Id.")");
			}else{
				$this->Read->ExeRead('Produto');
			}

			if($this->Read->GetRowCount()>0){
				$this->Result = $this->Read->GetResult();
				$this->Erro = false;
			}else{
				$this->Erro = array ('Sem resultado para exibir!', INFO);
			}
		}
		
		public function NovoProduto($Dados){
			if(!empty($Dados['desc_prod'])){
				$this->Read->ExeRead('Produto', "WHERE desc_prod = :desc", "desc={$Dados['desc_prod']}");
				if($this->Read->GetRowCount() == 0){
					$this->Insert->ExeCreate('Produto', $Dados);
					if($this->Insert->GetResult()){
						$this->Result = $this->Insert->GetResult();
						$this->Erro = false;
					}else{
						$this->Erro = array ('Não foi possível cadastrar o produto!', ERRO);
					}
				}else{
					$this->Erro = array ('Produto já cadastrado!', ERRO);
				}
			}else{
				$this->Erro = array ('Gentileza preeencher o campo de descrição!', ERRO);
			}
		}
		
		public function AlterarProduto($Id, $Dados){
			if(!empty($Dados['desc_prod'])){
				$this->Read->ExeRead('Produto', "WHERE desc_prod = :desc", "desc={$Dados['desc_prod']}");
				if($this->Read->GetRowCount() == 0){
					$this->Update->ExeUpdate('Produto', $Dados, "WHERE id_prod = :id", "id={$Id}");
					if($this->Update->GetResult()){
						$this->Result = $this->Insert->GetResult();
						$this->Erro = false;
					}else{
						$this->Erro = array ('Não foi possível cadastrar o produto!', ERRO);
					}
				}else{
					$this->Erro = array ('já existe um produto cadastrado com esta descrição!', ERRO);
				}
			}else{
				$this->Erro = array ('Gentileza preeencher o campo de descrição!', ERRO);
			}
		}
		
		
	}
	
?>