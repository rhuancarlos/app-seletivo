<?PHP include(VIEWPATH.'layouts/login/header.php'); ?>
	<div class="all-wrapper menu-side with-pattern" ng-controller="LoginController">
		<div class="row">
			<div class="auth-box-w">
				<div class="logo-w">
					<img alt="" src="https://ibnfiladelfia.com.br/wp-content/uploads/2020/03/Adesivo-Filade%CC%81fia-2018-1527x1080.png" width="150px">
					<!-- <a href="<?// base_url()?>"><img alt="" src="<?//= URL_IMAGES_LOGOS .'logo-big.png';?>"></a> -->
				</div>
				<h4 class="auth-header">
					<span ng-if="typeForm == 1">
						<?= NOME_CURTO_SISTEMA.'<br><small>Identifique-se para começar!</small>'; ?>
					</span>
					<span ng-if="typeForm == 2">
						<?= NOME_CURTO_SISTEMA.'<br><small>Recuperação de senha!</small>'; ?>
					</span>
				</h4>
				<?php if(isset($erro) && (!empty($erro))) { ?>
					<div class="alert alert-danger" role="alert" data-auto-dismiss="3000">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<?= $erro ?>
					</div>	
				<?php } $this->rsession->delete("erro")?>
				<?php if(isset($sucesso) && (!empty($sucesso))) { ?>
					<div class="alert alert-success" role="alert" data-auto-dismiss="3000">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<?= $sucesso ?>
					</div>
				<?php } ?>
				<?PHP require_once('_formularios.php');?>
				<?PHP require_once(VIEWPATH.'layouts/copyright.php');?>
			</div>
		</div>
	</div>
<?PHP include(VIEWPATH.'layouts/login/footer.php'); ?>
