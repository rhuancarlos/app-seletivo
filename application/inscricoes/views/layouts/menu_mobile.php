<div class="mm-logo-buttons-w">
	<a class="mm-logo" href="<?= base_url() ?>">
		<img src="<?= URL_IMAGES_LOGOS .'logo.png'?>">
		<span><?= NOME_CURTO_SISTEMA.' '.date('Y') ?></span>
	</a>
	<div class="mm-buttons">
		<div class="mobile-menu-trigger">
			<div class="os-icon os-icon-hamburger-menu-1"></div>
		</div>
	</div>
</div>
<div class="menu-and-user" style="display: none;">
	<div class="logged-user-w">
		<?php include(VIEWPATH.'layouts/perfil_usuario.php'); ?>
	</div>
	<!--------------------
	START - Mobile Menu List
	-------------------->
	<?= $this->rsession->get('menu_completo'); ?>
	<!--------------------
	END - Mobile Menu List
	-------------------->
</div>