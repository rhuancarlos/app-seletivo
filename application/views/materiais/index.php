        <?= geraElementHeaderPage(array($titulo_home)); ?>
        <?PHP if($this->rsession->get('usuario_logado')['usuario_administrador'] || $nivel_acoes >= 2) { ?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title" style="margin: 0px;">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFormCadastro" aria-expanded="true" aria-controls="collapseFormCadastro" onclick="novoMaterial()">
                  <i class="more-less icons-size-2 icon-feather-plus-square"></i>
                  <span id="descricaobotao"><?=MATERIAIS_TITULO_REGISTRO?></span>
                </a>
              </h4>
            </div>
            <div id="collapseFormCadastro" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <div class="element-box">
                  <form id="formCadastroMaterial" name="formCadastroMaterial" class="formValidate" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="material_id" id="material_id" >
                    <?php require_once(VIEW_MODULO_MATERIAIS.'/formulario.php');?>
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
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFormCadastro" aria-expanded="true" aria-controls="collapseFormCadastro" onclick="novoMaterial()">
                  <i class="more-less icons-size-2 icon-feather-plus-square"></i>
                  <?=MATERIAIS_TITULO_REGISTRO?>
                </a>
              </h4>
            </div>
            <div id="collapseFormCadastro" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <div class="element-box">
                  <form id="formCadastroMaterial" name="formCadastroMaterial" class="formValidate" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="material_id" id="material_id" >
                    <?php require_once(VIEW_MODULO_MATERIAIS.'/formulario.php');?>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div><br>
      <?PHP } ?>
      <div class="element-box">
        <? require_once(VIEW_MODULO_MATERIAIS.'/listagem.php');?>
      </div>
    </div>
  </div>
</div>