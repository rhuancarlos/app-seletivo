      <?= geraElementHeaderPage(array($titulo_home)); ?>
      <?PHP if(($nivel_acoes == 'full') || $nivel_acoes == 2) { ?>
        <div ng-controller="ManutencaoController" ng-cloak>
          <div class="col-sm-12 col-md-8">
            <!-- <div class="element-box" ng-controller="ManutencaoListController" ng-cloak> -->
            <div class="element-box">
              <?php include(VIEW_MODULO_MANUTENCAO_MENUS.'r_list_itens.php')?>
            </div>
          </div>
          <div class="col-sm-12 col-md-4">
            <div class="element-box">
              <?php include(VIEW_MODULO_MANUTENCAO_MENUS.'r_inputs_manutencao.php')?>
            </div>
          </div>
        </div>
      <?PHP } ?>
    </div>
  </div>
</div>