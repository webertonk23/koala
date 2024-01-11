<?php
	class Vendas{
		
		public $Result;
		public $Erro;
		public $Dados;
		private $Read;
		private $Insert;
		private $Update;
		private $Delete;
		
		public function GetResult(){
			return $this->Result;
		}
		
		public function GetErro(){
			return $this->Erro;
		}
		
		public function __construct (){
			$this->Erro = false;
			$this->Read = new Read;
			$this->Insert = new Create;
			$this->Update = new Update;
			$this->Delete = new Delete;
		}

		public function Listar($Dados = array()){
			/*
			##################################################################################################################
			#############################################  Criterios permitidos.  ############################################
			##################################################################################################################
			##																												##
			##	Recebe um array com os dados para serem utilizados nas consultas, sendo a chave o criterio para buscar		##
			##																												##
			##	Criterio	|	Tipo	|	Conteudo																		##
			##	Data 		|	Array	|	Datas em formato americano [0] => Inicio, [0] => Fim							##
			##	Id_Pes		|	Int		|	Id de pessoa para buscar venda													##
			##	Id_Venda	|	Int		|	Id da venda realizada															##
			##	Id_Cart		|	Int		|	Id da cardeira que a venda realizada pertence									##
			##	IdUser_Venda|	Int		|	Id do usuario que realizou a venda												##
			##	Numero_venda|	varchar	|	Identificador de venda no sistema do cliente.									##
			##																												##
			##################################################################################################################
			##################################################################################################################
			##################################################################################################################
			*/
			
			
			
			//Debug($Dados);
			
			//$this->Read->ExeRead('Vendas', "WHERE numero_venda = :numero", "numero={$Dados['numero_venda']}");
			
			$Query = "SELECT Vendas.*, Nome_Pes, Cpfcnpj_pes, Nome_user, desc_prod, Desc_Cart
					FROM
						Vendas INNER JOIN Usuarios ON IdUser_Venda = Id_User
						INNER JOIN Produto ON IdProd_Venda = Id_Prod
						INNER JOIN Carteira ON IdCart_Venda = Id_Cart
						INNER JOIN Pessoas ON IdPes_Venda = Id_Pes
					WHERE ";
			
			$Cond = "";
			
			$Cond .= (!empty($Dados['Id_Pes'])) ? "--IdPes_Venda = {$Dados['Id_Pes']}" : "";
			$Cond .= (!empty($Dados['id_prod'])) ? "--id_prod = {$Dados['id_prod']}" : "";
			$Cond .= (!empty($Dados['Id_Venda'])) ? "--Id_Venda = {$Dados['Id_Venda']}" : "";
			$Cond .= (!empty($Dados['Numero_venda'])) ? "--Numero_venda = {$Dados['Numero_venda']}" : "";
			$Cond .= (!empty($Dados['IdUser_Venda'])) ? "--IdUser_Venda = {$Dados['IdUser_Venda']}" : "";
			$Cond .= (!empty($Dados['Id_Cart'])) ? "--IdCart_Venda = {$Dados['Id_Cart']}" : "";
			$Cond .= (!empty($Dados['status_venda'])) ? "--status_venda = '{$Dados['status_venda']}'" : "";
			$Cond .= (!empty($Dados['Data'][0]) AND !empty($Dados['Data'][1])) ? "--dtvenda_venda BETWEEN '{$Dados['Data'][0]} 00:00:00' AND '{$Dados['Data'][1]} 23:59:59'" : "";
			
			$Cond = str_replace('--', " AND ", substr($Cond, 2));
			
			$Query .= $Cond;
			
			// echo $Query;
			// var_dump($Dados);
			
			$this->Read->FullRead($Query);

			if($this->Read->GetRowCount()>0){
				$this->Result = $this->Read->GetResult();
				$this->Erro = false;
			}else{
				$this->Erro = array ('Sem resultado para exibir!', INFO);
			}
		}
		
		public function NovaVenda($Dados){
			if(!empty($Dados['numero_venda']) AND !empty($Dados['idcart_venda'])){
				$this->Read->ExeRead('Vendas', "WHERE numero_venda = :numero AND idcart_venda = :cart", "numero={$Dados['numero_venda']}&cart={$Dados['idcart_venda']}");
				if($this->Read->GetRowCount() == 0){
					$this->Insert->ExeCreate('Vendas', $Dados);
					if($this->Insert->GetResult()){
						$HistVenda['IdVenda_histv'] = $this->Insert->GetResult();
						$HistVenda['Obs_histv'] = "Venda adicionada por {$_SESSION['Usuario']['Nome_user']}";
						
						$this->Insert->ExeCreate('histvenda', $HistVenda);
						
						$this->Result = $HistVenda['IdVenda_histv'];
						$this->Erro = false;
					}else{
						$this->Erro = array ('Não foi possível cadastrar a venda!', ERRO);
					}
				}else{
					$this->Erro = array ('venda já cadastrado com este numero para esta carteira!', ERRO);
				}
			}else{
				$this->Erro = array ('Gentileza preeencher o campo de número da venda e ficha para prosseguir!', ERRO);
			}
			
		}
		
		public function AlterarVenda($Id, $Dados = array(), $msg = null){
			$this->Update->ExeUpdate('Vendas', $Dados, "WHERE id_venda = :id", "id={$Id}");
			if($this->Update->GetResult()){
				$HistVenda['IdVenda_histv'] = $this->Insert->GetResult();
				$HistVenda['Obs_histv'] = $msg."<br>por {$_SESSION['Usuario']['Nome_user']}"; 
				
				$this->Insert->ExeCreate('histvenda', $HistVenda);
				
				$this->Result = $this->Insert->GetResult();
				$this->Erro = false;
			}else{
				$this->Erro = array ('Não foi possível alterar a venda!', ERRO);
			}
		}
		
		public function DeleteVenda($Id){
			$this->Delete->ExeDelete('Vendas', "WHERE id_venda = :id", "id={$Id}");
			if($this->Delete->GetResult()){
				$this->Erro = array ('Venda deletada', ERRO);
			}else{
				$this->Erro = array ('Não foi possível deletar a venda!', ERRO);
			}
		}
	}
?>