<?php
	if(!empty(!empty($_POST)  AND $_POST)){
		unset($_POST['Salvar']);
		
		// $Perfil = new AvaliacaoPerfil;
		// $Perfil->SetItens(!empty($_POST)  AND $_POST, $_SERVER['REQUEST_TIME']);
		// $Perfil->GetResult();
	}
?>

<div class='card mb-2 text-center'>
	<div class='card-body'>
		<h3 class='card-title'>Avaliação</h3>
	</div>
</div>

<div class='card mb-2'>
	<div class='card-body'>
		<h4 class='card-title'>Avaliação de perfil comportamental</h4>
		<form class="form" name="" method="POST">
			<p class="font-italic text-justify">
				Em cada uma das 25 questões a seguir, escolha uma das alternativas e marque a questão correspondente.
			</p>
	
			<fieldset class='border p-2 rounded m-2 row'>
				<div class="form-group col-sm">
					<h5>1. Eu sou...</h5>
					<div class='px-5'>
						<label class='form-check'><input class='form-check-input' type='radio' name='1' value='I'  <?php echo (!empty($_POST)  AND $_POST['1'] == 'I') ? 'checked' : '' ?> > Idealista, criativo e visionário</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='1' value='C'  <?php echo (!empty($_POST)  AND $_POST['1'] == 'C') ? 'checked' : '' ?> > Divertido, espiritual e benéfico</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='1' value='O'  <?php echo (!empty($_POST)  AND $_POST['1'] == 'O') ? 'checked' : '' ?> > Confiável, meticuloso e previsível</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='1' value='A'  <?php echo (!empty($_POST)  AND $_POST['1'] == 'A') ? 'checked' : '' ?> > Focado, determinado e persistente</label>
					</div>
				</div>
				
				<div class="form-group col-sm">
					<h5>2. Eu gosto de...</h5>
					<div class='px-5'>
						<label class='form-check'><input class='form-check-input' type='radio' name='2' value='A'  <?php echo (!empty($_POST)  AND $_POST['2'] == 'A') ? 'checked' : '' ?> > Ser piloto</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='2' value='C'  <?php echo (!empty($_POST)  AND $_POST['2'] == 'C') ? 'checked' : '' ?> > Conversar com os passageiros</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='2' value='O'  <?php echo (!empty($_POST)  AND $_POST['2'] == 'O') ? 'checked' : '' ?> > Planejar a viagem</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='2' value='I'  <?php echo (!empty($_POST)  AND $_POST['2'] == 'I') ? 'checked' : '' ?> > Explorar novas rotas</label>
					</div>
				</div>
				
				<div class="form-group col-sm">
					<h5>3. Se você quiser se dar bem comigo...</h5>
					<div class='px-5'>
						<label class='form-check'><input class='form-check-input' type='radio' name='3' value='I'  <?php echo (!empty($_POST)  AND $_POST['3'] == 'I') ? 'checked' : '' ?> > Me dê liberdade</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='3' value='O'  <?php echo (!empty($_POST)  AND $_POST['3'] == 'O') ? 'checked' : '' ?> > Me deixe saber sua expectativa</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='3' value='A'  <?php echo (!empty($_POST)  AND $_POST['3'] == 'A') ? 'checked' : '' ?> > Lidere, siga ou saia do caminho</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='3' value='C'  <?php echo (!empty($_POST)  AND $_POST['3'] == 'C') ? 'checked' : '' ?> > Seja amigável, carinhoso e compreensivo</label>
					</div>
				</div>
			</fieldset>

			<fieldset class='border p-2 rounded m-2 row'>
				<div class="form-group col-sm">
					<h5>4. Para conseguir obter bons resultados é preciso...</h5>
					<div class='px-5'>
						<label class='form-check'><input class='form-check-input' type='radio' name='4' value='I'  <?php echo (!empty($_POST)  AND $_POST['4'] == 'I') ? 'checked' : '' ?> > Ter incertezas</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='4' value='O'  <?php echo (!empty($_POST)  AND $_POST['4'] == 'O') ? 'checked' : '' ?> > Controlar o essencial</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='4' value='A'  <?php echo (!empty($_POST)  AND $_POST['4'] == 'A') ? 'checked' : '' ?> > Diversão e cerebração</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='4' value='C'  <?php echo (!empty($_POST)  AND $_POST['4'] == 'C') ? 'checked' : '' ?> > Planejar e obter recursos</label>
					</div>
				</div>
			
				<div class="form-group col-sm">
					<h5>5. Eu me divirto quando...</h5>
					<div class='px-5'>
						<label class='form-check'><input class='form-check-input' type='radio' name='5' value='A'  <?php echo (!empty($_POST)  AND $_POST['5'] == 'A') ? 'checked' : '' ?> > Estou me exercitando</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='5' value='I'  <?php echo (!empty($_POST)  AND $_POST['5'] == 'I') ? 'checked' : '' ?> > Tenho novidades</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='5' value='C'  <?php echo (!empty($_POST)  AND $_POST['5'] == 'C') ? 'checked' : '' ?> > Estou com outros</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='5' value='O'  <?php echo (!empty($_POST)  AND $_POST['5'] == 'O') ? 'checked' : '' ?> > Determino as regras</label>
					</div>
				</div>
			
				<div class="form-group col-sm">
					<h5>6. Eu penso que...</h5>
					<div class='px-5'>
						<label class='form-check'><input class='form-check-input' type='radio' name='6' value='C'  <?php echo (!empty($_POST)  AND $_POST['6'] == 'C') ? 'checked' : '' ?> > Unidos venceremos, dividos perderemos</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='6' value='A'  <?php echo (!empty($_POST)  AND $_POST['6'] == 'A') ? 'checked' : '' ?> > O ataque é melhor que a defesa</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='6' value='I'  <?php echo (!empty($_POST)  AND $_POST['6'] == 'I') ? 'checked' : '' ?> > É bom ser manso, mas andar com um porrete</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='6' value='O'  <?php echo (!empty($_POST)  AND $_POST['6'] == 'O') ? 'checked' : '' ?> > Um homem prevenido vale por dois</label>
					</div>
				</div>
			</fieldset>
			
			<fieldset class='border p-2 rounded m-2 row'>
				<div class="form-group col-sm">
					<h5>7. Minha preocupação é...</h5>
					<div class='px-5'>
						<label class='form-check'><input class='form-check-input' type='radio' name='7' value='C'  <?php echo (!empty($_POST)  AND $_POST['7'] == 'C') ? 'checked' : '' ?> > Gerar a idéia global</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='7' value='A'  <?php echo (!empty($_POST)  AND $_POST['7'] == 'A') ? 'checked' : '' ?> > Fazer com quem as pessoas gostem</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='7' value='I'  <?php echo (!empty($_POST)  AND $_POST['7'] == 'I') ? 'checked' : '' ?> > Fazer com que funcione</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='7' value='O'  <?php echo (!empty($_POST)  AND $_POST['7'] == 'O') ? 'checked' : '' ?> > Fazer com que aconteça</label>
					</div>
				</div>
			
				<div class="form-group col-sm">
					<h5>8. Eu prefiro...</h5>
					<div class='px-5'>
						<label class='form-check'><input class='form-check-input' type='radio' name='8' value='I'  <?php echo (!empty($_POST)  AND $_POST['8'] == 'I') ? 'checked' : '' ?> > Perguntas a respostas</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='8' value='O'  <?php echo (!empty($_POST)  AND $_POST['8'] == 'O') ? 'checked' : '' ?> > Ter todos os detalhes</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='8' value='A'  <?php echo (!empty($_POST)  AND $_POST['8'] == 'A') ? 'checked' : '' ?> > Vantagens a meu favor</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='8' value='C'  <?php echo (!empty($_POST)  AND $_POST['8'] == 'C') ? 'checked' : '' ?> > Que todos tenham a chance de ser ouvido</label>
					</div>
				</div>
				
				<div class="form-group col-sm">
					<h5>9. Eu gosto de...</h5>
					<div class='px-5'>
						<label class='form-check'><input class='form-check-input' type='radio' name='9' value='A'  <?php echo (!empty($_POST)  AND $_POST['9'] == 'A') ? 'checked' : '' ?> > Fazer progresso</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='9' value='C'  <?php echo (!empty($_POST)  AND $_POST['9'] == 'C') ? 'checked' : '' ?> > Construir memórias</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='9' value='O'  <?php echo (!empty($_POST)  AND $_POST['9'] == 'O') ? 'checked' : '' ?> > Fazer sentido</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='9' value='I'  <?php echo (!empty($_POST)  AND $_POST['9'] == 'I') ? 'checked' : '' ?> > Tornar as pessoas confortáveis</label>
					</div>
				</div>
			</fieldset>
			
			<fieldset class='border p-2 rounded m-2 row'>
				<div class="form-group col-sm">
					<h5>10. Eu gosto de chegar...</h5>
					<div class='px-5'>
						<label class='form-check'><input class='form-check-input' type='radio' name='10' value='A'  <?php echo (!empty($_POST)  AND $_POST['10'] == 'A') ? 'checked' : '' ?> > Na frente</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='10' value='C'  <?php echo (!empty($_POST)  AND $_POST['10'] == 'C') ? 'checked' : '' ?> > Junto</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='10' value='O'  <?php echo (!empty($_POST)  AND $_POST['10'] == 'O') ? 'checked' : '' ?> > Na hora</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='10' value='I'  <?php echo (!empty($_POST)  AND $_POST['10'] == 'I') ? 'checked' : '' ?> > Em outro lugar</label>
					</div>
				</div>
			
				<div class="form-group col-sm">
					<h5>11. Um ótimo dia para mim é quando...</h5>
					<div class='px-5'>
						<label class='form-check'><input class='form-check-input' type='radio' name='11' value='A'  <?php echo (!empty($_POST)  AND $_POST['11'] == 'A') ? 'checked' : '' ?> > Consigo fazer muitas coisas</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='11' value='C'  <?php echo (!empty($_POST)  AND $_POST['11'] == 'C') ? 'checked' : '' ?> > Me divirto com meus amigos</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='11' value='O'  <?php echo (!empty($_POST)  AND $_POST['11'] == 'O') ? 'checked' : '' ?> > Tudo segue conforme planejado</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='11' value='I'  <?php echo (!empty($_POST)  AND $_POST['11'] == 'I') ? 'checked' : '' ?> > Desfruto de coisas novas e estimulantes</label>
					</div>
				</div>
				
				<div class="form-group col-sm">
					<h5>12. Eu vejo a morte como...</h5>
					<div class='px-5'>
						<label class='form-check'><input class='form-check-input' type='radio' name='12' value='I'  <?php echo (!empty($_POST)  AND $_POST['12'] == 'I') ? 'checked' : '' ?> > Uma grande aventura misteriosa</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='12' value='C'  <?php echo (!empty($_POST)  AND $_POST['12'] == 'C') ? 'checked' : '' ?> > Oportunidade para rever os falecidos</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='12' value='O'  <?php echo (!empty($_POST)  AND $_POST['12'] == 'O') ? 'checked' : '' ?> > Um modo de receber recompensas</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='12' value='A'  <?php echo (!empty($_POST)  AND $_POST['12'] == 'A') ? 'checked' : '' ?> > Algo que sempe chega muito cedo</label>
					</div>
				</div>
			</fieldset>	
			
			<fieldset class='border p-2 rounded m-2 row'>
				<div class="form-group col-sm">
					<h5>13. Minha filosofia de vida é...</h5>
					<div class='px-5'>
						<label class='form-check'><input class='form-check-input' type='radio' name='13' value='A'  <?php echo (!empty($_POST)  AND $_POST['12'] == 'A') ? 'checked' : '' ?> > Há ganhadores e perdedores, e eu acredito ser um ganhador</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='13' value='C'  <?php echo (!empty($_POST)  AND $_POST['12'] == 'C') ? 'checked' : '' ?> > Para eu ganhar, niguém precisa perder</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='13' value='O'  <?php echo (!empty($_POST)  AND $_POST['12'] == 'O') ? 'checked' : '' ?> > Para ganhar é preciso seguir as regras</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='13' value='I'  <?php echo (!empty($_POST)  AND $_POST['12'] == 'I') ? 'checked' : '' ?> > Para ganhar, é necessário inventar novas regras</label>
					</div>
				</div>
			
				<div class="form-group col-sm">
					<h5>14. Eu sempre gostei de...</h5>
					<div class='px-5'>
						<label class='form-check'><input class='form-check-input' type='radio' name='14' value='I'  <?php echo (!empty($_POST)  AND $_POST['14'] == 'I') ? 'checked' : '' ?> > Explorar</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='14' value='O'  <?php echo (!empty($_POST)  AND $_POST['14'] == 'O') ? 'checked' : '' ?> > Evitar surpresas</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='14' value='A'  <?php echo (!empty($_POST)  AND $_POST['14'] == 'A') ? 'checked' : '' ?> > Focalizar a meta</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='14' value='C'  <?php echo (!empty($_POST)  AND $_POST['14'] == 'C') ? 'checked' : '' ?> > Realizar uma abordagem natural</label>
					</div>
				</div>
			
				<div class="form-group col-sm">		
					<h5>15. Eu gosto de mudanças se...</h5>	
					<div class='px-5'>	
						<label class='form-check'><input class='form-check-input' type='radio' name='15' value='A'  <?php echo (!empty($_POST)  AND $_POST['15'] == 'A') ? 'checked' : '' ?> > Me der uma vantagem competitiva</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='15' value='C'  <?php echo (!empty($_POST)  AND $_POST['15'] == 'C') ? 'checked' : '' ?> > For divertido e puder ser compartilhado</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='15' value='I'  <?php echo (!empty($_POST)  AND $_POST['15'] == 'I') ? 'checked' : '' ?> > Me der mais liberdade e variedade</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='15' value='O'  <?php echo (!empty($_POST)  AND $_POST['15'] == 'O') ? 'checked' : '' ?> > Melhorar ou me der mais controle</label>
					</div>	
				</div>		
			</fieldset>	

			<fieldset class='border p-2 rounded m-2 row'>		
				<div class="form-group col-sm">		
					<h5>16. Não existe nada de errado em...</h5>	
					<div class='px-5'>	
						<label class='form-check'><input class='form-check-input' type='radio' name='16' value='A'  <?php echo (!empty($_POST)  AND $_POST['16'] == 'A') ? 'checked' : '' ?> > Se colocar na frente</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='16' value='C'  <?php echo (!empty($_POST)  AND $_POST['16'] == 'C') ? 'checked' : '' ?> > Colocar os outros na frente</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='16' value='I'  <?php echo (!empty($_POST)  AND $_POST['16'] == 'I') ? 'checked' : '' ?> > Mudar de idéia</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='16' value='O'  <?php echo (!empty($_POST)  AND $_POST['16'] == 'O') ? 'checked' : '' ?> > Ser consistente</label>
					</div>	
				</div>		
			
				<div class="form-group col-sm">		
					<h5>17. Eu gosto de buscar conselhos de...</h5>	
					<div class='px-5'>	
						<label class='form-check'><input class='form-check-input' type='radio' name='17' value='A'  <?php echo (!empty($_POST)  AND $_POST['17'] == 'A') ? 'checked' : '' ?> > Pessoas bem sucedidas</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='17' value='C'  <?php echo (!empty($_POST)  AND $_POST['17'] == 'C') ? 'checked' : '' ?> > Anciões e conselheiros</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='17' value='O'  <?php echo (!empty($_POST)  AND $_POST['17'] == 'O') ? 'checked' : '' ?> > Autoridades no assunto</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='17' value='I'  <?php echo (!empty($_POST)  AND $_POST['17'] == 'I') ? 'checked' : '' ?> > Lugares, os mais estranhos</label>
					</div>	
				</div>		
			
				<div class="form-group col-sm">		
					<h5>18. Meu lema é...</h5>	
					<div class='px-5'>	
						<label class='form-check'><input class='form-check-input' type='radio' name='18' value='I'  <?php echo (!empty($_POST)  AND $_POST['18'] == 'I') ? 'checked' : '' ?> > Fazer o que precisa ser feito</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='18' value='O'  <?php echo (!empty($_POST)  AND $_POST['18'] == 'O') ? 'checked' : '' ?> > Fazer bem feito</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='18' value='C'  <?php echo (!empty($_POST)  AND $_POST['18'] == 'C') ? 'checked' : '' ?> > Fazer junto com o grupo</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='18' value='A'  <?php echo (!empty($_POST)  AND $_POST['18'] == 'A') ? 'checked' : '' ?> > Simplesmente fazer</label>
					</div>	
				</div>		
			</fieldset>			

			<fieldset class='border p-2 rounded m-2 row'>		
				<div class="form-group col-sm">		
					<h5>19. Eu gosto de...</h5>	
					<div class='px-5'>	
						<label class='form-check'><input class='form-check-input' type='radio' name='19' value='I'  <?php echo (!empty($_POST)  AND $_POST['19'] == 'I') ? 'checked' : '' ?> > Complexidade, mesmo se confuso</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='19' value='O'  <?php echo (!empty($_POST)  AND $_POST['19'] == 'O') ? 'checked' : '' ?> > Ordem e sistematização</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='19' value='C'  <?php echo (!empty($_POST)  AND $_POST['19'] == 'C') ? 'checked' : '' ?> > Calor humano e animação</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='19' value='A'  <?php echo (!empty($_POST)  AND $_POST['19'] == 'A') ? 'checked' : '' ?> > Coisas claras e simples</label>
					</div>	
				</div>		
			
				<div class="form-group col-sm">		
					<h5>20. Tempo para mim é...</h5>	
					<div class='px-5'>	
						<label class='form-check'><input class='form-check-input' type='radio' name='20' value='A'  <?php echo (!empty($_POST)  AND $_POST['20'] == 'A') ? 'checked' : '' ?> > Algo que detesto disperdiçar</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='20' value='C'  <?php echo (!empty($_POST)  AND $_POST['20'] == 'C') ? 'checked' : '' ?> > Um grande ciclo</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='20' value='O'  <?php echo (!empty($_POST)  AND $_POST['20'] == 'O') ? 'checked' : '' ?> > Uma flecha que leva ao inevitável</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='20' value='I'  <?php echo (!empty($_POST)  AND $_POST['20'] == 'I') ? 'checked' : '' ?> > Irrelevante</label>
					</div>	
				</div>		
			
				<div class="form-group col-sm">		
					<h5>21. Se eu fosse biblionário...</h5>	
					<div class='px-5'>	
						<label class='form-check'><input class='form-check-input' type='radio' name='21' value='C'  <?php echo (!empty($_POST)  AND $_POST['21'] == 'C') ? 'checked' : '' ?> > Faria doações para muitas entidades</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='21' value='O'  <?php echo (!empty($_POST)  AND $_POST['21'] == 'O') ? 'checked' : '' ?> > Criaria uma poupança avantajada</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='21' value='I'  <?php echo (!empty($_POST)  AND $_POST['21'] == 'I') ? 'checked' : '' ?> > Faria o que desse na cabeça</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='21' value='A'  <?php echo (!empty($_POST)  AND $_POST['21'] == 'A') ? 'checked' : '' ?> > Exibiria bastante com algumas pessoas</label>
					</div>	
				</div>		
			</fieldset>			

			<fieldset class='border p-2 rounded m-2 row'>		
				<div class="form-group col-sm">		
					<h5>22. Eu acredito que...</h5>	
					<div class='px-5'>	
						<label class='form-check'><input class='form-check-input' type='radio' name='22' value='A'  <?php echo (!empty($_POST)  AND $_POST['22'] == 'A') ? 'checked' : '' ?> > O destino é mais importante que a jornada</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='22' value='C'  <?php echo (!empty($_POST)  AND $_POST['22'] == 'C') ? 'checked' : '' ?> > A jornada é mais importante que o destino</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='22' value='O'  <?php echo (!empty($_POST)  AND $_POST['22'] == 'O') ? 'checked' : '' ?> > Um centavo economizado é um centavo ganho</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='22' value='I'  <?php echo (!empty($_POST)  AND $_POST['22'] == 'I') ? 'checked' : '' ?> > Bastam um navio e uma estrela para navegar</label>
					</div>	
				</div>		
			
				<div class="form-group col-sm">		
					<h5>23. Eu acredito também que...</h5>	
					<div class='px-5'>	
						<label class='form-check'><input class='form-check-input' type='radio' name='23' value='A'  <?php echo (!empty($_POST)  AND $_POST['23'] == 'A') ? 'checked' : '' ?> > Aquele que hesita está perdido</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='23' value='O'  <?php echo (!empty($_POST)  AND $_POST['23'] == 'O') ? 'checked' : '' ?> > De grão em grão a galinha enche o papo</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='23' value='C'  <?php echo (!empty($_POST)  AND $_POST['23'] == 'C') ? 'checked' : '' ?> > O que vai, volta</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='23' value='I'  <?php echo (!empty($_POST)  AND $_POST['23'] == 'I') ? 'checked' : '' ?> > Um sorriso ou uma careta é o mesmo para quem e cego</label>
					</div>	
				</div>		
			
				<div class="form-group col-sm">		
					<h5>24. Eu acredito ainda que...</h5>	
					<div class='px-5'>	
						<label class='form-check'><input class='form-check-input' type='radio' name='24' value='O'  <?php echo (!empty($_POST)  AND $_POST['24'] == 'O') ? 'checked' : '' ?> > É melhor prudência do que arrependimento</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='24' value='I'  <?php echo (!empty($_POST)  AND $_POST['24'] == 'I') ? 'checked' : '' ?> > A autoridade deve ser desafiada</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='24' value='A'  <?php echo (!empty($_POST)  AND $_POST['24'] == 'A') ? 'checked' : '' ?> > Ganhar é fundamental</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='24' value='C'  <?php echo (!empty($_POST)  AND $_POST['24'] == 'C') ? 'checked' : '' ?> > O coletivo é mais importante do que o individual</label>
					</div>	
				</div>		
			</fieldset>			

			<fieldset class='border p-2 rounded m-2 row'>	
				<div class="form-group col-sm">		
					<h5>25. Eu penso que...</h5>	
					<div class='px-5'>	
						<label class='form-check'><input class='form-check-input' type='radio' name='25' value='I'  <?php echo (!empty($_POST)  AND $_POST['25'] == 'I') ? 'checked' : '' ?> > Não é fácil ficar encurralado</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='25' value='O'  <?php echo (!empty($_POST)  AND $_POST['25'] == 'O') ? 'checked' : '' ?> > É preferível olhar, antes de pular</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='25' value='C'  <?php echo (!empty($_POST)  AND $_POST['25'] == 'C') ? 'checked' : '' ?> > Duas cabeças pensam melhor do que uma</label>
						<label class='form-check'><input class='form-check-input' type='radio' name='25' value='A'  <?php echo (!empty($_POST)  AND $_POST['25'] == 'A') ? 'checked' : '' ?> > Se você não tem condições de competir, não compita</label>
					</div>	
				</div>		
			</fieldset>			

			<div class="form-group row">
				<div class='col-sm'>
					<button class='btn btn-success form-control' title = 'Salvar'>Salvar</button>
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