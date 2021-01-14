		<div aria-hidden="true" class="onboarding-modal modal fade animated show-on-load" role="dialog" tabindex="-1">
		  <div class="modal-dialog modal-centered" role="document">
			<div class="modal-content text-center">
			  <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span class="close-label">Fechar</span><span class="os-icon os-icon-close"></span></button>
			  <div class="onboarding-slider-w">
				<div class="onboarding-slide">
				  <div class="onboarding-media">
					<img alt="" src="<?= URL_IMAGES_TEMA.'bigicon2.png';?>" width="200px">
				  </div>
				  <div class="onboarding-content with-gradient">
					<h4 class="onboarding-title">
					  Olá, <?= $this->rsession->get('usuario_logado')['usuario_nomecompleto'];?>
					</h4>
					<div class="onboarding-text">
					  <? if($this->rsession->get('usuario_logado')['usuario_administrador']) { ?>
							<?php require_once(VIEWPATH.'layouts/primeiro_acesso_usuario_administrador.php');?>
						<? } else { ?>
							<?php require_once(VIEWPATH.'layouts/primeiro_acesso_usuario_comum.php');?>
						<? } ?>
					</div>
				  </div>
				</div>
<!-- 				<div class="onboarding-slide">
				  <div class="onboarding-media">
					<img alt="" src="<?= URL_IMAGES_TEMA.'avatar5.jpg';?>" width="200px">
				  </div>
				  <div class="onboarding-content with-gradient">
					<h4 class="onboarding-title">
					  Example Request Information
					</h4>
					<div class="onboarding-text">
					  In this example you can see a form where you can request some additional information from the customer when they land on the app page.
					</div>
					<form>
					  <div class="row">
						<div class="col-sm-6">
						  <div class="form-group">
							<label for="">Your Full Name</label><input class="form-control" placeholder="Enter your full name..." type="text" value="">
						  </div>
						</div>
						<div class="col-sm-6">
						  <div class="form-group">
							<label for="">Your Role</label><select class="form-control">
							  <option>
								Web Developer
							  </option>
							  <option>
								Business Owner
							  </option>
							  <option>
								Other
							  </option>
							</select>
						  </div>
						</div>
					  </div>
					</form>
				  </div>
				</div>
				<div class="onboarding-slide">
				  <div class="onboarding-media">
					<img alt="" src="<?= URL_IMAGES_TEMA.'avatar6.jpg';?>" width="200px">
				  </div>
				  <div class="onboarding-content with-gradient">
					<h4 class="onboarding-title">
					  Showcase App Features
					</h4>
					<div class="onboarding-text">
					  In this example you can showcase some of the features of your application, it is very handy to make new users aware of your hidden features. You can use boostrap columns to split them up.
					</div>
					<div class="row">
					  <div class="col-sm-6">
						<ul class="features-list">
						  <li>
							Fully Responsive design
						  </li>
						  <li>
							Pre-built app layouts
						  </li>
						  <li>
							Incredible Flexibility
						  </li>
						</ul>
					  </div>
					  <div class="col-sm-6">
						<ul class="features-list">
						  <li>
							Boxed & Full Layouts
						  </li>
						  <li>
							Based on Bootstrap 4
						  </li>
						  <li>
							Developer Friendly     
						  </li>
						</ul>
					  </div>
					</div>
				  </div>
				</div> -->

			  </div>
			</div>
		  </div>
		</div> 