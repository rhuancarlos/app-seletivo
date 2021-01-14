<!doctype html>
<html ng-cloak ng-app="paineladmin">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>PAINEL ADMINISTRATIVO</title>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        body {
            padding-top: 5rem;
        }
        .starter-template {
            padding: 3rem 1.5rem;
            text-align: center;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <input type="hidden" value="<?= base_url(); ?>" id="base_url" name="base_url">
    <script src="<?= base_url('public/js/angularjs/angular.js');?>"></script>
    <script src="<?= base_url('public/js/angularjs/i18n/angular-locale_pt-br.js');?>"></script>
    <script src="<?= base_url('public/js/angularjs/angular-animate.js');?>"></script>
    <script src="<?= base_url('public/js/painel/PainelController.js');?>"></script>
    <script src="<?= base_url('public/js/painel/PainelService.js');?>"></script>
    <script src="<?= base_url('public/js/configValue2.js');?>"></script>
    <script src="<?= base_url('public/libs/sweetalert/js/sweetalert2.all.min.js');?>"></script>
  </head>
  <body ng-controller="PainelController">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">ADM SELETIVO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= base_url('/administrador.php/painel')?>">INICIO </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" ng-click="getInscricoes()">INSCRIÇÕES</a>
                </li>
                <li class="nav-item pull-right">
                    <a class="nav-link" href="<?= base_url('/administrador.php/login/sair')?>">SAIR (<?= $this->rsession->get('user_name');?>)</a>
                </li>
            </ul>
        </div>
    </nav>
    <main role="main" class="container">
        <div class="starter-template">
            <div class="animate-if" ng-if="display == 'inscricoes'">
            <h3> Lista de Alunos Inscritos <i class="fa fa-refresh" aria-hidden="true" style="cursor: pointer;" ng-click="getInscricoes()" title="Atualizar"></i> </h3>
            <div class="col-md-2">Total de inscrições: {{listaInscricoes.length}}</div> 
            <div class="col-md-4"><input type="text" class="form-control" name="searh" id="searh" ng-model="searh" placeholder="Pesquisar"></div>
                <table class="table table-hover" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col" style="text-align: left;">NOME DO ALUNO</th>
                            <th scope="col" style="text-align: left;">SERIE</th>
                            <th scope="col" style="text-align: left;">FONE</th>
                            <th scope="col" style="text-align: left;">EMAIL</th>
                            <th scope="col" style="text-align: left;">DAT.INSCRIÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in listaInscricoes | filter:searh:strict track by $index">
                            <td>{{item.idinscricao}}</td>
                            <td style="text-align: left;">{{item.nome_completo}}</td>
                            <td style="text-align: left;">{{item.serie_descricao_completa}}</td>
                            <td style="text-align: left;">{{item.telefone}}</td>
                            <td style="text-align: left;">{{item.email}}</td>
                            <td style="text-align: left;">{{item.created}}</td>
                            <td>
                                <i class="fa fa-pencil" aria-hidden="true" style="cursor: pointer;" ng-click="editItem(item)"></i>
                                <i class="fa fa-trash-o" aria-hidden="true" style="cursor: pointer;" ng-click="removerItem(item)"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="animate-if" ng-if="display == 'manutencao_registro'">
                <h4 class="text-center">Atualização de Cadastro #{{dadosRegistro.idinscricao}}</h4>
                <form name="formInscricao" novalidate>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="nome_completo">CÓDIGO DE INSCRIÇÃO *</label>
                            <input type="text" class="form-control" disabled ng-model="dadosRegistro.token">
                        </div>
                        <div class="col-md-9">
                            <label for="nome_completo">NOME ALUNO *</label>
                            <input type="text" name="nome_completo" id="nome_completo" minlength="12" maxlength="50" class="form-control" placeholder="seu nome completo (sem abreviações) " required ng-model="dadosRegistro.nome_completo">
                        </div>
                        <div class="col-md-8">
                            <label for="email">EMAIL *</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="exemplo@exemplo.com" required ng-model="dadosRegistro.email" style="text-transform:none;">
                        </div>
                        <div class="col-md-4">
                            <label for="telefone">TELEFONE <i class="fa fa-whatsapp" style="color: green;"></i> *</label>
                            <input type="text" name="telefone" id="telefone" minlength="11" maxlength="11" class="form-control" placeholder=".. ..... ...." required ng-model="dadosRegistro.telefone">
                        </div>
                        <div class="col-md-4">
                            <label for="colegio_atual">COLÉGIO ATUAL *</label>
                            <input type="text" name="colegio_atual" id="colegio_atual" minlength="12" maxlength="50" class="form-control" placeholder="informe sua instituição de ensino atual " required ng-model="dadosRegistro.colegio_atual">
                        </div>
                        <div class="col-md-4">
                            <label for="serie">SÉRIE *</label>
                            <select name="serie" id="serie" class="form-control" required ng-model="dadosRegistro.serie">
                                <option value="" selected> Seleciona uma opção</option>
                                <option value="{{index}}" ng-repeat="(index, curso) in listaCursos">{{curso}}</option>
                            </select>
                            <span class="error" ng-show="formAgendamento.serie.$error.required">preenchimento obrigatório!</span>
                        </div>
                        <div class="col-md-4">
                            <label for="serie">COMO SOUBE DA VAGA ?</label>
                            <input type="text" name="como_ficou_sabendo" id="como_ficou_sabendo" class="form-control" disabled ng-model="dadosRegistro.como_ficou_sabendo">
                        </div>
                    </div>
                </form>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn btn-secondary " style="margin-right: 5px;" id="btnBackStage" ng-click="getInscricoes()">Voltar</button>
                        <button ng-click="salvarAlteracoes(dadosRegistro)" class="btn btn-success " id="btnFinishStage">Salvar Alterações</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
  </body>
</html>
