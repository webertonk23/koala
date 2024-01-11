<?php
	class Email{
		private $User;
		private $Senha;
		private $Erro;
		private $Result;
		
		private $Host;
		private $Port;
		

		public function __Construct(){
			$this->User = 'boletos@asacenter.com.br';
			$this->Senha = 'BBC*6QZ&O+?%jprDIT#$';
			$this->Host = 'smtp.asacenter.com.br';
			$this->Port = 587;
			
			$this->Result = false;
			//$this->Port = 587;
		}
		
		public function GetResult(){
			return $this->Result;
		}
		
		public function Enviar($para, $assunto, $Mensagem, $Anexo = null, $De = null) { 
			$mail = new PHPMailer();
			$mail->IsSMTP();		// Ativar SMTP
			$mail->isHTML(true);
			$mail->CharSet = 'UTF-8';
			$mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
			$mail->SMTPAuth = true;		// Autenticação ativada
			$mail->SMTPSecure = 'none';	// SSL REQUERIDO pelo GMail
			$mail->Host = $this->Host;	// SMTP utilizado
			$mail->Port = $this->Port;  // A porta 587 deverá estar aberta em seu servidor
			$mail->Username = $this->User;
			$mail->Password = $this->Senha;
			$mail->SetFrom($this->User, (!empty($De)) ? $De : '');
			$mail->Subject = $assunto;
			if(!empty($Anexo)) $mail->AddAttachment($Anexo);
			
			//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo
			
			$mail->Body = $Mensagem;
			foreach($para as $values){
				$mail->AddAddress($values);
			}
			if(!$mail->Send()) {
				$this->Result = 'Mail error: '.$mail->ErrorInfo;
			}
		}
	}
?>