      <?= geraElementHeaderPage(array($titulo_home)); ?>
      <?PHP if(($nivel_acoes == 'full') || $nivel_acoes == 2) { ?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title" style="margin: 0px;">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFormCadastro" aria-expanded="true" aria-controls="collapseFormCadastro" onclick="novoGrupoUsuario()"><i class="more-less icons-size-2 icon-feather-plus-square"></i><?= GRP_USUARIO_TITULO_REGISTRO?></a>
              </h4>
            </div>
            <div id="collapseFormCadastro" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <div class="element-box">
                  <form id="formCadastroGrupoUsuario" name="formCadastroGrupoUsuario" class="formValidate" enctype="multipart/form-data">
                    <input type="hidden" name="grupo_codigo" id="grupo_codigo">
                    <?php include(VIEW_MODULO_GRUPOS_USUARIOS.'r_inputs_gp_usuario.php')?>
                  </form>
                </div>
              </div>
            </div>
            <div class="panel-heading" role="tab" id="headingTwo" style="margin-top:10px;">
              <h4 class="panel-title" style="margin: 0px;">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFormPermissoes" aria-expanded="true" aria-controls="collapseFormPermissoes" onclick="definirPermissoesGrupo()">
                  <i class="more-less icons-size-2 icon-feather-plus-square"></i><?= GRP_USUARIO_PERMISSOES?>
                </a>
              </h4>
            </div>
            <div id="collapseFormPermissoes" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
              <div class="panel-body">
                <div class="element-box">
                  <form id="formPermissoes" name="formPermissoes" class="formValidate" enctype="multipart/form-data">
                    <input type="hidden" name="grupo_acessos_permissoes" id="grupo_acessos_permissoes">
                    <?php include(VIEW_MODULO_GRUPOS_USUARIOS.'r_inputs_gp_permissoes.php')?>
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
                <a data-toggle="collapse" data-parent="#accordion" href="#" aria-expanded="true" aria-controls="collapseFormCadastro"   onclick="_acaoCollapse('collapseFormCadastro', 'hide')" title="Clique para Fechar">
                  &nbsp;&nbsp;
                </a>
              </h4>
            </div>
            <div id="collapseFormCadastro" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <div class="element-box">
                  <form id="formCadastroGrupoUsuario" name="formCadastroGrupoUsuario" class="formValidate" enctype="multipart/form-data">
                    <?php include(VIEW_MODULO_GRUPOS_USUARIOS.'r_inputs_gp_usuario.php')?>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div><br>
      <?PHP } ?>
      <div class="element-box">
        <?PHP include(VIEW_MODULO_GRUPOS_USUARIOS.'listagem.php')?>
      </div>
    </div>
  </div>
</div>