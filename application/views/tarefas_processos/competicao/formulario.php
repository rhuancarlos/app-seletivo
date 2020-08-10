<ul class="nav nav-tabs">
  <li class="nav-item active"><a data-toggle="tab" class="nav-link active" href="#dados_prova">Dados de Cadastro</a></li>
  <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#detalhamento">Detalhamento</a></li>
  <!-- <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#instrucoes">Instruções</a></li> -->
</ul>

<div class="tab-content element-box">
  <div id="dados_prova" class="tab-pane fade in active show">
    <!-- Inputs Form@dados_prova -->
    <?php require(VIEW_MODULO_MATERIAIS.'r_inputs_dados_cadastro.php')?>
  </div>
  <div id="detalhamento" class="tab-pane fade">
    <!-- Inputs Form@dados_outros -->
    <?php require(VIEW_MODULO_MATERIAIS.'r_inputs_detalhamento.php')?>
  </div>
  <!-- <div id="instrucoes" class="tab-pane fade">
    <h3>Menu 2</h3>
    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
  </div> -->
</div>
<div class="form-buttons-w buttons_acao" id="buttons_acao">
  <button class="btn btn-primary" type="button" onclick="salvarDados();"> Gravar</button>
  <input class="btn btn-danger" type="reset" onclick="_acaoCollapse('collapseFormCadastro', 'hide')" value="Cancelar">
</div>