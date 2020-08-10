<div class="row">
	<!-- <div class="col-sm-6 adjusted-block-left"> -->
		<div class="col-sm-6">
			<div class="form-group">
				<label for="">Nome da Equipe</label>
				<input class="form-control" required="required" type="text" id="equipe_nome" name="equipe_nome" maxlength="30" onkeyup="convertUppercase(this)">
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
			<div class="form-group">
				<label for="equipe_sigla">Sigla Equipe</label>
				<input class="form-control" required="required" type="text" id="equipe_sigla" name="equipe_sigla"  maxlength="6" onkeyup="convertUppercase(this)">
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
			<div class="form-group">
				<div class="help-block form-text with-errors form-control-feedback"></div>
				<input type="checkbox" name="equipe_mostra_tela_inicial" id="equipe_mostra_tela_inicial" class="form-control">
				<label for="equipe_mostra_tela_inicial">Mostrar widget da equipe na tela inicial</label>
			</div>
		</div>
	<!-- </div> -->
	<!-- <div class="col-sm-6 adjusted-block-right"> -->
		<div class="col-sm-3">
			<div class="form-group">
				<label for="equipe_cor_1">Cor 1 da Equipe</label><br>
				<input required="required" type="color" id="equipe_cor_1" name="equipe_cor_1">
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
			<div class="form-group">
				<label for="">Cor 2 da Equipe</label><br>
				<input type="color" id="equipe_cor_2" name="equipe_cor_2">
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
			<!-- </div>-->
	</div>
	<div class="form-buttons-w buttons_acao" id="buttons_acao">
		<button class="btn btn-primary" type="button" onclick="salvarDados();"> Gravar</button>
		<input class="btn btn-danger" type="reset" onclick="_acaoCollapse('collapseFormCadastro', 'hide')" value="Cancelar">
	</div>
