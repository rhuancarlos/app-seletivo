<!-- Contact Us Section -->
<div ng-controller="AgendamentoController">
  <section id="" class="">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="section-title-header text-center">
            <h1 class="section-title wow fadeInUp" data-wow-delay="0.2s">
              <a href="<?= base_url()?>"><?= $elementos_pagina['titulo']; ?></a>
            </h1>
            <h5 ng-if="dataDefault.dia_celebracao">Data da celebração {{dataDefault.dia_celebracao}} </h5>
            <h5 ng-bind-html="contentVagas" ng-class="{'vagas-disponiveis': dataDefault.situacao_vagas, 'vagas-indisponiveis': !dataDefault.situacao_vagas}"></h5>
            <span class="badge badge-pill badge-primary" style="cursor: pointer;" ng-click="getVagancyCount()">
              <i class="fas fa-sync-alt"></i> Atualizar vagas
            </span>
          </div>
        </div>
        <!-- {{allData}} -->
        <div class="col-lg-7 col-md-12 col-xs-12" id="boxStages" ng-if="(dataDefault.situacao_vagas && (dataDefault.habilitar_agendamento))">
          <div class="container-form wow fadeInLeft" data-wow-delay="0.2s">
            <form name="formAgendamento">
              <div class="form-wrapper" ng-if="screenStage == 1">
                <div class="row">
                  <div class="col-md-12 col-sm-12 text-inicial" style="text-align:justify;">
                    <?= $elementos_pagina['conteudoStages']['stage1']['texto_area_principal']; ?>
                  </div>
                </div>
              </div>
              <div class="form-wrapper" ng-if="screenStage == 2">
                <div class="row">
                  <div class="content-section">
                    <h4 class="text-center"><?= $elementos_pagina['conteudoStages']['stage2']['title']; ?></h4>
                    <div class="form-group">
                      <label for="nome_completo">NOME COMPLETO *</label>
                      <input type="text" name="nome_completo" id="nome_completo" minlength="12" maxlength="50" class="form-control" placeholder="seu nome completo (sem abreviações) " required ng-model="dadosAgendamento.dados_pessoais.nome_completo" onkeyup="convertUppercase(this)">
                      <span class="error" ng-show="!formAgendamento.nome_completo.$valid && !formAgendamento.nome_completo.$error.required">preenchimento incompleto!</span>
                      <span class="error" ng-show="formAgendamento.nome_completo.$error.required">preenchimento obrigatório!</span>
                    </div>
                    <div class="form-group" ng-if="dataDefault.validar_autenticidade_por == 'cpf'">
                      <label for="cpf">CPF <i class="fa fa-question-circle" aria-hidden="true" ng-click="infoInput('cpf')"></i> *</label>
                      <input type="text" name="cpf" minlength="11" maxlength="11" placeholder="..........." pattern="[0-9]+$" id="cpf" class="form-control" required ng-model="dadosAgendamento.dados_pessoais.cpf">
                      <span class="error" ng-show="formAgendamento.cpf.$error.required">preenchimento obrigatório!</span>
                      <span class="error" ng-show="!formAgendamento.cpf.$valid && !formAgendamento.cpf.$error.required">cpf inválido!</span>
                    </div>
                    <div class="form-group">
                      <label for="email">EMAIL *</label>
                      <input type="email" name="email" id="email" class="form-control" placeholder="exemplo@exemplo.com" required ng-model="dadosAgendamento.dados_pessoais.email">
                      <span class="error" ng-show="!formAgendamento.email.$valid && !formAgendamento.email.$error.required">e-mail inválido</span>
                      <span class="error" ng-show="formAgendamento.email.$error.required">preenchimento obrigatório!</span>
                    </div>
                    <div class="form-group">
                      <label for="telefone">TELEFONE <i class="fab fa-whatsapp" style="color: green;"></i> *</label>
                      <input type="text" name="telefone" id="telefone" minlength="11" maxlength="11" class="form-control" placeholder=".. ..... ...." required ng-model="dadosAgendamento.dados_pessoais.telefone">
                      <span class="error" ng-show="formAgendamento.telefone.$error.required">preenchimento obrigatório!</span>
                      <span class="error" ng-show="!formAgendamento.telefone.$valid && !formAgendamento.telefone.$error.required">telefone inválido!</span>
                    </div>
                    <div class="form-group">
                      <label for="descendencia">SOU DA DESCENDÊNCIA *</label>
                      <select name="descendencia" id="descendencia" class="form-control" required ng-model="dadosAgendamento.dados_pessoais.descendencia">
                        <option value="" selected> Seleciona uma opção</option>
                        <? foreach ($elementos_pagina['conteudoStages']['stage2']['descendencia'] as $key => $descendencia) { ?>
                          <option value="<?= $key; ?>"><?= $key != 'FV' ? $key.' - ':''?> <?= $descendencia ?></option>
                        <? } ?>
                      </select>
                      <span class="error" ng-show="formAgendamento.descendencia.$error.required">preenchimento obrigatório!</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-wrapper" ng-if="screenStage == 3">
                <div class="row">
                  <div class="content-section" style="width: 100%;">
                    <h4 class="text-center"><?= $elementos_pagina['conteudoStages']['stage3']['title']; ?></h4>
                    <div class="row">
                      <div class="col-md-12 col-sm-12 text-inicial" style="text-align:center;">
                        <?= $elementos_pagina['conteudoStages']['stage3']['texto_area_principal']; ?>
                      </div><br><br>
                      <div class="form-group table-responsive col-sm-12 col-lg-12" style="text-align:center; margin-top: 34px;">
                        <label for="">QUAL CULTO VOCÊ DESEJA IR ?</label>
                        <table class="table table-hover">
                          <thead>
                            <tr></tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>DOMINGO</td>
                              <td><input type="radio" value="16:00" name="cultoHorario" required id="cultoHorario_16" ng-model="dadosAgendamento.dados_pessoais.culto_horario"> 16H</td>
                              <!-- <td><input type="radio" value="18:00" name="cultoHorario" required id="cultoHorario_18" ng-model="dadosAgendamento.dados_pessoais.culto_horario"> 18H</td> -->
                            </tr>
                          </tbody>
                        </table>
                        <span class="error" ng-show="formAgendamento.cultoHorario.$error.required">preenchimento obrigatório!</span>
                      </div>
                      <div class="form-group col-sm-12 col-lg-12" style="text-align:center; margin-top: 34px;">
                        <label for="descendencia">QUANTAS PESSOAS IRÃO COM VOCÊ? *</label>
                        <?= $elementos_pagina['conteudoStages']['stage3']['texto_area_qtd_pessoas']; ?>
                        <select name="qtd_pessoas" id="qtd_pessoas" class="form-control" required ng-model="dadosAgendamento.dados_pessoais.qtd_pessoas">
                          <option value="" selected> Seleciona uma opção</option>
                          <? for($i = 0; $i < 6; $i++) { ?>
                            <option value="<?= $i; ?>"><?= $i ?></option>
                          <? } ?>
                        </select>
                        <span class="error" ng-show="formAgendamento.qtd_pessoas.$error.required">preenchimento obrigatório!</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-wrapper" ng-if="screenStage == 4">
                <div class="row">
                  <div class="content-section" style="width: 100%;">
                    <div class="alert alert-warning">
                      <div class="text-center"><strong> Dicas Importante !</strong></div>
                      <small>
                        <p> - Após a finalização do agendamento você receberá no email informado uma mensagem de confirmação. Tenha atenção no preenchimento, verifique a caixa de SPAM e LIXEIRA.</p>
                        <p> - Este agendamento será valido apenas para a celebração <strong>{{dataDefault.dia_celebracao}}</strong>. Desta forma você deverá realizar um novo agendamento para novas celebrações.</p>
                        <p> - Caso não receba o e-mail de confirmação <b> favor entre em contato com a IBN Filadélfia</b> atráves no canal de whatsapp em nosso <a href="https://ibnfiladelfia.com.br" target="_blank">site</a>.</p>
                      </small>
                    </div>
                    <div class="text-center">
                      <h4>Estamos quase lá ...</h4>  
                      <p> Para concluir clique em Finalizar.</p>
                      <button ng-click="cancelScheduling()" class="btn btn-danger btn-rm" id="btnCancelStage">Cancelar</button>
                      <button ng-click="finishScheduling(dadosAgendamento.dados_pessoais)" class="btn btn-success btn-rm" id="btnFinishStage">Finalizar</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="row">
            <div class="col col-lg-9">
              <button ng-click="backScreenStage(screenStage)" class="btn btn-light btn-rm" style="margin-right: 5px;" id="btnBackStage" ng-disabled="screenStage == 1">Voltar</button>
              <button ng-click="nextScreenStage(screenStage, dadosAgendamento.dados_pessoais)" class="btn btn-light btn-rm" id="btnNextStage" ng-disabled="checkNextStage(screenStage, formAgendamento.$error)">Próximo</button>
            </div>
            <div class="col col-lg-3">
              Página {{screenStage}} de {{screenLimiteStage}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- Contact Us Section End -->