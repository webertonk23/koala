<?php
	//Passar Pagina de Origem, tabela a ser trabalhada e ação = Inclusão, Edição

	if(!empty($_POST)){
		foreach($_POST as $Key => $Values){
			$_POST[$Key] = strip_tags(trim($Values));
		}
		$Page = $_POST['Page'];
		$Tabela = $_POST['Tabela'];
		unset($_POST['Page'], $_POST['Tabela']);
		
		switch($Tabela){
		
			case 'Produtos':
				$Produtos = new Produtos;
				
				if($_POST['Salvar'] == 'Criar'){
					unset($_POST['Salvar']);
					
					$Produtos->NovoProduto($_POST);
					
					$Page .= (!$Produtos->GetErro()) ?	"&Msg=Criado Produto id {$Produtos->GetResult()} Com Sucesso!&Err=SUCESSO" : "&Msg={$Produtos->GetErro()[0]}&Err={$Produtos->GetErro()[1]}";
				}else if($_POST['Salvar'] == 'Editar'){
					$Id = $_POST['Id'];
					unset($_POST['Salvar'], $_POST['Id']);
					
					$Produtos->AlterarProduto($Id, $_POST);
					
					$Page .= (!$Produtos->GetErro()) ?	"&Msg=Produto id {$Id} alterado com sucesso!&Err=SUCESSO" : "&Msg={$Produtos->GetErro()[0]}&Err={$Produtos->GetErro()[1]}";
				}
			break;
			
			case 'Vendas':
				$Vendas = new Vendas;
				
				if($_POST['Salvar'] == 'Criar'){
					unset($_POST['Salvar']);
					
					$_POST['idcart_venda'] = explode('-', $_POST['idficha_venda'])[1];
					$_POST['idficha_venda'] = explode('-', $_POST['idficha_venda'])[0];
					
					$Vendas->NovaVenda($_POST);
					
					//$Page .= (!$Produtos->GetErro()) ?	"&Msg=Criado Produto id {$Produtos->GetResult()} Com Sucesso!&Err=SUCESSO" : "&Msg={$Produtos->GetErro()[0]}&Err={$Produtos->GetErro()[1]}";
					
				}else if($_POST['Salvar'] == 'Editar'){
					$Id = $_POST['Id'];
					unset($_POST['Salvar'], $_POST['Id']);
					
					Debug($_POST);
					
					if(!empty($_POST['msg'])){
						$msg = $_POST['msg'];
						if(strpos($msg, 'Status') !== false){
							$msg .= "<br>para: {$_POST['status_venda']}<br>Motivo: {$_POST['Motivost_venda']}";
						}
						
						unset($_POST['msg']);
					}else{
						$msg = null;
					}
					
					$Vendas->AlterarVenda($Id, $_POST, $msg);
					
					$Page .= (!$Vendas->GetErro()) ? "&Msg=Venda id {$Id} alterado com sucesso!&Err=SUCESSO" : "&Msg={$Vendas->GetErro()[0]}&Err={$Produtos->GetErro()[1]}";

				}
			
			break;		
			
			case 'Pessoas':
				
				if($_POST['Salvar'] == 'Criar'){
					unset($_POST['Salvar']);
					
					
					
				}else if($_POST['Salvar'] == 'Editar'){
					$Id = $_POST['Id'];
					unset($_POST['Salvar'], $_POST['Id']);
					
					// Debug($_POST);
					$Update = new Update;
					$Read = new Read;
					$Read->ExeRead('Pessoas', "WHERE CpfCnpj_pes = :cpfcnpj AND id_pes != :id", "cpfcnpj={$_POST['CpfCnpj_Pes']}&id={$Id}");
					if(empty($Read->GetRowCount())){
						$Update->ExeUpdate("Pessoas", $_POST, "WHERE id_pes = :id", "id={$Id}");
					}
				}
			
			break;
		}
		
		unset($_POST);
		Redirect("?".$Page);
	}else{
		Erro("Nehum valor passado para processar, <a href='?p=Inicio'>tente novamente!</a>", ERRO);
	}


?>