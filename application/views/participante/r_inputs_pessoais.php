<div class="row">
<? if(isset($dadosParticipante)) { ?>
<div class="col-sm-2">
	<div class="form-group">
		<label for="codigo">Matricula</label>
		<input class="form-control" type="text" disabled=$disabled_input onkeyup="convertUppercase(this)" value="<?= $this->seguranca->dec($dadosParticipante->idparticipante);?>">
		<div class="help-block form-text with-errors form-control-feedback"></div>
	</div>
</div>
<div class="col-sm-4">
<? } else { ?>
	<div class="col-sm-6">
<? } ?>
		<div class="form-group">
			<label for="participante_nomecompleto">Nome Completo</label>
			<input class="form-control" type="text" id="participante_nomecompleto" name="participante_nomecompleto" minlength="10" required="required" onkeyup="convertUppercase(this)" value="<?=isset($dadosParticipante) ? $dadosParticipante->prt_nomecompleto:null;?>" <?= isset($disabled_input) ? $disabled_input:null?>>
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<label for=""> Endereço</label>
			<input class="form-control" required="required" type="text" id="participante_endereco" name="participante_endereco" onkeyup="convertUppercase(this)"
			value="<?=isset($dadosParticipante) ? $dadosParticipante->prt_endereco:null;?>" <?= isset($disabled_input) ? $disabled_input:null?>>
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="col-sm-6 adjusted-block-right">
			<div class="form-group">
				<label for="participante_cidade">Cidade <span><small id="total_registros_encontrados" style="font-size: 10px; color:red;"></small></span></label>
				<? if(isset($dadosParticipante)) { ?>
					<input type="hidden" name="bd_cidade_participante" id="bd_cidade_participante" value="<?= $dadosParticipante->prt_cidade; ?>">
				<? } ?>
				<select class="form-control select" name="participante_cidade" id="participante_cidade" required="required" disabled <?= isset($disabled_input) ? "readonly":null?>>
					<option value="">- Selecione um estado</option>
				</select>
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
		<div class="col-sm-6 adjusted-block-left">
			<div class="form-group">
				<label for="participante_uf">UF</label>
				<select name="participante_uf" id="participante_uf" class="form-control select" required="required" onchange="getCidadesByEstado(this)" <?= isset($disabled_input) ? $disabled_input:null?>>
					<option value="">- Selecione</option>
					<? 
						if($estados) {
							foreach($estados as $key => $e) { ?>
								<option value="<?= $e->idestado ?>" <?= isset($dadosParticipante) ? selectedSelect($e->idestado, $dadosParticipante->prt_uf) : false;?>><?= $e->estado ?></option>
							<? } ?>
					<? } else { ?>
						<option> Nenhum registro encontrado</option>
					<? } ?>
				</select>
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
		<div class="col-sm-3 adjusted-block-right">
			<div class="form-group">
				<label for="">Cep</label>
				<input class="form-control endereco_cpf" placeholder="xxxxx-xxx" type="text" id="participante_cep" maxlength="9" minlength="9" name="participante_cep" 
				value="<?= isset($dadosParticipante) ? $dadosParticipante->prt_cep:null;?>" <?= isset($disabled_input) ? $disabled_input:null?>>
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
		<div class="col-sm-3 adjusted-block-right">
			<div class="form-group">
				<label for="">Nº.</label>
				<input class="form-control" type="text" id="participante_numero" maxlength="10" minlength="1" name="participante_numero"
				value="<?= isset($dadosParticipante) ? $dadosParticipante->prt_numero:null;?>" <?= isset($disabled_input) ? $disabled_input:null?>>
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
		<div class="col-sm-6 adjusted-block-left">
			<div class="form-group">
				<label for=""> Bairro</label>
				<input class="form-control" required="required" type="text" id="participante_bairro" name="participante_bairro" onkeyup="convertUppercase(this)"
				value="<?= isset($dadosParticipante) ? $dadosParticipante->prt_bairro:null;?>" <?= isset($disabled_input) ? $disabled_input:null?>>
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
	</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
		<div class="col-sm-6 adjusted-block-right">
			<div class="form-group">
				<label for=""> Estado Civil</label>
				<select name="participante_estado_civil" id="participante_estado_civil" class="form-control select" required="required" <?= isset($disabled_input) ? $disabled_input:null?>>
					<option value="">- Selecione</option>
					<? 
						if($estado_civil) {
							foreach($estado_civil as $key => $e) { ?>
								<option value="<?= $e->id ?>" <?= isset($dadosParticipante) ? selectedSelect($e->id, $dadosParticipante->prt_estado_civil) : false;?>><?= $e->descricao ?></option>
							<? } ?>
					<? } else { ?>
						<option> Nenhum registro encontrado</option>
					<? } ?>
				</select>
			</div>
		</div>
		<div class="col-sm-6 adjusted-block-left">
			<div class="form-group">
				<label for=""> Gênero</label>
				<select name="participante_sexo" id="participante_sexo" class="form-control select" required="required" <?= isset($disabled_input) ? $disabled_input:null?>>
					<option value="" <?= isset($dadosParticipante) ? selectedSelect('', $dadosParticipante->prt_sexo) : false;?>>- Selecione</option>
					<option value="M" <?= isset($dadosParticipante) ? selectedSelect('M', $dadosParticipante->prt_sexo) : false;?>>Masculino</option>
					<option value="F" <?= isset($dadosParticipante) ? selectedSelect('F', $dadosParticipante->prt_sexo) : false;?>>Feminino</option>
				</select>
			</div>
		</div>
	</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-6 adjusted-block-right">
				<div class="form-group">
					<label for="">Telefone (whatsapp)</label>
					<input class="form-control telefone_celular" required="required" type="text" maxlength="15" minlength="11" id="participante_telefone" name="participante_telefone" value="<?=isset($dadosParticipante) ? $dadosParticipante->prt_telefone:null;?>" <?= isset($disabled_input) ? $disabled_input:null?>>
					<div class="help-block form-text with-errors form-control-feedback"></div>
				</div>
			</div>
			<div class="col-sm-6 adjusted-block-left">
				<div class="form-group">
						<label for="">Telefone (fixo)</label>
						<input class="form-control telefone_fixo" type="text" maxlength="14" minlength="11" id="participante_telefone_fixo" name="participante_telefone_fixo" value="<?=isset($dadosParticipante) ? $dadosParticipante->prt_telefone_fixo:null;?>" <?= isset($disabled_input) ? $disabled_input:null?>>
						<div class="help-block form-text with-errors form-control-feedback"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
		<div class="col-sm-6 adjusted-block-right">
			<div class="form-group">
				<label for="">Cpf</label>
				<input class="form-control documento_cpf" required="required" type="text" id="participante_cpf" name="participante_cpf" maxlength="14" minlength="11"
				value="<?=isset($dadosParticipante) ? $dadosParticipante->prt_cpf:null;?>" <?= isset($disabled_input) ? $disabled_input:null?>>
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
		<div class="col-sm-6 adjusted-block-left">
			<div class="form-group">
				<label for="">Documento (RG)</label>
				<input class="form-control" type="text" id="participante_rg" name="participante_rg" maxlength="13" minlength="4"
				value="<?=isset($dadosParticipante) ? $dadosParticipante->prt_rg:null;?>" <?= isset($disabled_input) ? $disabled_input:null?>>
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
	</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
		<div class="col-sm-6 adjusted-block-right">
			<div class="form-group">
				<label for=""> Data de Nascimento</label>
					<input class="form-control" type="text" id="participante_datanascimento" name="participante_datanascimento" required="required" autocomplete="off"
					value="<?=isset($dadosParticipante) ? formataParaData($dadosParticipante->prt_datanascimento):null;?>" <?= isset($disabled_input) ? $disabled_input:null?>>
			</div>
		</div>
		<div class="col-sm-6 adjusted-block-left">
			<div class="form-group">
				<label for=""> E-mail</label>
				<input class="form-control" type="email" id="participante_email" name="participante_email"
				value="<?=isset($dadosParticipante) ? formataParaData($dadosParticipante->prt_email):null;?>" <?= isset($disabled_input) ? $disabled_input:null?>>
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</div>
	</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-6 adjusted-block-right">
				<div class="form-group">
					<label for="">Instagram Username</label>
					<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text">@</div>
					</div>
					<input class="form-control" placeholder="Instagram" type="text" id="participante_instagram" name="participante_instagram"
					value="<?=isset($dadosParticipante) ? formataParaData($dadosParticipante->prt_instagram):null;?>" <?= isset($disabled_input) ? $disabled_input:null?>>
					</div>
				</div>
			</div>
			<div class="col-sm-6 adjusted-block-left">
				<div class="form-group">
					<label for=""> Faixa Etária</label>
					<select name="participante_faixa_etaria" id="participante_faixa_etaria" class="form-control select" required="required" <?= isset($disabled_input) ? $disabled_input:null?>>
						<option value="">- Selecione</option>
						<? 
							if($faixa_etaria) {
								foreach($faixa_etaria as $key => $e) { ?>
									<option value="<?= $e->id ?>" <?= isset($dadosParticipante) ?  selectedSelect($e->id, $dadosParticipante->prt_faixa_etaria_id) : false;?>><?= $e->descricao ?></option>
								<? } ?>
						<? } else { ?>
							<option> Nenhum registro encontrado</option>
						<? } ?>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>