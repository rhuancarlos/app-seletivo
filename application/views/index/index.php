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
        <div class="col-lg-7 col-md-12 col-xs-12" id="boxStages" ng-if="dataDefault.habilitar_agendamento">
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
              
              <!-- Start Stage 2 -->
              <div class="form-wrapper animate-if" ng-if="screenStage == 2">
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
                      <input type="text" name="cpf" minlength="11" maxlength="11" placeholder="..........." pattern="[0-9]+$" id="cpf" class="form-control" required ng-model="dadosAgendamento.dados_pessoais.cpf" ng-change="checkCPF(dadosAgendamento.dados_pessoais.cpf, formAgendamento)">
                      <span class="error" ng-show="formAgendamento.cpf.$error.required">preenchimento obrigatório!</span>
                      <span class="error" ng-show="!formAgendamento.cpf.$valid && !formAgendamento.cpf.$error.required || (formAgendamento.cpf.$valid && !cpfValid)">cpf inválido!</span>
                    </div>
                    <div class="form-group">
                      <label for="email">EMAIL *</label>
                      <input type="email" name="email" id="email" class="form-control" placeholder="exemplo@exemplo.com" required ng-model="dadosAgendamento.dados_pessoais.email" style="text-transform:none;">
                      <span class="error" ng-show="!formAgendamento.email.$valid && !formAgendamento.email.$error.required">e-mail inválido</span>
                      <span class="error" ng-show="formAgendamento.email.$error.required">preenchimento obrigatório!</span>
                    </div>
                    <div class="form-group">
                      <label for="data_nascimento">DATA DE NASCIMENTO *</label>
                      <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" placeholder="--" required ng-model="dadosAgendamento.dados_pessoais.data_nascimento" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" style="text-transform:none;" min="1900-01-01" max="2030-12-31">
                      <span class="error" ng-show="!formAgendamento.data_nascimento.$valid && !formAgendamento.data_nascimento.$error.required">Data de nascimento inválida</span>
                      <span class="error" ng-show="formAgendamento.data_nascimento.$error.required">preenchimento obrigatório!</span>
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
                          <option value="<?= $key; ?>"><?= $key != 'FV' && $key != 'DD'  ? $key.' - ':''?> <?= $descendencia ?></option>
                        <? } ?>
                      </select>
                      <span class="error" ng-show="formAgendamento.descendencia.$error.required">preenchimento obrigatório!</span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Stage 2 -->

              <!-- Start Stage 3 -->
              <div class="form-wrapper animate-if" ng-if="screenStage == 3">
                <div class="row">
                  <div class="content-section" style="width: 100%;">
                    <h4 class="text-center"><?= $elementos_pagina['conteudoStages']['stage3']['title']; ?></h4>
                    <div class="row">
                      <!-- <div class="col-md-12 col-sm-12 text-inicial" style="text-align:center;">
                        <?//= $elementos_pagina['conteudoStages']['stage3']['texto_area_principal']; ?>
                      </div> -->
                      <br><br>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="cep">CEP * <small style="color: #a9a9a9;" ng-if="!load && dadosAgendamento.dados_pessoais.localizacao.cep !== ''">Digite para localizar</small> <small style="color: #a9a9a9;" ng-if="load">carregando ...</small></label>
                          <input type="number" name="cep" id="cep" class="form-control" placeholder="64000000" minlength="8" maxlength="8" required ng-model="dadosAgendamento.dados_pessoais.localizacao.cep"
                          ng-change="getAddressCep(dadosAgendamento.dados_pessoais.localizacao.cep)">
                          <span class="error" ng-show="!formAgendamento.cep.$valid && !formAgendamento.cep.$error.required">cep inválido</span>
                          <span class="error" ng-show="formAgendamento.cep.$error.required">preenchimento obrigatório!</span>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="endereco">ENDEREÇO *</label>
                          <input type="endereco" name="endereco" id="endereco" class="form-control" placeholder="exemplo@exemplo.com" required 
                            ng-model="dadosAgendamento.dados_pessoais.localizacao.endereco">
                          <span class="error" ng-show="!formAgendamento.endereco.$valid && !formAgendamento.endereco.$error.required">e-mail inválido</span>
                          <span class="error" ng-show="formAgendamento.endereco.$error.required">preenchimento obrigatório!</span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="numero_endereco">Nº. *</label>
                          <input type="number" name="numero_endereco" id="numero_endereco" class="form-control" placeholder="--" required 
                            ng-model="dadosAgendamento.dados_pessoais.localizacao.numero_endereco" minlength="1" maxlength="10">
                          <span class="error" ng-show="!formAgendamento.numero_endereco.$valid && !formAgendamento.numero_endereco.$error.required">número inválido</span>
                          <span class="error" ng-show="formAgendamento.numero_endereco.$error.required">preenchimento obrigatório!</span>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="bairro">BAIRRO *</label>
                          <input type="text" name="bairro" id="bairro" class="form-control" placeholder="--" minlength="4" required ng-model="dadosAgendamento.dados_pessoais.localizacao.bairro">
                          <span class="error" ng-show="!formAgendamento.bairro.$valid && !formAgendamento.bairro.$error.required">bairro inválido</span>
                          <span class="error" ng-show="formAgendamento.bairro.$error.required">preenchimento obrigatório!</span>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="complemento">COMPLEMENTO </label>
                          <input type="text" name="complemento" id="complemento" class="form-control" placeholder="--" maxlength="40" ng-model="dadosAgendamento.dados_pessoais.localizacao.complemento">
                          <span class="error" ng-show="!formAgendamento.complemento.$valid && !formAgendamento.complemento.$error.required">complemento inválido</span>
                          <!-- <span class="error" ng-show="formAgendamento.complemento.$error.required">preenchimento obrigatório!</span> -->
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="estado">ESTADO *</label>
                          <input type="estado" name="estado" id="estado" class="form-control" placeholder="--" required 
                            ng-model="dadosAgendamento.dados_pessoais.localizacao.estado">
                          <span class="error" ng-show="!formAgendamento.estado.$valid && !formAgendamento.estado.$error.required">e-mail inválido</span>
                          <span class="error" ng-show="formAgendamento.estado.$error.required">preenchimento obrigatório!</span>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="cidade">CIDADE *</label>
                          <input type="cidade" name="cidade" id="cidade" class="form-control" placeholder="--" required 
                            ng-model="dadosAgendamento.dados_pessoais.localizacao.cidade">
                          <span class="error" ng-show="!formAgendamento.cidade.$valid && !formAgendamento.cidade.$error.required">e-mail inválido</span>
                          <span class="error" ng-show="formAgendamento.cidade.$error.required">preenchimento obrigatório!</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Stage 3 -->
              
              <!-- Start Stage 4 -->
              <div class="form-wrapper animate-if" ng-if="screenStage == 4">
                <div class="row">
                  <div style="background-color: aliceblue;border-radius: 5px;font-size: 9px; margin-bottom: 5px;">
                    <p style="font-style: italic;text-align: center;">
                      "Então, falou o Senhor a Moisés, dizendo: Fala aos filhos de Israel que me tragam uma oferta alçada; de todo homem cujo coração se mover voluntariamente, dele receberei a oferta. Receberei oferta de ouro, oferta de prata, e oferta de bronze." <br>Êxodo 25:1-3
                    </p>
                  </div>
                  <div class="col-md-12 col-sm-12 text-inicial" style="text-align:justify;">
                    <div class="text-center animate-if" ng-if="ofertaSelecionada != null" style="margin-bottom: 5px;">Você escolheu:</div>
                      <div ng-repeat="stage4Conteudo in dadosStages.stage4.tiposOfertas track by $index">
                        <div class="alert alert-{{stage4Conteudo.css}} blocks animate-if" ng-class="{'blocks-close': ofertaSelecionada != null, 'blocks-open': ofertaSelecionada == null}" id="{{$index}}" ng-if="ofertaSelecionada == $index || ofertaSelecionada == null">
                          <div class="text-center">
                            <input type="radio" name="ofertaSelecionada" title="Clique para escolher esta oferta" id="ofertaSelecionada_{{$index}}" value="{{stage4Conteudo.valorOpcao}}" ng-model="dadosAgendamento.dados_oferta.ofertaSelecionada" ng-change="confirmedOffer(dadosAgendamento.dados_oferta.ofertaSelecionada, $index)" required>
                            <h4>Oferta {{stage4Conteudo.name}}</h4>
                          </div>
                          <p>Oferta {{stage4Conteudo.descricao}}</p>
                          <strong>Compromisso: {{stage4Conteudo.compromisso}}</strong><br>
                          <button class="btn btn-danger btn-sm" ng-if="ofertaSelecionada != null" href="#" ng-click="trocarOferta()" title="Clique aqui para escolhar outra opção de oferta"><i class="fas fa-undo"></i>Trocar oferta</button>
                          <button class="btn btn-success btn-sm" ng-if="ofertaSelecionada != null" ng-click="verBrinde($index)">Ver Brinde</button>
                        </div>
                        <div class="animate-if" id="brindeimg_{{$index}}" style="display: none;">
                          <img ng-src="{{stage4Conteudo.img}}" style="width: 100%;border-radius: 5px;margin-bottom: 30px;">
                        </div>
                      </div>
                    <div class="text-center animate-if" ng-if="ofertaSelecionada != null">
                      <label for="dataVencimento">
                        <span ng-if="!dadosAgendamento.dados_oferta.dataVencimento">Selecione a melhor data de vencimento para seu compromisso</span>
                        <span ng-if="dadosAgendamento.dados_oferta.dataVencimento">Você escolheu: <span style="color: red;">Dia {{dadosAgendamento.dados_oferta.dataVencimento}}</span></span>
                      </label>
                      <div class="row">
                      <!-- DATA DE VENCIMENTO -->
                        <div class="col-md-12">
                          <div class="form-group">
                            <select name="dataVencimento" id="dataVencimento" class="form-control" ng-model="dadosAgendamento.dados_oferta.dataVencimento" required>
                              <option value="">Dia de vencimento</option>
                              <option value="10">10</option>
                              <option value="15">15</option>
                              <option value="20">20</option>
                              <option value="30">30</option>
                            </select>
                            <span class="error" ng-show="formAgendamento.dataVencimento.$error.required">Data de Vencimento é obrigatório</span>
                          </div>
                        </div>
                      </div>
                      <label for="tamanhoCamisa">
                        <span ng-if="!dadosAgendamento.dados_oferta.tamanhoCamisa">Selecione o tipo e tamanho da sua camisa</span>
                        <span ng-if="dadosAgendamento.dados_oferta.tamanhoCamisa">Você escolheu: <span style="color: red;">{{dadosAgendamento.dados_oferta.tipoCamisa == 'M' ? 'Masculino':'Feminino'}} > Tamanho {{dadosAgendamento.dados_oferta.tamanhoCamisa}}</span></span>
                      </label>
                      <div class="row">
                      <!-- TIPO DE CAMISAS -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <select name="tipoCamisa" id="tipoCamisa" class="form-control" ng-model="dadosAgendamento.dados_oferta.tipoCamisa" required>
                              <option value="">Tipo</option>
                              <option value="M">Masculino</option>
                              <option value="F">Feminino</option>
                            </select>
                            <span class="error" ng-show="formAgendamento.tipoCamisa.$error.required">Tipo de camisa obrigatório</span>
                          </div>
                        </div>
                        <!-- TAMANHO CAMISAS -->
                        <div class="col-md-6">
                          <div class="form-group">
                            <select name="tamanhoCamisa" id="tamanhoCamisa" class="form-control" ng-model="dadosAgendamento.dados_oferta.tamanhoCamisa" required>
                              <option value="">Tamanho </option>
                              <? foreach($elementos_pagina['conteudoStages']['stage4']['tamanhosCamisas'] as $camisa) {?>
                                  <option value="<?=$camisa?>"><?=$camisa?></option>
                              <? } ?>
                            </select>
                            <span class="error" ng-show="formAgendamento.tamanhoCamisa.$error.required">Tamanho de camisa obrigatório</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Stage 4 -->
              
              <!-- Start Stage 5 -->
              <div class="form-wrapper animate-if" ng-if="screenStage == 5">
                <div class="row">
                  <div class="content-section" style="width: 100%;">
                    <div class="alert alert-warning">
                      <div class="text-center"><strong> Dicas Importante !</strong></div>
                      <small>
                        <p> - Após a finalização da sua inscrição, você receberá no email informado uma mensagem de confirmação. Tenha atenção no preenchimento, verifique a caixa de SPAM e LIXEIRA.</p>
                        <p> - Caso não receba o e-mail de confirmação ou deseja realizar uma correção de alguma informação já enviada, utilize o painel ou <b> entre em contato com a Filadélfia</b> atráves do nosso canal de whatsapp (86) 99438-9003.</p>
                        <p> - Você receberá as mensalidades em seu email cadastrado, e também de forma física através da nossa equipe da Filadélfia.</p>
                      </small>
                    </div>
                    <div class="text-center">
                      <h4>Estamos quase lá ...</h4>  
                      <p> Revise seus Dados e clique em <b>Finalizar para concluir</b>.</p>
                      <button ng-click="cancelScheduling()" class="btn btn-danger btn-rm" id="btnCancelStage">Cancelar</button>
                      <button ng-click="finishScheduling(dadosAgendamento)" class="btn btn-success btn-rm" id="btnFinishStage">Finalizar</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Stage 5 -->
              
              <!-- Start Stage 6=myData -->
              <div class="form-wrapper animate-if" ng-if="screenStage == 'myData'">
                <div class="row">
                  <div class="content-section" style="width: 100%;">
                    <h4 class="text-center"><?= $elementos_pagina['conteudoStages']['myData']['title']; ?></h4>
                    <?php include(VIEW_MODULO_MEUS_DADOS.'index.php'); ?>
                  </div>
                </div>
              </div>
              <!-- End Stage 6=myData -->
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
              </span>
              <button ng-click="myData(screenStage)" class="btn btn-dark btn-rm animate-if" id="btnMyData" ng-if="screenStage == 1">Meus Dados</button>              
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