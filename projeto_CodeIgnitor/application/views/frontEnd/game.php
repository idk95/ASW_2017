<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- custom css -->
<link rel="stylesheet" type="text/css" href="custom/css/game.css">
<div id="main">
	<div id="cont-Body">
		<div id="gameBody">
			<div class="container-alerts">
				<div class="alert alert-warning" id="warningGame" role="alert"><strong>Aviso! </strong><span id="warningGame-msg"></span></div>
				<div class="alert alert-danger" id="erroGame" role="alert"><strong>Erro! </strong><span id="erroGame-msg"></span></div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-4">
					<div id="messa-game">
						<p class="turn-play" >É a sua vez de jogar</p>
						<p class="mesa-creditos" >créditos disponiveis</p>
					</div>
					<div id="botoes_game" class="btn-group-vertical" role="group" aria-label="...">
						<button type="button" id="desistir" class="btn btn-danger">Desistir</button>
						<button type="button" id="cobrir_aposta" class="btn btn-warning">Cobrir a aposta(10 créditos)</button>
					</div>
					<div class="input-group">
						<input id="aumentValue" type="number" class="form-control"  placeholder="Aumentar para">
						<span class="input-group-btn">
							<button id="aumentSend" type="button" class="btn btn-default">Aumentar</button>
      					</span>
					</div>
					<button class="btn btn-primary" id="chat" type="button">
						Chat <span class="badge">4</span>
					</button>
				</div>
				<div class="col-xs-12 col-md-8">
					<table id="table_game" class="table">
					    <tbody>
					      	<tr id="InitialTime">
					        	<td><b>Início</b><span id="start-Game"></span></td>
					      	</tr>
					      	<tr id="ActualPlayer">
					        	<td><b>Jogador atual</b><span id="nowPlayer-Game"></span></td>
					      	</tr>
					      	<tr id="BoardCards">
					        	<td><b>Cartas da mesa</b><span id="boardCards-Game"></span></td>
					      	</tr>
							<tr id="MyCards">
								<td><b>Minhas cartas</b><span id="myCars-Game"></span></td>
							</tr>
							<tr id="ActualBet">
								<td><b>Aposta atual</b><span id="actualBet-Game"></span></td>
							</tr>
							<tr>
								<td id="PlayersBet"><b>Aposta de cada jogador</b></td>
							</tr>
					    </tbody>
			  		</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- CUSTOM JS -->
<script type="text/javascript">
	var gameId = "<?php echo $_GET['id']; ?>";
</script>
<script type="text/javascript" src="custom/js/game.js"></script>