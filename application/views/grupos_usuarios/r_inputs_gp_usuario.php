<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="grupo_descricao">Descrição</label>
			<input class="form-control" placeholder="Descrição do grupo" required="required" type="text" id="grupo_descricao" name="grupo_descricao" maxlength="30" onkeyup="convertUppercase(this)">
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="grupo_status">Status</label>
			<select name="grupo_status" id="grupo_status" class="form-control">
				<option value="" selected>Selecione</option>
				<option value="1">Ativo</option>
				<option value="0">Inativo</option>
			</select>
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
</div>
<?PHP if($this->rsession->get('usuario_logado')['usuario_administrador'] || ($nivel_acoes >= 2)) { ?>
	<div class="form-buttons-w buttons_acao" id="buttons_acao">
		<button class="btn btn-primary" type="button" onclick="salvarDados();"> Gravar</button>
		<input class="btn btn-danger" type="reset" onclick="_acaoCollapse('collapseFormCadastro', 'hide')" value="Cancelar">
	</div>
<?PHP } ?>