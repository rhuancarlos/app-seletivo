<div class="row">
	<div class="col-sm-2">
		<div class="form-group">
			<label for="tipo_conta">Tipo de Lançamento</label>
			<select class="form-control" name="conta_tipo" id="conta_tipo" required="required" tabindex="1">
				<option value=""> Selecione</option>
				<option value="conta_d">(D) Despesa</option>
				<option value="conta_r">(R) Receita</option>
			</select>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="form-group">
			<label for="material_descricao">Descrição</label>
			<input class="form-control" type="text" id="conta_descricao" placeholder="Descrição da conta" name="conta_descricao" minlength="10" required="required" onkeyup="convertUppercase(this)" tabindex="2">
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
	<div class="col-sm-2 adjusted-block-left">
		<div class="form-group">
			<label for="conta_valor_conta">Valor da Conta</label>
			<input type="text" onkeypress="return onlynumber();" name="conta_valor" id="conta_valor" value="" class="form-control valores" placeholder="R$ 0,00" required="required" tabindex="3">
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		<div class="form-group">
			<label for="">Tipo de Documento</label>
			<select class="form-control" name="conta_tipo_documento" id="conta_tipo_documento" tabindex="4">
				<option value="" selected> Selecione</option>
				<? foreach ($tipo_documento as $key => $value) { ?>
				<option value="<?= $this->seguranca->enc($value->idtipodocumento) ?>"><?= $value->descricao ?></option>
				<? } ?>
			</select>
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
	<div class="col-md-10">
		<div class="form-group">
			<label for="">Detalhamento de lançamento</label>
			<input type="text" class="form-control" placeholder="Detalhamento da conta" name="conta_detalhamento" id="conta_detalhamento" onkeyup="convertUppercase(this)"  tabindex="5" maxlength="50">
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
</div>