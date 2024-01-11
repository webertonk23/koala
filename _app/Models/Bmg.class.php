<?php
	class Bmg{
		
		public $Result;
		public $Erro;
		private $Dados;
		private $cURL;
		private $xml;
		private $User;
		private $Pass;
		private $Link;
		private $Param;
		
		public function __construct(){
			$this->User = "ROBO.52849";
			$this->Pass = "ROBO*52849";
			$this->Erro = false;
			
			
		}
		
		public function buscarLimiteSaque($Cpf, $Matricula, $NConta, $CpfImpedido = false){
			$this->Link = "https://ws1.bmgconsig.com.br/webservices/SaqueComplementar?wsdl";
			
			$client = new SoapClient($this->Link);
	
			$function = 'buscarLimiteSaque';
	 
			$arguments= array(
				'DadosCartaoParameter' => array(
					'login'				=> $this->User,
					'senha'				=> $this->Pass,
					'codigoEntidade'	=> 1581,
					'cpf'				=> $Cpf,
					'loginConsig'		=> '',
					'senhaConsig'		=> '',
					'sequencialOrgao'	=> '',
					'agregacaoDeMargemParaSaqueComplementar' => false,
					'codigoTipoSeguro' => 0,
					'cpfImpedidoComissionar' => $CpfImpedido,
					'matricula' => $Matricula,
					'matriculaInstituidor' => '',
					'numeroContaInterna' => $NConta,
					'tipoSaque' => 1,
					'valorAgregacaoDeMargemParaSaqueComplementar' => 0,
					'vinculoMatricula' => '',
				)
			);

			try {
				$this->Result = $client->__soapCall($function, $arguments);
			} catch(Exception $e) {
				$this->Erro = $e->getMessage();
			}
		}
		
		public function buscarCartoesDisponiveis($Cpf){
			$this->Link = "https://ws1.bmgconsig.com.br/webservices/SaqueComplementar?wsdl";
			
			$client = new SoapClient($this->Link, array("trace" => 1));
	
			$function = 'buscarCartoesDisponiveis';
	 
			$arguments= array(
				'CartaoDisponivelParameter' => array(
					'login'				=> $this->User,
					'senha'				=> $this->Pass,
					'codigoEntidade'	=> 1581,
					'cpf'				=> $Cpf,
					'loginConsig'		=> '',
					'senhaConsig'		=> '',
					'sequencialOrgao'	=> ''
				)
			);
				
			try {
				$this->Result = $client->__soapCall($function, $arguments);
				file_put_contents("envio.xml", $client->__getLastRequest());
				file_put_contents("resposta.xml", $client->__getLastResponse());
			} catch(Exception $e) {
				$this->Erro = $e->getMessage();
				file_put_contents("envio.xml", $client->__getLastRequest());
				file_put_contents("resposta.xml", $client->__getLastResponse());
			}
		}
		
		public function Status($Ade = null, $Data = null){
			if((!empty($Ade) AND is_array($Ade)) OR (!empty($Data) AND is_array($Data))){
				
				$this->Link = "https://ws1.bmgconsig.com.br/webservices/ConsultaStatusAde?wsdl";
				
				$client = new SoapClient($this->Link, array("trace" => 1, 'stream_context' => stream_context_create(array('http' => array('protocol_version' => 1.0)))));
			 
				$function = 'consultaStatusAde';
				
				$arguments = array(
					'ConsultaStatusAdeParameter' => array(
						'login'				=> $this->User,
						'senha'				=> $this->Pass,
						"listaAdes"			=> (!empty($Ade)) ? $Ade : ""  
					)
				);
				
				if(!empty($Data)){
					$arguments['ConsultaStatusAdeParameter']["dataInicial"] = $Data[0];
					$arguments['ConsultaStatusAdeParameter']["dataFinal"] = $Data[1];
				}
				
				try {
					$this->Result = $client->__soapCall($function, $arguments);
					file_put_contents("envio.xml", $client->__getLastRequest());
					file_put_contents("resposta.xml", $client->__getLastResponse());
					
				} catch(Exception $e) {
					$this->Erro = $e->getMessage();
					file_put_contents("envio.xml", $client->__getLastRequest());
					file_put_contents("resposta.xml", $client->__getLastResponse());
					
					
				}
			}
		}
		
		public function buscaAdesao($Ade, $Cpf){
			$this->Link = "https://ws1.bmgconsig.com.br/webservices/DadosAdesao?wsdl";
			
			$client = new SoapClient($this->Link, array("trace" => 1, 'stream_context' => stream_context_create(array('http' => array('protocol_version' => 1.0)))));
		 
			$function = 'buscaAdesao';
			 
			$arguments= array(
				'BuscaAdesaoParameter' => array(
					'login'				=> $this->User,
					'senha'				=> $this->Pass,
					'adeNumero'			=> $Ade,
					'cpf'				=> $Cpf,
					'status'			=> -1,
					'loginConsig'		=> '',
					'senhaConsig'		=> '',
					'utilizaUserConsig'	=> false,
					'senhaSME'			=> ''
				)
			);
			
			try {
				$this->Result = $client->__soapCall($function, $arguments);
				file_put_contents("envio.xml", $client->__getLastRequest());
				file_put_contents("resposta.xml", $client->__getLastResponse());
			} catch(Exception $e) {
				$this->Erro = $e->getMessage();
				file_put_contents("envio.xml", $client->__getLastRequest());
				file_put_contents("resposta.xml", $client->__getLastResponse());
			}
		}
		
		public function AddPropConsig(){
			$this->Link = "https://ws1.bmgconsig.com.br/webservices/Emprestimo?wsdl";
			
			$client = new SoapClient($this->Link, array("trace" => 1, 'stream_context' => stream_context_create(array('http' => array('protocol_version' => 1.0)))));
	 
			var_dump($client->__getFunctions());
			var_dump($client->__getTypes());
			
			$function = 'gravarPropostaEmprestimo';
			
			$arguments= array(
				'ParametersPropostaEmprestimo' => array(
				
				
				)
			);
			
			Debug($arguments);
			
			try {
				$this->Result = $client->__soapCall($function, $arguments);
			} catch(Exception $e) {
				$this->Erro = $e->getMessage();
				file_put_contents("envio.xml", $client->__getLastRequest());
				file_put_contents("resposta.xml", $client->__getLastResponse());
			}
		}
		
		public function AddCardBmg(){
			$this->Link = "https://ws1.bmgconsig.com.br/webservices/CartaoMaster?wsdl";
			
			// $client = new SoapClient($this->Link, array("trace" => 1, 'stream_context' => stream_context_create(array('http' => array('protocol_version' => 1.0)))));
			$client = new SoapClient($this->Link, array("trace" => 1, 'stream_context' => stream_context_create(array('http' => array('protocol_version' => 1.0)))));
	 
			var_dump($client->__getFunctions());
			var_dump($client->__getTypes());
			
			$function = 'gravarPropostaCartao';
			
			$arguments = array(
				'CartaoParameter' => array(
					'login' => $this->User,
					'senha' => $this->Pass,
					'loginConsig' => 'jose.souza.asa',
					'senhaConsig' => 'J106asa-',
					'codigoEntidade' => "1581-",
					'codigoServico' => "060",
					'matricula' => "1793759011",
					'cpf' => "00486532844",
					'codigoLoja' => "52849",
					'dataRenda' => date("Y-m-d", strtotime("2020-01-01"))."T00:00:00",
					'valorRenda' => "3008.45",
					'tipoBeneficio' => "41",
					
					'associado' => false,
					
					'cliente' => array(
						'nome' => "Vera Lucia Mendes Trabbold",
						'sexo' => "F",	
						'estadoCivil' => "S",
						'nomeMae' => "VILMA MENDES TRABBOLD",
						'dataNascimento' => date("Y-m-d", strtotime("1956-04-22"))."T00:00:00",
						'estadoCivil' => "S",
						'cidadeNascimento' => "Ibiracatu",
						'ufNascimento' => "MG",
						'nacionalidade' => "BRASILEIRA",
						'grauInstrucao' => "7",
						'pessoaPoliticamenteExposta' => false,
						'endereco' => array(
							'cep' => "39400634",
							'logradouro' => "Av Dep Estreves Rodrigues",
							'numero' => "21",
							'complemento' => "Ap 1404",
							'bairro' => "Todos Os Santos",
							'cidade' => "Montes Claros",
							'uf' => "MG"
						),
						'telefone' => array(
							'numero' => '22114044',
							'ddd' => '38'
						),
						
						'celular1' => array(
							'numero' => '988110989',
							'ddd' => '38'
						),
						
						'identidade' => array(
							'numero' => "6518340",
							'emissor' => "SSP",
							'uf' => "SP",
							'dataEmissao' => date("Y-m-d", strtotime("1980-04-22"))."T00:00:00"
						),
					),
					
					'Banco' => array(
						'numero' => 389,
					),
					
					'Agencia' => array(
						'numero' => 77,
						//'digitoVerificador' => '',
					),
					
					'Conta' => array(
						'numero' => '',
						//'digitoVerificador' => '',
					),
					
					'aberturaContaPagamento' => false,
					'formaCredito' => 2,
					'finalidadeCredito' => 1,
					'codigoFormaEnvioTermo' => 2,
					'bancoOrdemPagamento' => 0,
					'clientePreCadastrado' => false,
					'descontoCompulsorio' => 0,
					'descontoPossuiCartao' => 0,
					'descontoVoluntario' => 0,
					'descontoOutro' => 0,
					'descontoAdicional' => 0,
					'ignorarInconsistenciasPN' => true,

					'tipoDomicilioBancario' => 0,
					'margem' => "1052.92",
					'numeroPrestacoes' => "",
					'possuiCartao' => false,
					'valorIof' => "",
					'valorSolicitado' => "",
					'valorPrestacao' => "",
					'ufContaBeneficio' => 'MG',
					'inserirAtendimentoPlusoft' => false,
					
					'tipoDocumentoIdentificacao' => 'RG'
				)
			);
			
			Debug($arguments);
			
			try {
				$this->Result = $client->__soapCall($function, $arguments);
				file_put_contents("envio.xml", $client->__getLastRequest());
				file_put_contents("resposta.xml", $client->__getLastResponse());
			} catch(Exception $e) {
				$this->Erro = $e->getMessage();
				file_put_contents("envio.xml", $client->__getLastRequest());
				file_put_contents("resposta.xml", $client->__getLastResponse());
			}
		}
	}
?>