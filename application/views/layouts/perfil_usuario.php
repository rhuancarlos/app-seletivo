<div class="avatar-w">
	<img alt="" src="<?= URL_IMAGES_PERFIL.$this->rsession->get('usuario_logado')['usuario_foto'];?>">
</div>
<div class="logged-user-info-w">
	<div class="logged-user-name">
		<?= !empty($this->rsession->get('usuario_logado')['usuario_display']) ? $this->rsession->get('usuario_logado')['usuario_display'] : 'Usuário' ;?>
	</div>
	<div class="logged-user-role ct-user-role">
		<?= !empty($this->rsession->get('usuario_logado')['usuario_atribuicao_funcao']) ? $this->rsession->get('usuario_logado')['usuario_atribuicao_funcao'] : '-';?>
	</div>
</div>