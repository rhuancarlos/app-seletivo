      <?= geraElementHeaderPage(array($titulo_home)); ?>
        <div class="element-box">
        <!-- BUSCA AVANÇADA -->
        <div class="element-box" style="float: right; background-color: #fafafa; margin-right: 1rem;">
          <button type="button" class="btn btn-primary btn-sm" onclick="redirecionar('<?= base_url($controller.'/cadastrar'); ?>')" title="Novo Participante">
            <i class="fa fa-plus"></i>
          </button>
          <button type="button" class="btn btn-primary btn-sm" onclick="opcoesBuscaAvancada()" title="Busca Avançada"><span class="fa fa-search"></span></button>
          <!--<button type="button" class="btn btn-primary btn-sm" onclick="getDadosListagem();" title="Atualizar Lista"><span class="fa fa-refresh"></span></button>-->
        </div>
        <? require_once(VIEW_MODULO_PARTICIPANTES.'listagem.php');?>
      </div>
    </div>
  </div>
</div>