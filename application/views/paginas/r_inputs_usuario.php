<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="usuario_email">E-mail</label>
			<input class="form-control" placeholder="exemplo@exemplo.com" required="required" type="email" id="usuario_email" name="usuario_email" maxlength="30" onkeyup="convertUppercase(this)">
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>

		<div class="form-group">
			<label for="usuario_vinculo_participante">Vinculo de participante</label>
			<select name="usuario_vinculo_participante" id="usuario_vinculo_participante" class="form-control select">
				<option value="">- Selecione</option>
				<?
					if($participantes) {
						foreach($participantes as $key => $p) { ?>
							<option value="<?= $this->seguranca->enc($p->idparticipante) ?>"><?= $p->prt_nomecompleto ?></option>
						<? } 
					} else { ?>
					<option> Nenhum registro encontrado</option>
				<? } ?>
			</select>
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="col-md-6">
			<div class="form-group">
				<label for="usuario_senha_repetir">Repetir Senha</label>
				<input type="password" placeholder="Confirmação de senha" name="usuario_senha_repetir" required="required" id="usuario_senha_repetir" class="form-control">
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label for="usuario_senha">Senha</label>
				<input type="password" placeholder="Digite a senha" name="usuario_senha" required="required" id="usuario_senha" class="form-control">
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
			
		<!-- <div class="col-md-6"> -->
		<div class="col-md">
			<div class="form-group">
				<label for="usuario_grupo_acesso">Grupo de Acesso</label>
				<select name="usuario_grupo_acesso" id="usuario_grupo_acesso" class="form-control select" required="required">
					<option value="">- Selecione</option>
					<?
					if($grupos_acessos) {
						foreach($grupos_acessos as $key => $g) { ?>
							<option value="<?= $this->seguranca->enc($g->id) ?>"><?= $g->descricao ?></option>
							<? } 
					} else { ?>
					<option> Nenhum registro encontrado</option>
					<? } ?>
				</select>
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
			</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<div class="help-block form-text with-errors form-control-feedback"></div>
					<input type="checkbox" name="usuario_administrador" id="usuario_administrador" class="form-control">
					<label for="usuario_administrador">Administrador</label>
			</div>
		</div>
	</div>
</div>

<h6 class="element-header" style="margin-top: 10px;">Perfil de Usuário</h6>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="usuario_nome">Nome Completo</label>
				<input class="form-control" type="text" id="usuario_nome" name="usuario_nome" minlength="10" onkeyup="convertUppercase(this)">
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="col-md-6">
				<div class="form-group">
					<label for="usuario_telefone">Telefone (whats) </label>
					<input type="tel" name="usuario_telefone" id="usuario_telefone" onkeypress="mascara(this, telefone)" class="form-control" maxlength="15" minlength="11">
					<div class="help-block form-text with-errors form-control-feedback"></div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="usuario_nome_display">Apelido</label>
					<input class="form-control" type="text" id="usuario_nome_display" name="usuario_nome_display" minlength="2" maxlength="20" onkeyup="convertUppercase(this)">
					<div class="help-block form-text with-errors form-control-feedback"></div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="col-md-6 adjusted-block-right">
				<div class="form-group">
					<label for="usuario_genero">Gênero</label>
					<select name="usuario_genero" id="usuario_genero" class="form-control">
						<option value="M">Masculino</option>
						<option value="F">Feminino</option>
					</select>
					<div class="help-block form-text with-errors form-control-feedback"></div>
				</div>
			</div>
			<div class="col-md-6 adjusted-block-left">
				<div class="form-group">
					<label for="usuario_atribuicao">Atribuições</label>
					<select name="usuario_atribuicao" id="usuario_atribuicao" class="form-control select" required="required">
						<option value="">- Selecione</option>
						<?
						if($atribuicoes) {
							foreach($atribuicoes as $key => $a) { ?>
								<option value="<?= $this->seguranca->enc($a->id) ?>"><?= $a->descricao ?></option>
								<? } 
						} else { ?>
						<option> Nenhum registro encontrado</option>
						<? } ?>
					</select>
					<div class="help-block form-text with-errors form-control-feedback"></div>
				</div>
			</div>
		</div>
	</div>
<?PHP if($this->rsession->get('usuario_logado')['usuario_administrador'] || ($nivel_acoes >= 2)) { ?>
	<div class="form-buttons-w buttons_acao" id="buttons_acao">
		<button class="btn btn-primary" type="button" onclick="salvarDados();"> Gravar</button>
		<input class="btn btn-danger" type="reset" onclick="_acaoCollapse('collapseFormCadastro', 'hide')" value="Cancelar">
	</div>
<?PHP } ?>