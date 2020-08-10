<ul class="nav nav-tabs" id="opcoes_lancamentos">
  <li class="nav-item active"><a data-toggle="tab" class="nav-link active" href="#lancamentoContas">Lançamento de Contas</a></li>
  <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#baixarContas">Pagamentos</a></li>
  <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#recebimentoContas">Recebimentos</a></li>
  <!-- <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#instrucoes">Instruções</a></li> -->
</ul>

<div class="tab-content element-box">
  <div id="lancamentoContas" class="tab-pane fade in active show">
    <!-- Inputs Form@lancamento_despesas -->
    <form id="formFinanceirolancamentoContas" name="formFinanceirolancamentoContas" class="formValidate" enctype="multipart/form-data" method="POST">
      <input type="hidden" name="conta_id" id="conta_id" >
      <?php require(VIEWPATH.VIEW_MODULO_TAREFAS_PROCESSOS_FINANCEIRO.'r_inputs_dados_lancamento_contas.php')?>
      <div class="form-buttons-w buttons_acao" id="buttons_acao">
        <button class="btn btn-primary" type="button" onclick="salvarLancamento();"> Gravar Lançamento</button>
        <input class="btn btn-danger" type="reset" onclick="_acaoCollapse('collapseFormCadastro', 'hide')" value="Cancelar">
      </div>
    </form>
  </div>
  <div id="baixarContas" class="tab-pane">
    <div id="descricao_processo_1"></div>
    <form id="formFinanceiroBaixaContas" name="formFinanceiroBaixaContas" class="formValidate d-none" enctype="multipart/form-data" method="POST">
      <input type="hidden" name="bxconta_id" id="bxconta_id" >
      <!-- Inputs Form@pagamento_contas -->
      <?php require(VIEWPATH.VIEW_MODULO_TAREFAS_PROCESSOS_FINANCEIRO.'r_inputs_baixas_contas.php')?>
      <div class="form-buttons-w buttons_acao" id="buttons_acao_bx">
        <button class="btn btn-primary" type="button" onclick="salvarBaixa();"><i class="icon-feather-save"></i> Baixar Despesa</button>
        <button class="btn btn-danger" type="button" onclick="cancelarAcaoBaixa();">Cancelar</button>
      </div>
    </form>
    <div class="alert alert-info" id="infobx">
      <p>Seleciona uma conta na listagem abaixo, em seguida <b>clique em pagar para que seja aberta a rotina de baixa</b>.</p>
    </div>
  </div>
  <div id="recebimentoContas" class="tab-pane">
    <div id="descricao_processo_2"></div>
    <form id="formFinanceiroRecebimentoContas" name="formFinanceiroRecebimentoContas" class="formValidate d-none" enctype="multipart/form-data" method="POST">
      <input type="hidden" name="recebeconta_id" id="recebeconta_id" >
      <!-- Inputs Form@recebimento_contas -->
      <?php require(VIEWPATH.VIEW_MODULO_TAREFAS_PROCESSOS_FINANCEIRO.'r_inputs_recebimento_contas.php')?>
      <div class="form-buttons-w buttons_acao" id="buttons_acao_rec">
        <button class="btn btn-primary" type="button" onclick="salvaRecebimento();"><i class="icon-feather-save"></i> Efetivar Recebimento</button>
        <button class="btn btn-danger" type="button" onclick="cancelarAcaoReceber();">Cancelar</button>
      </div>
    </form>
    <div class="alert alert-info" id="inforcb">
      <p>Seleciona uma conta na listagem abaixo, em seguida <b>clique em receber para que seja aberta a rotina de recebimento</b>.</p>
    </div>
  </div>
</div>