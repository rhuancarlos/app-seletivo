<span id="info"></span>
<div class="panel element-box element-search-advanced" id="busca_avancada" style="display:none;">
  <form id="formBuscaAvancada">                        
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-3">
          <label>Situação de Pagamento</label>
          <select class="form-control" name="filtro_situacao_pagamento" id="filtro_situacao_pagamento">
            <option value="" selected> Selecione uma opção</option>
            <? foreach ($situacoes_pagamento as $key => $value) { ?>
            <option value="<?= $this->seguranca->enc($value->idsituacaopagamento) ?>"><?= $value->descricao ?></option>
            <? } ?>
          </select>
        </div>
        <div class="col-sm-3">
          <label>Tipo de Conta</label>
          <select class="form-control" name="filtro_tipo_conta" id="filtro_tipo_conta">
            <option value="" selected> Selecione uma opção</option>
            <option value="conta_d" selected>(D) Despesa</option>
            <option value="conta_r">(R) Receita</option>
          </select>
        </div>
      </div>
    </div>
  </form>
</div>
<div class="table-responsive"> 
  <table id="lancamentos" width="100%" class="table table-hover table-lightfont table-ajuste-lateral">
    <thead>
      <tr>
        <?= $list_table_th; ?>
      </tr>
    </thead>
    <tbody id="dataLancamentos">
    </tbody>
  </table>
</div>