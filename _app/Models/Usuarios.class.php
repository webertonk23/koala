<?php
	class Usuarios{
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
				$this->Read->ExeRead('Usuarios', "WHERE Id_Cart IN (".$Id.")");
			}else{
				$this->Read->ExeRead('Usuarios');
			}

			if($this->Read->GetRowCount()>0){
				$this->Result = $this->Read->GetResult();
				$this->Erro = false;
			}else{
				$this->Erro = array ('Sem resultado para exibir!', INFO);
			}
		}
		
		public function NovoUsuario($Dados){
			if(!empty($Dados['Usuario_user'])){
				$this->Read->ExeRead('Usuaios', "WHERE Usuario_user = :usuario", "usuario={$Dados['Usuario_user']}");
				if($this->Read->GetRowCount() == 0){
					$this->Insert->ExeCreate('Usuaios', $Dados);
					if($this->Insert->GetResult()){
						$this->Result = $this->Insert->GetResult();
						$this->Erro = false;
					}else{
						$this->Erro = array ('Não foi possível cadastrar o usuario!', ERRO);
					}
				}else{
					$this->Erro = array ('Usuario já cadastrado!', ERRO);
				}
			}else{
				$this->Erro = array ('Gentileza preeencher o campo de Usuario!', ERRO);
			}
		}
		
		public function AlterarUsuario($Id, $Dados){
			if(!empty($Dados['Usuario_user'])){
				$this->Read->ExeRead('Usuaios', "WHERE Usuario_user = :usuario", "usuario={$Dados['Usuario_user']}");
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