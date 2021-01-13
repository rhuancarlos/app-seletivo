<!-- Contact Us Section -->
<div ng-controller="AgendamentoController">
  <section id="" class="">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="section-title-header text-center">
            <h1 class="section-title wow fadeInUp" data-wow-delay="0.2s">
              <img src="https://i2.wp.com/vivario.org.br/wordpress/wp-content/uploads/2019/06/processo_seletivo-270x246.png?fit=270%2C246&w=240" class="logo-igreja" style="width: 85px;margin-left: -30px;">
              <a href="<?= base_url()?>" class="titlepage"><?= $elementos_pagina['titulo']; ?></a>
            </h1>
          </div>
        </div>
        <!-- {{allData}} -->
        <div class="col-lg-7 col-md-12 col-xs-12" id="boxStages" >
          <div class="container-form wow fadeInLeft" data-wow-delay="0.2s">
            <form name="formAgendamento">
              <!-- Start Stage 1 -->
              <div class="form-wrapper animate-if" ng-if="screenStage == 1" style="padding: 5px;">
                <div class="row">
                  <div class="col-md-12 col-sm-12 text-inicial" style="text-align:justify;">
                    <?= $elementos_pagina['conteudoStages']['stage1']['texto_area_principal']; ?>
                  </div>
                </div>
              </div>
              <!-- End Stage 1 -->
              
              <!-- Nome do Aluno, E-mail, Telefone, Colégio Atual, Série e "Onde Ficou Sabendo? -->
              <!-- Start Stage 2 -->
              <div class="form-wrapper animate-if" ng-if="screenStage == 2">
                <div class="row">
                  <div class="content-section">
                    <h4 class="text-center"><?= $elementos_pagina['conteudoStages']['stage2']['title']; ?></h4>
                    <div class="form-group">
                      <label for="nome_completo">NOME ALUNO *</label>
                      <input type="text" name="nome_completo" id="nome_completo" minlength="12" maxlength="50" class="form-control" placeholder="seu nome completo (sem abreviações) " required ng-model="dadosAgendamento.dados_pessoais.nome_completo" onkeyup="convertUppercase(this)">
                      <span class="error" ng-show="!formAgendamento.nome_completo.$valid && !formAgendamento.nome_completo.$error.required">preenchimento incompleto!</span>
                      <span class="error" ng-show="formAgendamento.nome_completo.$error.required">preenchimento obrigatório!</span>
                    </div>
                    <div class="form-group">
                      <label for="email">EMAIL *</label>
                      <input type="email" name="email" id="email" class="form-control" placeholder="exemplo@exemplo.com" required ng-model="dadosAgendamento.dados_pessoais.email" style="text-transform:none;">
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
                      <label for="colegio_atual">COLÉGIO ATUAL *</label>
                      <input type="text" name="colegio_atual" id="colegio_atual" minlength="12" maxlength="50" class="form-control" placeholder="informe sua instituição de ensino atual " required ng-model="dadosAgendamento.dados_pessoais.colegio_atual" onkeyup="convertUppercase(this)">
                      <span class="error" ng-show="!formAgendamento.colegio_atual.$valid && !formAgendamento.colegio_atual.$error.required">preenchimento incompleto!</span>
                      <span class="error" ng-show="formAgendamento.colegio_atual.$error.required">preenchimento obrigatório!</span>
                    </div>
                    <div class="form-group">
                      <label for="serie">SÉRIE *</label>
                      <select name="serie" id="serie" class="form-control" required ng-model="dadosAgendamento.dados_pessoais.serie">
                        <option value="" selected> Seleciona uma opção</option>
                        <?php foreach ($elementos_pagina['conteudoStages']['stage2']['serie'] as $key => $serie) { ?>
                          <option value="<?= $key; ?>"> <?= $serie ?></option>
                        <?php } ?>
                      </select>
                      <span class="error" ng-show="formAgendamento.serie.$error.required">preenchimento obrigatório!</span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Stage 2 -->
             
             <!-- Start Stage 3 -->
              <div class="form-wrapper animate-if" ng-if="screenStage == 3">
                <div class="row">
                  <div class="content-section" style="width: 100%;">
                    <div class="text-center">
                      <h4>Estamos quase lá ...</h4>  
                      <p> Revise seus Dados e clique em <b>Finalizar para concluir</b>.</p>
                      <button ng-click="cancelScheduling()" class="btn btn-danger btn-rm" id="btnCancelStage">Cancelar</button>
                      <button ng-click="finishScheduling(dadosAgendamento)" class="btn btn-success btn-rm" id="btnFinishStage">Finalizar Inscrição</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Stage 3 -->
            </form>
          </div>
          <div class="row">
            <div class="col col-lg-9">
              <span ng-if="screenStage != 'myData'" class="animate-if"> 
                <button ng-click="backScreenStage(screenStage)" class="btn btn-light btn-rm" style="margin-right: 5px;" id="btnBackStage" ng-disabled="screenStage == 1">Voltar</button>
                <button ng-click="nextScreenStage(screenStage, dadosAgendamento.dados_pessoais)" class="btn btn-light btn-rm" id="btnNextStage" ng-disabled="checkNextStage(screenStage, formAgendamento.$error)">Próximo</button>
              </span>
              <span ng-if="screenStage == 'myData'" class="animate-if"> 
                <button ng-click="backScreenStage('myData')" class="btn btn-dark btn-rm" style="margin-right: 5px;">Voltar</button>
              </span>            </div>
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