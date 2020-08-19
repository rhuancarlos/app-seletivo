      <?= geraElementHeaderPage(array($titulo_home)); ?>
      <?PHP if(($nivel_acoes == 'full') || $nivel_acoes == 2) { ?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title" style="margin: 0px;">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFormCadastro" aria-expanded="true" aria-controls="collapseFormCadastro" onclick="novoUsuario()"><i class="more-less icons-size-2 icon-feather-plus-square"></i>Novo usuário</a>
              </h4>
            </div>
            <div id="collapseFormCadastro" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <div class="element-box">
                  <form id="formCadastroUsuario" name="formCadastroUsuario" class="formValidate" enctype="multipart/form-data">
                    <input type="hidden" name="usuario_codigo" id="usuario_codigo" >
                    <?php include(VIEW_MODULO_USUARIOS.'r_inputs_usuario.php')?>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div><br>
      <?PHP } ?>
      <?PHP if($nivel_acoes == 1) { ?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title" style="margin: 0px;">
                <a data-toggle="collapse" data-parent="#accordion" href="#" aria-expanded="true" aria-controls="collapseFormCadastro"  onclick="_acaoCollapse('collapseFormCadastro', 'hide')" title="Clique para Fechar">
                  Ver Usuário
                </a>
              </h4>
            </div>
            <div id="collapseFormCadastro" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <div class="element-box">
                  <form id="formCadastroUsuario" name="formCadastroUsuario" class="formValidate" enctype="multipart/form-data">
                    <input type="hidden" name="usuario_codigo" id="usuario_codigo" >
                    <?php include(VIEW_MODULO_USUARIOS.'r_inputs_usuario.php')?>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div><br>
      <?PHP } ?>
      <div class="element-box">
        <?PHP include(VIEW_MODULO_USUARIOS.'listagem.php')?>
      </div>
    </div>
  </div>
</div>