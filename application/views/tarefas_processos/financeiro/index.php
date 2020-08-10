        <?= geraElementHeaderPage(array($titulo_home[0], $titulo_home[1])); ?>
      <?PHP if($this->rsession->get('usuario_logado')['usuario_administrador'] || $nivel_acoes >= 2) { ?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title" style="margin: 0px;">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseProcessosFinanceiros" aria-expanded="true" aria-controls="collapseProcessosFinanceiros" onclick="novoLancamento()">
                  <i class="more-less icons-size-2 icon-feather-plus-square"></i>
                  <span id="descricaobotao"><?=TRF_PROCESSOS_FINANCEIRO_TITULO_REGISTRO?></span>
                </a>
              </h4>
            </div>
            <div id="collapseProcessosFinanceiros" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <div class="element-box">
                  <?php require_once(VIEWPATH.VIEW_MODULO_TAREFAS_PROCESSOS_FINANCEIRO.'formulario.php');?>
                </div>
              </div>
            </div>
          </div>
        </div><br>
      <?PHP } ?>
      <?PHP if(!$this->rsession->get('usuario_logado')['usuario_administrador'] || ($nivel_acoes == 1)) { ?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title" style="margin: 0px;">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseProcessosFinanceiros" aria-expanded="true" aria-controls="collapseProcessosFinanceiros" onclick="novoLancamento()">
                  <i class="more-less icons-size-2 icon-feather-plus-square"></i>
                  <span id="descricaobotao"><?=TRF_PROCESSOS_FINANCEIRO_TITULO_REGISTRO?></span>
                </a>
              </h4>
            </div>
            <div id="collapseProcessosFinanceiros" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <div class="element-box">
                  <?php require_once(VIEWPATH.VIEW_MODULO_TAREFAS_PROCESSOS_FINANCEIRO.'formulario.php');?>
                </div>
              </div>
            </div>
          </div>
        </div><br>
      <?PHP } ?>
      <div class="element-box">
        <? require_once(VIEWPATH.VIEW_MODULO_TAREFAS_PROCESSOS_FINANCEIRO.'/listagem.php');?>
      </div>
    </div>
  </div>
</div>