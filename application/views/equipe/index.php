      <?= geraElementHeaderPage(array($titulo_home)); ?>
      <?PHP if($this->rsession->get('usuario_logado')['usuario_administrador'] || $nivel_acoes >= 2) { ?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title" style="margin: 0px;">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFormCadastro" aria-expanded="true" aria-controls="collapseFormCadastro" onclick="novaEquipe()">
                  <i class="more-less icons-size-2 icon-feather-plus-square"></i>
                  Nova Equipe
                </a>
              </h4>
            </div>
            <div id="collapseFormCadastro" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <div class="element-box">
                  <form id="formCadastroEquipe" name="formCadastroEquipe" class="formValidate">
                    <input type="hidden" name="equipe_codigo" id="equipe_codigo" >
                    <?php include(VIEW_MODULO_EQUIPES.'r_inputs_equipe1.php')?>
                  </form>
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
                <a data-toggle="collapse" data-parent="#accordion" href="#" aria-expanded="true" aria-controls="collapseFormCadastro" onclick="_acaoCollapse('collapseFormCadastro', 'hide')" title="Clique para Fechar">
                  <!-- <i class="more-less icons-size-2 icon-feather-plus-square"></i> -->
                  Ver Equipe
                </a>
              </h4>
            </div>
            <div id="collapseFormCadastro" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <div class="element-box">
                  <form id="formCadastroEquipe" name="formCadastroEquipe" class="formValidate">
                    <input type="hidden" name="equipe_codigo" id="equipe_codigo" >
                    <?php include(VIEW_MODULO_EQUIPES.'r_inputs_equipe1.php')?>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div><br>
      <?PHP } ?>
      <div class="element-box">
        <?PHP include(VIEW_MODULO_EQUIPES.'listagem.php')?>
      </div>
    </div>
  </div>
</div>