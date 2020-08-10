<div class="row">
	<div class="col-sm-2">
		<div class="form-group">
			<label for="tipo_conta">Tipo de Lançamento</label>
			<select class="form-control" name="bx_conta_tipo" id="bx_conta_tipo" disabled="disabled" tabindex="1">
				<option value=""> Selecione</option>
				<option value="conta_d">(D) Despesa</option>
				<option value="conta_r">(R) Receita</option>
			</select>
		</div>
	</div>
	<!-- <div class="col-sm-2">
		<div class="form-group text-right">
			<label for="bx_conta_codigo">N.º</label>
			<input class="form-control text-right data" type="text" id="bx_conta_codigo" name="bx_conta_codigo" disabled>
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div> -->
	<div class="col-sm-10">
		<div class="form-group">
			<label for="bx_conta_descricao">Descrição</label>
			<input class="form-control" type="text" id="bx_conta_descricao" placeholder="Descrição da conta" name="bx_conta_descricao" minlength="10" required="required" onkeyup="convertUppercase(this)" tabindex="2">
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col" style="background-color: #f7f7f7;">
		<div class="form-group">
			<label for="bx_conta_lancamento">Data de Lançamento</label>
			<input class="form-control data" type="text" id="bx_conta_lancamento" name="bx_conta_lancamento" tabindex="3" placeholder="DD / MM / AAAA" disabled>
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
	<div class="col" style="background-color: #f7f7f7;">
		<div class="form-group">
			<label for="bx_conta_valor">Valor da Conta</label>
			<input class="form-control" placeholder="R$ 0,00" type="text" id="bx_conta_valor" name="bx_conta_valor" disabled tabindex="5">
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
	<div class="col" style="background-color: #8fff9c6e;">
		<div class="form-group">
			<label for="bx_conta_valor_pago">Pagamento Realizado</label><br>
			<input type="checkbox" name="bx_conta_paga" id="bx_conta_paga" class="form-control"	tabindex="6">
			<!-- <input class="form-control" placeholder="R$ 0,00" type="text" id="bx_conta_valor_pago" name="bx_conta_valor_pago" onkeyup="saldodevedor(this)" required="required" tabindex="6"> -->
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
	<!-- <div class="col" style="background-color: #8fff9c6e;">
		<div class="form-group">
			<label for="bx_conta_datapagamento">Data de Pagamento</label>
			<input class="form-control data" type="text" id="bx_conta_datapagamento" name="bx_conta_datapagamento" tabindex="4" placeholder="DD / MM / AAAA">
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div> -->
	<div class="col-md-12">
		<div class="form-group">
			<label for="">Detalhamento de lançamento</label>
			<textarea name="bx_conta_detalhamento" id="bx_conta_detalhamento" cols="4" rows="4" tabindex="5" class="form-control"></textarea>
			<!-- <input type="text"  " name="conta_detalhamento" id="conta_detalhamento"    maxlength="50"> -->
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
</div>
<!-- <div class="row" style="margin-top: 0;padding: 9px;">
	<div class="col-sm-6">
	</div>
	<div class="col-sm-6" style="background-color: #8fff9c6e;"> -->
		<!-- <div class="col-sm-6"> -->
		<!-- </div> -->
		<!-- <div class="col-sm-2">
			<div class="form-group">
				<label for="bx_conta_saldodevedor">Saldo Devedor</label>
				<input class="form-control valores" placeholder="R$ 0,00" type="text" id="bx_conta_saldodevedor" name="bx_conta_saldodevedor" disabled tabindex="7">
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div> -->
	<!-- </div>
</div> -->