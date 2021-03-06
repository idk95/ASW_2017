<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- custom css -->
<link rel="stylesheet" type="text/css" href="custom/css/dashboard.css">
<div class="coponentCont container">
    <div class="row page-header">
        <div id="titleGame" class="col-xs-12 col-md-8">
            <h2 id="TipoLetra"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard</h2>
        </div>
        <div class="OpcoesPartidas col-xs-12 col-md-4">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#EditPart">Criar partida</button>
        </div>
    </div>
    <!-- tabela historico -->
    <div class="alert alert-danger" id="erroGame" role="alert"><strong>Erro! </strong><span id="erroGame-msg"></span></div>
    <div class="TabelaJogos">
        <!-- advanced search -->
            <form class="form-inline" id="advancedSearch" onsubmit="event.preventDefault(); return adv_Search();">
                <div class="form-group">
                    <label for="creator">Criador:</label>
                    <select id="creator" class="form-control adv_search_fields distAdm">
                        <option value="NULL">Não Selecionado</option>
                        <?php echo $gamesOwner; ?>
                    </select>
                </div>
                <div id="ageGroup" class="form-group">
                    <div class="form-group">
                        <label for="numPlayers">Número de Jogadores de:</label>
                        <input type="number" min="1" max="9" step="1" value="2" class="form-control adv_search_fields" id="numPlayers" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="numPlayersTill">Até:</label>
                        <input type="number" min="2" max="10" step="1" value="10" class="form-control adv_search_fields" id="numPlayersTill" autocomplete="off">
                    </div>
                </div>
                <div id="ageGroup" class="form-group">
                    <div class="form-group">
                        <label for="InputBet">Aposta mínima de:</label>
                        <input type="number" min="0" step="0.01" class="form-control adv_search_fields" id="InputBet" autocomplete="off">
                    </div>
                    <div class="form-group" id="betTill">
                        <label for="InputBetTill">Até:</label>
                        <input type="number" min="0" step="0.01" class="form-control adv_search_fields" id="InputBetTill" autocomplete="off">
                    </div>
                </div>
                <div id="ageGroup" class="form-group">
                    <div class="form-group">
                        <label for="InputBegin">Início do jogo:</label>
                        <input type="text" class="form-control adv_search_fields" id="InputBegin" autocomplete="off">
                    </div>
                    <div class="form-group" id="beginTill">
                        <label for="InputBeginTill">Até:</label>
                        <input type="text" class="form-control adv_search_fields" id="InputBeginTill" autocomplete="off">
                    </div>
                </div>
                <button type="submit" class="btn btn-default" id="searchAdv_btn">Busca</button>
            </form>
        <table id="jogos" class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Início</th>
                    <th>Dono</th>
                    <th>Pessoas</th>
                    <th>Pessoas máximo</th>
                    <th>Primeira Aposta</th>
                    <th>Aposta Maxima</th>
                    <th>Timeout</th>
                    <th>Estado</th>
                    <th id="opDash">Opções</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <!-- modal para editar partidas -->
    <div class="modal fade" id="EditPart" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Criar Partida</h4>
                </div>
                <form id="createGame-Form" onsubmit="event.preventDefault(); return createGame();" method="post" action="<?php base_url(); ?>index.php/game/create">
                    <div class="modal-body">
                        <div class="alert alert-success" id="alertSuccess" role="alert">
                            <strong>Sucesso! </strong><span class="message"></span>
                        </div>
                        <div class="alert alert-danger" id="alertSuccess" role="alert">
                            <strong>Erro! </strong><span class="message"></span>
                        </div>
                            <div class="form-group">
                                <label for="nomeJogo">Nome do jogo</label>
                                <input type="text" class="form-control" id="gameName" name="name">
                            </div>
                            <div class="form-group">
                                <label for="descricaoJogo">Descrição</label>
                                <textarea type="text" class="form-control" id="gameDiscription" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="jogoNum">Nº de jogadores</label>
                                <select class="form-control" name="numberPeople">
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="FirstBet">Primeria aposta</label>
                                <input type="text" class="form-control" id="aposta" value="20" name="firstBet">
                            </div>
                            <!--no limit, pote limit, limit -->
                            <div class="form-group">
                                <label for="MaxBet">Maximo valor da aposta</label>
                                <input type="text" class="form-control" id="maxAposta" value="200" name="maxBet">
                            </div>
                            <div class="form-group">
                                <label for="TimeOut" id="timeOut">Timeout (segundos)</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox" aria-label="timeOut" id="TimeOutCheck" name="TimeOutCheck">
                                    </span>
                                    <input type="number" min="10" step="1" id="TimeOut" class="form-control" aria-label="timeOut" name="TimeOut" value="120" disabled>
                                </div><!-- /input-group -->
                            </div>
                            <!--meter a escolher horas -->
                          <!--   <div class="form-group">
                                <label for="BeginHour">Hora de inicio do jogo</label>
                                <input type="text" class="form-control" id="hours" name="beginHour">
                            </div>
                            <div class="form-group">
                                <label for="condEsp">Condicoes para entrar no jogo</label>
                                <input type="radio" id="ageMin" class="form-control" name="CondEsp">
                                <input type="text" class="form-control" id="AgeMin" value="18" name="CondEsp">

                                <input type="radio" id="minBalance" class="form-control" name="CondEsp">
                                <input type="text" class="form-control" id="MinBalance" value="20" name="CondEsp">
                            </div> -->

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save changes">
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

<!-- custom js -->
<script type="text/javascript" src="custom/js/dashboard.js"></script>
