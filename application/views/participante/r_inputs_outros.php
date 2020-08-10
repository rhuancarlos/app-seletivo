<div class="row">
	<div class="col-sm-3">
		<div class="form-group">
			<label for="">Equipe de Participação</label>
			<select name="participante_equipe" id="participante_equipe" class="form-control select" >
				<option value="">- Selecione</option>
				<? 
					if($equipes) {
						foreach($equipes as $key => $e) { ?>
							<option value="<?= $e->idequipe ?>" <?= isset($dadosParticipante) ? selectedSelect($e->idequipe, $this->seguranca->dec($dadosParticipante->equipe_id)) : false;?>><?= $e->descricao ?></option>
						<? } ?>
				<? } else { ?>
					<option> Nenhum registro encontrado</option>
				<? } ?>
			</select>
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group"><br><br>
			<input type="checkbox" name="participante_lider_equipe" id="participante_lider_equipe"
			 <?= isset($dadosParticipante) ? ( ($dadosParticipante->lider_equipe) ? 'checked' : false) : false;?>>
			<label for="participante_lider_equipe">Participante líder de equipe</label>
		</div>
	</div>
</div>