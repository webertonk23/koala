<?php
	class Login{
		private $Level;
		private $Usuario;
		private $Senha;
		private $Error;
		private $Result;
	
		public function ExeLogin(array $UserData){
			$this->Usuario = (string) strip_tags(trim($UserData['Usuario']));
			$this->Senha = (string) strip_tags(trim($UserData['Senha']));
			$this->SetLogin();
		}
		
		public function GetResult(){
			return $this->Result;
		}
		
		public function GetError(){
			return $this->Error;
		}
		
		public function CheckLogin() {
			if(empty($_SESSION['Usuario'])){
				unset($_SESSION['Usuario']);
				return false;
			}else{
				return true;
			}
		}
		
		private function SetLogin(){
			if(!$this->Usuario OR !$this->Senha){
				$this->Error = ['Preencha os campos usuário e senha para entrar no sistema', ALERTA];
			}elseif(!$this->GetUser()){
				$this->	Error = ['Usuario ou senha inválidos ou você não possui permissão para acessar o sistema', ERRO];
			}else{
				$this->Excute();
				
				$Update = new Update;
				$a['dtlogout_sess'] = date("Y-m-d H:i:s");
				$Update->ExeUpdate('session', $a, 'WHERE iduser_sess = :iduser AND dtlogout_sess IS NULL', "iduser={$_SESSION['Usuario']['Id_user']}");
				
				$Create = new Create;
				$Sess['session_sess'] = session_id();
				$Sess['iduser_sess'] = $_SESSION['Usuario']['Id_user'];
				$Sess['dtlogin_sess'] = date("Y-m-d H:i:s");
				$Sess['ip_sess'] =	$_SERVER['REMOTE_ADDR'];
				
				$Create->ExeCreate('session', $Sess);
				
				if($Create->GetResult()>0){
					$this->Result=true;
				}else{
					unset($_SESSION['Usuario']);
					session_regenerate_id();
					$this->Error = ['Não foi possivel criar sessão', ERRO];
					$this->Result = false;
				}
			}
		}
		
		private function GetUser(){
			$this->Senha = md5($this->Senha);
			
			$Read = new Read;
			$Read->ExeRead('USUARIOS', 'WHERE Usuario_user = :Usuario AND Senha_user = :Senha AND Ativo_user = :Ativo', "Usuario={$this->Usuario}&Senha={$this->Senha}&Ativo=1");			
			if($Read->GetResult()){
				$this->Result = $Read->Getresult()[0];
				return true;
			}else{
				return false;	
			}
		}
		
		private function GetSession(){
			$Read = new Read;
			$Read->ExeRead('session', 'WHERE iduser_sess = :iduser AND dtlogout_sess IS NULL', "iduser={$_SESSION['Usuario']['Id_user']}");
			
			if($Read->GetRowCount()>0){
				$this->Result = $Read->GetResult()[0];
				return true;
			}else{
				return false;	
			}
		}
		
		private function Excute() {
			if(!session_id()){
				session_start();
			}
			
			$_SESSION['Usuario'] = $this->Result;
			unset($_SESSION['Usuario']['Senha_user']);
			
		}
	}

?>