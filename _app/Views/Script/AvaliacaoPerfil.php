<?php
	if(!empty($_POST)){
		unset($_POST['Salvar']);
		
		$Perfil = new AvaliacaoPerfil;
		$Perfil->SetItens($_POST, $_SERVER['REQUEST_TIME']);
		$Perfil->GetResult();
	}
?>

<div class='card mb-2 text-center'>
	<div class='card-body'>
		<h3 class='card-title'>Avaliação</h3>
	</div>
</div>

<div class='card mb-2'>
	<div class='card-body'>
		<h4 class='card-title'>Avaliação de Estilo de Negociação</h4>
		<form class="form" name="" method="POST">
			<p class="font-italic text-justify">
				Nas páginas seguintes, você encontrará 12 (doze) conjuntos de afirmações, versando sobre diferentes comportamentos numa situação de negociação. Na coluna à esquerda das afirmações, classifique-as de 5 (cinco) até 1 (um), de acordo como você realmente se vê nessa situação.
				Não pense como você gostaria de ser, mas como efetivamente é.
				Assim assinale com o número 5 (cinco) a afirmação que melhor descreve o seu comportamento, aquilo que lhe é mais típico e característico. Use o número 4 (quatro) para a afirmação que descreva o que você crê seja mais característico em segundo lugar e assim por diante, até chegar ao número 1 (um) que indique o que em você é menos típico.
				Analise cada situação individualmente, não deixe de classificar nenhuma afirmação e, principalmente, não repita “notas”.
				Não há tempo determinado para concluir, mas procure ser sincero e rápido.
			</p>
	
			<fieldset class='border p-2 rounded mb-3'>
				<div class="form-group">
					<h5>SITUAÇÃO 01</h5>
					<ul >
						<li class='form-row align-items-center py-2'>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='1[Persuasao]' value="<?php echo (!empty($_POST[1]['Persuasao']) ? $_POST[1]['Persuasao'] : null)?>">
							<label class='h6'>Eu formulo sugestões e proposições de qualidade significativa.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='1[Afirmacao]' value="<?php echo (!empty($_POST[1]['Afirmacao']) ? $_POST[1]['Afirmacao'] : null)?>">
							<label class='h6'>Eu faço com que as pessoas conheçam rapidamente meus desejos e vontades.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='1[Ligacao]' value="<?php echo (!empty($_POST[1]['Ligacao']) ? $_POST[1]['Ligacao'] : null)?>">
							<label class='h6'>Eu solicito ativamente a opinião e as sugestões das pessoas.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='1[Atracao]' value="<?php echo (!empty($_POST[1]['Atracao']) ? $_POST[1]['Atracao'] : null)?>">
							<label class='h6'>Eu oriento as pessoas a verem os aspectos estimulantes de uma situação.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='1[Recuo]'  value="<?php echo (!empty($_POST[1]['Recuo']) ? $_POST[1]['Recuo'] : null)?>">
							<label class='h6'>Eu conservo um distanciamento mesmo em situação difíceis.</label>
						</li>
					</ul>
				</div>
			</fieldset>
				
			<fieldset class='border p-2 rounded mb-3'>
				<div class="form-group">
					<h5>SITUAÇÃO 02</h5>
					<ul >
						<li class='form-row align-items-center py-2'>
							<h6 class='mr-2'>A)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='2[Afirmacao]' value="<?php echo (!empty($_POST[2]['Afirmacao']) ? $_POST[2]['Afirmacao'] : null)?>">
							<label class='h6'>Eu corrijo os erros dos outros.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>B)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='2[Ligacao]' value="<?php echo (!empty($_POST[2]['Ligacao']) ? $_POST[2]['Ligacao'] : null)?>">
							<label class='h6'>Eu escuto atentamente quando os outros expressam opiniões diferentes das minhas.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>C)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='2[Atracao]' value="<?php echo (!empty($_POST[2]['Atracao']) ? $_POST[2]['Atracao'] : null)?>">
							<label class='h6'>Eu faço um esforço significativo para divulgar informações que disponho.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>D)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='2[Recuo]' value="<?php echo (!empty($_POST[2]['Recuo']) ? $_POST[2]['Recuo'] : null)?>">
							<label class='h6'>Eu mudo de opinião em vez de me arriscar num conflito ou numa confrontação.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>E)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='2[Persuasao]' value="<?php echo (!empty($_POST[2]['Persuasao']) ? $_POST[2]['Persuasao'] : null)?>">
							<label class='h6'>Eu apresento fortes argumentos para sustentar minhas proposições.</label>
						</li>
					</ul>
				</div>
			</fieldset>

			<fieldset class='border p-2 rounded mb-3'>
				<div class="form-group">
					<h5>SITUAÇÃO 03</h5>
					<ul >
						<li class='form-row align-items-center py-2'>
							<h6 class='mr-2'>A)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='3[Ligacao]' value="<?php echo (!empty($_POST[3]['Ligacao']) ? $_POST[3]['Ligacao'] : null)?>">
							<label class='h6'>Eu me empenho particularmente em valorizar as idéias e a contribuição das pessoas.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>B)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='3[Atracao]' value="<?php echo (!empty($_POST[3]['Atracao']) ? $_POST[3]['Atracao'] : null)?>">
							<label class='h6'>Meu otimismo e meu entusiasmo são contagiantes.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>C)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='3[Recuo]' value="<?php echo (!empty($_POST[3]['Recuo']) ? $_POST[3]['Recuo'] : null)?>">
							<label class='h6'>Se as pessoas argumentam de forma improdutiva, eu retrocedo e procuro   tornar a discussão mais adequada.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>D)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='3[Persuasao]' value="<?php echo (!empty($_POST[3]['Persuasao']) ? $_POST[3]['Persuasao'] : null)?>">
							<label class='h6'>Eu apresento propostas que parecem interessantes mesmo que sejam  impopulares.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>E)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='3[Afirmacao]' value="<?php echo (!empty($_POST[3]['Afirmacao']) ? $_POST[3]['Afirmacao'] : null)?>">
							<label class='h6'>Eu expresso as normas que, segundo minha opinião, os outros devem respeitar.</label>
						</li>
					</ul>
				</div>
			</fieldset>
			
			<fieldset class='border p-2 rounded mb-3'>
				<div class="form-group">
					<h5>SITUAÇÃO 04</h5>
					<ul >
						<li class='form-row align-items-center py-2'>
							<h6 class='mr-2'>A)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='4[Atracao]' value="<?php echo (!empty($_POST[4]['Atracao']) ? $_POST[3]['Atracao'] : null)?>">
							<label class='h6'>Eu forneço as informações que tenho e não faço segredo.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>B)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='4[Recuo]' value="<?php echo (!empty($_POST[4]['Recuo']) ? $_POST[3]['Recuo'] : null)?>">
							<label class='h6'>Eu me retiro no momento em que os outros se empenham em detalhes tumultuados.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>C)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='4[Persuasao]' value="<?php echo (!empty($_POST[4]['Persuasao']) ? $_POST[3]['Persuasao'] : null)?>">
							<label class='h6'>Eu apoio minhas proposições sob uma lógica sólida e um raciocínio bem  feito.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>D)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='4[Afirmacao]' value="<?php echo (!empty($_POST[4]['Afirmacao']) ? $_POST[3]['Afirmacao'] : null)?>">
							<label class='h6'>Eu dou a impressão de que me considero mais racional e objetivo do que as  pessoas com as quais negocio.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>E)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='4[Ligacao]' value="<?php echo (!empty($_POST[4]['Ligacao']) ? $_POST[3]['Ligacao'] : null)?>">
							<label class='h6'>Eu verifico se compreendi bem o que os outros disseram.</label>
						</li>
					</ul>
				</div>
			</fieldset>
				
			<fieldset class='border p-2 rounded mb-3'>
				<div class="form-group">
					<h5>SITUAÇÃO 05</h5>
					<ul >
						<li class='form-row align-items-center py-2'>
							<h6 class='mr-2'>A)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='5[Recuo]' value="<?php echo (!empty($_POST[5]['Recuo']) ? $_POST[5]['Recuo'] : null)?>">
							<label class='h6'>Eu desfaço as situações conflituosas utilizando o humor ou mudando de   assunto de maneira apropriada.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>B)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='5[Persuasao]' value="<?php echo (!empty($_POST[5]['Persuasao']) ? $_POST[5]['Persuasao'] : null)?>">
							<label class='h6'>Eu apresento minhas idéias e minhas proposições de maneira persuasiva.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>C)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='5[Afirmacao]' value="<?php echo (!empty($_POST[5]['Afirmacao']) ? $_POST[5]['Afirmacao'] : null)?>">
							<label class='h6'>Eu faço com que os outros conheçam os critérios pelos quais serão avaliados.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>D)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='5[Ligacao]' value="<?php echo (!empty($_POST[5]['Ligacao']) ? $_POST[5]['Ligacao'] : null)?>">
							<label class='h6'>Eu sou sensível aos problemas e as preocupações dos outros, portanto,eu  me comprometo de maneira a minimizá-los.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>E)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='5[Atracao]' value="<?php echo (!empty($_POST[5]['Atracao']) ? $_POST[5]['Atracao'] : null)?>">
							<label class='h6'>Eu sei refletir o que as pessoas sentem.</label>
						</li>
					</ul>
				</div>
			</fieldset>
				
			<fieldset class='border p-2 rounded mb-3'>
				<div class="form-group">
					<h5>SITUAÇÃO 06</h5>
					<ul >
						<li class='form-row align-items-center py-2'>
							<h6 class='mr-2'>A)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='6[Persuasao]' value="<?php echo (!empty($_POST[6]['Persuasao']) ? $_POST[6]['Persuasao'] : null)?>">
							<label class='h6'>Eu defendo minhas sugestões e meus propósitos de maneira energética.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>B)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='6[Afirmacao]' value="<?php echo (!empty($_POST[6]['Afirmacao']) ? $_POST[6]['Afirmacao'] : null)?>">
							<label class='h6'>Eu informo diretamente as pessoas quando elas não atendem aos meus propósitos.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>C)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='6[Ligacao]' value="<?php echo (!empty($_POST[6]['Ligacao']) ? $_POST[6]['Ligacao'] : null)?>">
							<label class='h6'>Eu repito o que os outros dizem utilizando seus próprios termos para confirmar meu entendimento.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>D)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='6[Atracao]' value="<?php echo (!empty($_POST[6]['Atracao']) ? $_POST[6]['Atracao'] : null)?>">
							<label class='h6'>Desde que não esteja certo(a) de minhas afirmações,estou pronto(a) a reconhecê-lo.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>E)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='6[Recuo]' value="<?php echo (!empty($_POST[6]['Recuo']) ? $_POST[6]['Recuo'] : null)?>">
							<label class='h6'>Eu mudo de assunto desde que as pessoas se sintam atingidas pessoalmente.</label>
						</li>
					</ul>
				</div>
			</fieldset>
					
			<fieldset class='border p-2 rounded mb-3'>
				<div class="form-group">
					<h5>SITUAÇÃO 07</h5>
					<ul >
						<li class='form-row align-items-center py-2'>
							<h6 class='mr-2'>A)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='7[Afirmacao]' value="<?php echo (!empty($_POST[7]['Afirmacao']) ? $_POST[7]['Afirmacao'] : null)?>">
							<label class='h6'>Eu Faço Com Que As Saibam Exatamente O Que Eu Espero Delas.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>B)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='7[Ligacao]' value="<?php echo (!empty($_POST[7]['Ligacao']) ? $_POST[7]['Ligacao'] : null)?>">
							<label class='h6'>Se Algumas Pessoas Não Participam, Eu Me Esforço Para Fazer Com Que Elas Se Entrosem No Grupo.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>C)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='7[Atracao]' value="<?php echo (!empty($_POST[7]['Atracao']) ? $_POST[7]['Atracao'] : null)?>">
							<label class='h6'>Eu Motivo As Pessoas Apelando Para Seus Valores, Seus Sentimentos E Suas Emoções.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>D)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='7[Recuo]' value="<?php echo (!empty($_POST[7]['Recuo']) ? $_POST[7]['Recuo'] : null)?>">
							<label class='h6'>Eu Percebo A Iminência De Um Conflito E Sei Como Evitá-Lo Com Um Comentário Apropriado No Momento Oportuno.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>E)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='7[Persuasao]' value="<?php echo (!empty($_POST[7]['Persuasao']) ? $_POST[7]['Persuasao'] : null)?>">
							<label class='h6'>Minhas Sugestões São Pertinentes E Atingem O Centro Dos Problemas Abordados.</label>
						</li>
					</ul>
				</div>
			</fieldset>
					
			<fieldset class='border p-2 rounded mb-3'>
				<div class="form-group">
					<h5>SITUAÇÃO 08</h5>
					<ul >
						<li class='form-row align-items-center py-2'>
							<h6 class='mr-2'>A)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='8[Ligacao]' value="<?php echo (!empty($_POST[8]['Ligacao']) ? $_POST[8]['Ligacao'] : null)?>">
							<label class='h6'>Eu Escuto Atentamente O Que As Pessoas Dizem.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>B)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='8[Atracao]' value="<?php echo (!empty($_POST[8]['Atracao']) ? $_POST[8]['Atracao'] : null)?>">
							<label class='h6'>Desde Que Critiquem Com Razão, Eu Reconheço Facilmente Meus Erros E Meus Esquecimentos.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>C)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='8[Recuo]' value="<?php echo (!empty($_POST[8]['Recuo']) ? $_POST[8]['Recuo'] : null)?>">
							<label class='h6'>Se Me Contradizem, Mudo Minha Opinião.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>D)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='8[Persuasao]' value="<?php echo (!empty($_POST[8]['Persuasao']) ? $_POST[8]['Persuasao'] : null)?>">
							<label class='h6'>Eu Peço Explicações Complementares Desde Que Não Esteja De Acordo Ou   Esteja Em Dúvida Sobre O Assunto.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>E)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='8[Afirmacao]' value="<?php echo (!empty($_POST[8]['Afirmacao']) ? $_POST[8]['Afirmacao'] : null)?>">
							<label class='h6'>Eu Demonstro Minha Aprovação Quando Alguém Faz Alguma Coisa Que Eu Aprecio.</label>
						</li>
					</ul>
				</div>
			</fieldset>
					
			<fieldset class='border p-2 rounded mb-3'>
				<div class="form-group">
					<h5>SITUAÇÃO 09</h5>
					<ul >
						<li class='form-row align-items-center py-2'>
							<h6 class='mr-2'>A)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='9[Atracao]' value="<?php echo (!empty($_POST[9]['Atracao']) ? $_POST[9]['Atracao'] : null)?>">
							<label class='h6'>Minha Consciência Profissional E Minha Sinceridade Incitam Os Outros A Darem O Melhor De Si Mesmos.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>B)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='9[Recuo]' value="<?php echo (!empty($_POST[9]['Recuo']) ? $_POST[9]['Recuo'] : null)?>">
							<label class='h6'>Eu Sou Calmo Em Situações Conflituosa.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>C)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='9[Persuasao]' value="<?php echo (!empty($_POST[9]['Persuasao']) ? $_POST[9]['Persuasao'] : null)?>">
							<label class='h6'>Eu Sugiro Soluções Possíveis A Quase Todos Os Problemas Que Se Apresentam.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>D)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='9[Afirmacao]' value="<?php echo (!empty($_POST[9]['Afirmacao']) ? $_POST[9]['Afirmacao'] : null)?>">
							<label class='h6'>Eu Digo Aos Outros O Que Eles Devem Ou Não Fazer.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>E)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='9[Ligacao]' value="<?php echo (!empty($_POST[9]['Ligacao']) ? $_POST[9]['Ligacao'] : null)?>">
							<label class='h6'>Eu Manifesto Meu Apoio Desde Que Os Outros Estejam Em Dificuldades.</label>
						</li>
					</ul>
				</div>
			</fieldset>
					
			<fieldset class='border p-2 rounded mb-3'>
				<div class="form-group">
					<h5>SITUAÇÃO 10</h5>
					<ul >
						<li class='form-row align-items-center py-2'>
							<h6 class='mr-2'>A)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='10[Recuo]' value="<?php echo (!empty($_POST[10]['Recuo']) ? $_POST[10]['Recuo'] : null)?>">
							<label class='h6'>Eu Evito Abordar Assuntos Difíceis E Pontos De Vista Que Possam Provocar Controvérsias.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>B)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='10[Persuasao]' value="<?php echo (!empty($_POST[10]['Persuasao']) ? $_POST[10]['Persuasao'] : null)?>">
							<label class='h6'>Desde Que As Pessoas Não Estejam De Acordo Com Minhas Idéias Eu Lanço Mão De Novos Argumentos Para Defendê-Las.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>C)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='10[Afirmacao]' value="<?php echo (!empty($_POST[10]['Afirmacao']) ? $_POST[10]['Afirmacao'] : null)?>">
							<label class='h6'>Eu Cumprimento Alguns Pelo Seu Trabalho, De Maneira A Incentivar Os Outros   A Melhorarem Seu Desempenho.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>D)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='10[Ligacao]' value="<?php echo (!empty($_POST[10]['Ligacao']) ? $_POST[10]['Ligacao'] : null)?>">
							<label class='h6'>Eu Estou Atento Tanto No Como As Pessoas Se Sentem Quanto Com Relação Ao   Que Dizem.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>E)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='10[Atracao]' value="<?php echo (!empty($_POST[10]['Atracao']) ? $_POST[10]['Atracao'] : null)?>">
							<label class='h6'>Eu Não Escondo Minhas Motivações E Minhas Intenções.</label>
						</li>
					</ul>
				</div>
			</fieldset>
					
			<fieldset class='border p-2 rounded mb-3'>
				<div class="form-group">
					<h5>SITUAÇÃO 11</h5>
					<ul >
						<li class='form-row align-items-center py-2'>
							<h6 class='mr-2'>A)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='11[Persuasao]' value="<?php echo (!empty($_POST[11]['Persuasao']) ? $_POST[11]['Persuasao'] : null)?>">
							<label class='h6'>Eu Apresento Minhas Idéias Com Determinação.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>B)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='11[Afirmacao]' value="<?php echo (!empty($_POST[11]['Afirmacao']) ? $_POST[11]['Afirmacao'] : null)?>">
							<label class='h6'>Eu Exponho Clara E Energicamente Minhas Expectativas E Exigências De Forma A Que Não Sejam Nem Esquecidas Nem Descartadas.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>C)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='11[Ligacao]' value="<?php echo (!empty($_POST[11]['Ligacao']) ? $_POST[11]['Ligacao'] : null)?>">
							<label class='h6'>EEu Respeito Os Outros E Seus Pontos De Vista Mesmo Quando Não Estou De Acordo Com Eles.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>D)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='11[Atracao]' value="<?php echo (!empty($_POST[11]['Atracao']) ? $_POST[11]['Atracao'] : null)?>">
							<label class='h6'>Minha Confiança Nos Outros Ajuda-Os A Se Sentirem Mais Fortes E Mais Confiantes.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>E)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='11[Recuo]' value="<?php echo (!empty($_POST[11]['Recuo']) ? $_POST[11]['Recuo'] : null)?>">
							<label class='h6'>Eu Sugiro Um Compromisso Para Sair De Um Impasse Ou Dissipar Desavenças.</label>
						</li>
					</ul>
				</div>
			</fieldset>
			
			<fieldset class='border p-2 rounded mb-3'>
				<div class="form-group">
					<h5>SITUAÇÃO 12</h5>
					<ul >
						<li class='form-row align-items-center py-2'>
							<h6 class='mr-2'>A)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='12[Afirmacao]' value="<?php echo (!empty($_POST[12]['Afirmacao']) ? $_POST[12]['Afirmacao'] : null)?>">
							<label class='h6'>Eu Faço Uso Do Humor Para Suavizar Ou Controlar Minhas Impressões Negativas.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>B)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='12[Ligacao]' value="<?php echo (!empty($_POST[12]['Ligacao']) ? $_POST[12]['Ligacao'] : null)?>">
							<label class='h6'>Eu Concedo Aos Outros O Tempo E A Atenção Necessários Para Que Eles Expressem Completamente Seus Pontos De Vista.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>C)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='12[Atracao]' value="<?php echo (!empty($_POST[12]['Atracao']) ? $_POST[12]['Atracao'] : null)?>">
							<label class='h6'>Eu Peço Ajuda Para Atender Aos Objetivos Comuns.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>D)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='12[Recuo]' value="<?php echo (!empty($_POST[12]['Recuo']) ? $_POST[12]['Recuo'] : null)?>">
							<label class='h6'>Eu Atenuo Os Desacordos.</label>
						</li>
						
						<li class='form-row align-items-center  pb-2'>
							<h6 class='mr-2'>E)</h6>
							<input class="form-control col-sm-1 mr-2 form-control-sm text-center" onkeypress="return onlynumber();" type='text' maxlength='1' required name='12[Persuasao]' value="<?php echo (!empty($_POST[12]['Persuasao']) ? $_POST[12]['Persuasao'] : null)?>">
							<label class='h6'>Eu Utilizo Humor E Anedotas Para Ressaltar Um Argumento.</label>
						</li>
					</ul>
				</div>
			</fieldset>
				
			<div class="form-group row">
					<div class='col-sm'>
						<button class='btn btn-success form-control' title = 'Salvar'>Salvar</button>
					</div>
				</div>														
			</div>
		</form>
	</div>
</div>

<script>
	function onlynumber(evt) {
	   var theEvent = evt || window.event;
	   var key = theEvent.keyCode || theEvent.which;
	   key = String.fromCharCode( key );
	   //var regex = /^[0-9.,]+$/;
	   var regex = /^[1-5]+$/;
	   if( !regex.test(key) ) {
		  theEvent.returnValue = false;
		  if(theEvent.preventDefault) theEvent.preventDefault();
	   }
	}
</script>