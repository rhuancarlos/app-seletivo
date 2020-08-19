<h6 class="element-header">
	<a href="javascript:history.back()" title="Voltar">
		<i class="os-icon os-icon-common-07"></i>
	</a> 
	<?= strtoupper($titulo_home).' / '. '<span class="ultimo-nivel-pagina">'.strtoupper($titulo_home2).'</span>'; ?>
</h6>
<div class="element-box">
		<legend>
			<span>Informações Pessoais</span>
		</legend>
			<?= isset($dadosParticipante) ? "<small style='color:#c1b7b7;'><strong>Última atualização:</strong> ".formataParaData($dadosParticipante->prt_modificacao, false, "/", true, true)."</small>": null;?>
		<!-- Inputs Form@dados_pessoais -->
		<div class="alert alert-warning alert-dismissible fade show" role="alert">
			<small> Todos os campos destacados <strong>são de preenchimento obrigatório.</strong></small>
    </div>
		<?php require(VIEW_MODULO_PARTICIPANTES.'r_inputs_pessoais.php')?>
		</BR>
		<legend>
			<span>Outras Informações</span>
		</legend>
		<!-- Inputs Form@dados_outros -->
		<?php require(VIEW_MODULO_PARTICIPANTES.'r_inputs_outros.php')?>
</div>