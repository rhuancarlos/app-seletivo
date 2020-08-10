<div class="row">
	<? if($equipes) {
			foreach ($equipes as $equipe) { ?>
				<div class="col-sm-3">
					<a class="element-box el-tablo" href="#" style="text-decoration: none; background-image: linear-gradient(<?= $equipe->style_backgroud_cor_1.','.$equipe->style_backgroud_cor_2;?>)";>
						<div class="label" style="color: #ffffff;">
							<strong><?= $equipe->descricao; ?></strong>
						</div>
						<div class="value" style="color: <?= $equipe->style_font_cor ?>; text-shadow: 0.1em 0.1em 0.2em black;">
							<?= getTotalParticipantesEquipes($equipe->idequipe)->total_participantes.' <span style="font-size: 11px;">Participantes</span>'?>
						</div>
					</a>
				</div>
		<? } 
			} else { ?>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-info">
						<p>Não encontramos nenhuma equipe cadastrada ou habilitada para a exibição. Acesse o cadastro de equipes e habilite um registro para exibição.</p>
					</div>
				</div>
			</div>
		<? } ?>
</div>