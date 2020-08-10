        <?= geraElementHeaderPage(array($titulo_home[0], $titulo_home[1])); ?>
        <?PHP if($this->rsession->get('usuario_logado')['usuario_administrador'] || $nivel_acoes >= 2) { ?>
          <div class="element-box" ng-app="Acampoder" ng-controller="CompeticaoController" ng-cloak >
          <!-- <div class="element-box-content"> -->
            <!-- 
              <div class="container-fluid"> -->
                <!-- <div class="row"> -->
                  <!-- <div class="col-sm-12 col-lg-12"> -->
                    <?php require_once(VIEWPATH.VIEW_MODULO_TAREFAS_PROCESSOS_COMPETICAO.'_painelOpcoes.php');?>
                    <?php require_once(VIEWPATH.VIEW_MODULO_TAREFAS_PROCESSOS_COMPETICAO.'_painelConteudo.php');?>
                  <!-- </div> -->
                <!-- </div> -->
              <!-- </div> -->
            <!-- </div> -->
          </div>
        <?PHP } ?>
    </div>
  </div>
</div>