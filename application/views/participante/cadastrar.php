<?= geraElementHeaderPage(array($titulo_home,$titulo_home2)); ?>
<div class="element-box">
	<form id="formCadastroParticipante" name="formCadastroParticipante" class="formValidate" enctype="multipart/form-data" method="POST">
	<?PHP if(isset($dadosParticipante)) { ?>
		<input type="hidden" name="participante_codigo" id="participante_codigo" value="<?= $dadosParticipante->idparticipante ?>">
	<?PHP } ?>
		<legend>
			<span>Informações Pessoais</span>
		</legend>
		<!-- Inputs Form@dados_pessoais -->
		<div class="alert alert-warning alert-dismissible fade show" role="alert">
			<small> Todos os campos destacados <strong>são de preenchimento obrigatório.</strong></small>
    </div>
		<?= isset($dadosParticipante->prt_modificacao) ? "<small style='color:#c1b7b7;'><strong>Última atualização:</strong> ".formataParaData($dadosParticipante->prt_modificacao, false, "/", true, true)."</small>": null;?>
		<?php require(VIEW_MODULO_PARTICIPANTES.'r_inputs_pessoais.php')?>
		</BR>
		<legend>
			<span>Outras Informações</span>
		</legend>
		<!-- Inputs Form@dados_outros -->
		<?php require(VIEW_MODULO_PARTICIPANTES.'r_inputs_outros.php')?>
		<? if(!isset($disabled_input)) { ?>
			<div class="form-buttons-w">
				<button class="btn btn-primary" onclick="salvarDados(event)" id="btn_gravar_continuar"> Gravar </button>
				<button class="btn btn-danger" type="reset"> Cancelar </button>
			</div>
		<? } ?>
	</form>
</div>