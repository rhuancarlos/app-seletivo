<h5 class="form-header">
  <?= PARTICIPANTE_TITULO_LISTAGEM ?>
</h5>
<div class="form-desc">
  <?= PARTICIPANTE_SUBTITULO_LISTAGEM?>
</div>
<!-- <div class="row"> -->
  <div class="panel element-box element-search-advanced" id="busca_avancada" style="display:none;">
    <form id="formBuscaAvancada">                        
      <div class="panel-body">
        <div class="row">
          <!-- <div class="col-sm-3">
            <label>Situações</label>
            <select class="form-control" name="filtro_situacao" id="filtro_situacao">
              <option value=""> Selecione uma opção</option>
              <option value="1" selected> Ativo</option>
              <option value="0"> Inativo</option>
            </select>
          </div> -->
          <div class="col-sm-3">
            <label>Equipe</label>
            <select class="form-control" name="filtro_equipe" id="filtro_equipe">
              <option value="" selected> Selecione uma opção</option>
              <? foreach ($equipes as $key => $value) { ?>
              <option value="<?= $value->idequipe ?>"><?= '('.$value->idequipe.') '.$value->descricao ?></option>
              <? } ?>
            </select>
          </div>
        </div><br>
        <!-- <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <button class="mr-2 mb-2 btn btn-primary" onclick="pesquisaAvancada(event)">Pesquisar</button>
            </div>
          </div>
        </div> -->
      </div>
    </form>
  </div>
<!-- </div> -->
<div class="table-responsive"> 
  <table id="tabela_participantes" width="100%" class="table table-hover table-lightfont table-ajuste-lateral">
    <thead>
      <tr>
        <?= $list_table_th; ?>
      </tr>
    </thead>
    <tbody id="dataParticipantes">
    </tbody>
<!--       <tfoot>
        <tr>
          <?#= $list_table_th; ?>
        </tr>
      </tfoot> -->
  </table>
</div>