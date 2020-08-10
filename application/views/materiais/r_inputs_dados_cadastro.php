<div class="row">
	<div class="col-sm-2" style="display: none;" id="cip">
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<label for="material_descricao">Descrição</label>
			<input class="form-control" type="text" id="material_descricao" name="material_descricao" minlength="10" required="required" onkeyup="convertUppercase(this)" tabindex="1">
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="col-sm-6 adjusted-block-right">
			<div class="form-group">
				<label for="material_unidade">UN</label>
				<select class="form-control select" name="material_unidade" id="material_unidade" required="required" tabindex="3">
					<option value="">- </option>
					<option value="UN"> Unidade</option>
					<option value="PC"> Pacote</option>
					<option value="KG"> Kilo</option>
					<option value="MT"> Metro</option>
				</select>
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
		<div class="col-sm-6 adjusted-block-left">
			<div class="form-group">
				<label for="material_quantidade">Qtd. Atual</label>
				<input type="text" onkeypress="return onlynumber();" name="material_quantidade" id="material_quantidade" value="" class="form-control" required="required" tabindex="2">
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
	</div>
	<div class="col-sm-2 adjusted-block-right">
		<div class="form-group">
			<label for="material_status">Situacão</label>
			<select class="form-control select" name="material_status" id="material_status" required="required" tabindex="4">
				<option value="1">Ativo</option>
				<option value="0">Inativo</option>
			</select>
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
</div>