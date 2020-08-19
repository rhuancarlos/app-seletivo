<div class="row">
	<div class="col-sm-2" style="display: none;" id="cip">
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<label for="prova_descricao">Descrição</label>
			<input class="form-control" type="text" id="prova_descricao" name="prova_descricao" minlength="10" required="required" onkeyup="convertUppercase(this)" value="">
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="col-sm-6 adjusted-block-right">
			<div class="form-group">
				<label for="prova_tipo">Tipo de Disputa </label>
				<select class="form-control select" name="prova_tipo" id="prova_tipo" required="required" <?= isset($disabled_input) ? "disabled":null?>>
					<option value="">- Selecione uma opção</option>
					<option value="1"> Individual</option>
					<option value="2"> Equipe</option>
				</select>
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
		<div class="col-sm-6 adjusted-block-left">
			<div class="form-group">
				<label for="prova_qtd_pontos">Qtd. Pontos</label>
				<input type="text" onkeypress="return onlynumber();" name="prova_qtd_pontos" id="prova_qtd_pontos" value="" class="form-control" required="required">
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
	</div>
	<div class="col-sm-2 adjusted-block-right">
		<div class="form-group">
			<label for="prova_status">Status da Prova</label>
			<select class="form-control select" name="prova_status" id="prova_status" required="required">
				<option value="1"> Ativa</option>
				<option value="0"> Inativa</option>
			</select>
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
</div>