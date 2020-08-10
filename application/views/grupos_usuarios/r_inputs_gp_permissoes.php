<div class="row">
	<div class="col-md-8">
		<div class="form-group">
			<label for="usuario_grupo_acesso">Grupo de Acesso</label>
			<select name="grupo_acesso" id="grupo_acesso" class="form-control select" required="required">
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
</div>
<div class="form-desc">
	Abaixo selecione as permissões que o grupo de usuário poderá ter acesso, bem como o nivel de ações que poderão ser realizado, podendo ser <code>leitura, escrita e gravação.</code>
</div>
<? 
	if(isset($TabelasMenus) && $TabelasMenus){
		echo $TabelasMenus;
	} else { ?>
	<div class="avisos" style="padding-left: 25px;"> 
		Nenhum item de menu foi definido ainda. Por favor define os itens de menu para que seja definido os acessos.
	</div>
<? } ?>
<div class="form-buttons-w buttons_acao" id="buttons_acao">
	<button class="btn btn-primary" type="button" onclick="salvarDadosPermissoes()"> Gravar</button>
	<input class="btn btn-danger" type="reset" onclick="_acaoCollapse('collapseFormCadastro', 'hide')" value="Cancelar">
</div>