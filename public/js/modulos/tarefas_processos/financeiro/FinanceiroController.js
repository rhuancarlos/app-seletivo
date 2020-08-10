  //CONSTANTES
  var TABELA_LISTAGEM_GERAL = $("#lancamentos") || false; 
  const URL_BASE		= document.getElementById('base_url').value;
	const CONTROLLER	= document.getElementById('currentcontroller').value;

  //VARIAVEIS
  let hostname        = $(location).attr('hostname');
  let host            = $(location).attr('pathname');
  let options         = [];
	let inputsvazios    = [];
	let descricao_processo1 = document.getElementById('descricao_processo_1') ? document.getElementById('descricao_processo_1') : false
	let descricao_processo2 = document.getElementById('descricao_processo_2') ? document.getElementById('descricao_processo_2') : false
	$(document).ready(function() {
		callValidationForms();
		if(Object.keys(TABELA_LISTAGEM_GERAL).length !== 0) {
			getDadosListagem()
		}



// Fetch the preselected item, and add to the control
		$('#rcb_conta_titular_conta').select2({
			placeholder: "Localizar participante",
			minimumInputLength: 3,
			allowClear: true,
			language: "pt-BR",
			ajax: {
				url: URL_BASE+'get_dados/json',
				method: 'POST',
				dataType: 'json',
				cache:true,
				data: function (params) {
					return {
						type: 'participantes',
						method: 'getByName',
						searchTerm: params.term // search term
					};
				 },
				processResults: function(data){
					let results = [];
					$.each(data, function (index, retorno) {
						results.push({
							id: retorno.idparticipante,
							text: retorno.prt_nomecompleto
						});
					});			
					return {
						results: results
					};
				},
				// results: function(data, page){		
				// 	return {results: {id: retorno.prt_nomecompleto, text: retorno.prt_nomecompleto }};
				// },
			}
		});


	});


	function getDadosListagem() {
		let opcoesFiltros = {
			situacao_pagamento: document.getElementById('filtro_situacao_pagamento'),
			tipo_conta : document.getElementById('filtro_tipo_conta')
		}
		if(opcoesFiltros.tipo_conta.value == 'conta_d') {
			$("#info").html('<h5 class="element-header">Despesas Registradas</h5>');
		}else if(opcoesFiltros.tipo_conta.value == 'conta_r') {
			$("#info").html('<h5 class="element-header">Receitas Registradas</h5>');
		}
		if(opcoesFiltros.length != 0){
			TABELA_LISTAGEM_GERAL.DataTable({
				pageLength: 25,
				lengthMenu: [5, 10, 25, 100],
				searching: true,
				ordering: false,
				processing: true,
				serverSide: true,
				filter: true,
				ajax: {
					url: URL_BASE+`${CONTROLLER}/getListagemGeral`,
					type: 'POST',
					headers: {'X-Requested-With': 'XMLHttpRequest'},
					crossDomain: false,
					data: function(d) {
						d.situacao_pagamento = opcoesFiltros.situacao_pagamento.value
						d.tipo_conta = opcoesFiltros.tipo_conta.value
					}
				},
				columns: [
					{"data": `${CONTROLLER}_descricao`},
					// {"data": `${CONTROLLER}_tipo_conta`},
					{"data": `${CONTROLLER}_valor_conta`},
					{"data": `${CONTROLLER}_dt_lancamento`},
					{"data": `${CONTROLLER}_dt_pagamento`},
					{"data": `${CONTROLLER}_botoes`}
				],
				// "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				// 	if (aData[`${CONTROLLER}_dt_pagamento`] == '') {
				// 		$('td', nRow).css('background-color', '#EFC9C9');
				// 	}else {
				// 		$('td', nRow).css('background-color', '#CCF8CF');
				// 	}
				// },
				// "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				// 	// if (aData[`${CONTROLLER}_dt_pagamento`] == '') {
				// 	// 	$('td', nRow).css('background-color', '#EFC9C9');
				// 	// }else {
				// 	// 	$('td', nRow).css('background-color', '#CCF8CF');
				// 	// }
				// 	if(aData[`${CONTROLLER}_tipo_conta`] == 'R'){
				// 		$(nRow).find('td:eq(1)').css('color', 'blue');
				// 	}
				// 	if(aData[`${CONTROLLER}_tipo_conta`] == 'D'){
				// 		$(nRow).find('td:eq(1)').css('color', 'red');
				// 	}
				// },
				language: {"url": "../public/libs/datatables.net/language/Portuguese-Brasil.json"}
			});
			$("#filtro_situacao_pagamento").on("change", function() {
				if(document.getElementById('filtro_tipo_conta').value == "") {
					Swal.fire({
						title: 'Ops! Algo errado aqui ... ',
						type: 'warning',
						html: 'É necessário informar um <b>tipo de conta</b>'
					})
					return false;
				}
				reloadTabela(TABELA_LISTAGEM_GERAL)
			});
			$("#filtro_tipo_conta").on("change", function() {
				if($(this).val() == 'conta_d') {
					$("#info").html('<h5 class="element-header">Despesas Registradas</h5>');
				}else if($(this).val() == 'conta_r') {
					$("#info").html('<h5 class="element-header">Receitas Registradas</h5>');
				} else {
					$("#info").html('');
					Swal.fire({
						title: 'Ops! Algo errado aqui ... ',
						type: 'warning',
						html: 'É necessário informar um <b>tipo de conta</b>'
					})
					return false;
				}
				reloadTabela(TABELA_LISTAGEM_GERAL)
				opcoesBuscaAvancada()
			});
		} else {
			TABELA_LISTAGEM_GERAL.DataTable({
				pageLength: 25,
				lengthMenu: [5, 10, 25, 100],
				searching: true,
				ordering: false,
				processing: true,
				serverSide: true,
				filter: true,
				ajax: {
					url: URL_BASE+`${CONTROLLER}/getListagemGeral`,
					type: 'POST',
					headers: {'X-Requested-With': 'XMLHttpRequest'},
					crossDomain: false
				},
				columns: [
					{"data": `${CONTROLLER}_descricao`},
					// {"data": `${CONTROLLER}_tipo_conta`},
					{"data": `${CONTROLLER}_valor_conta`},
					{"data": `${CONTROLLER}_dt_lancamento`},
					{"data": `${CONTROLLER}_dt_pagamento`},
					{"data": `${CONTROLLER}_botoes`}
				],
				language: {"url": "../public/libs/datatables.net/language/Portuguese-Brasil.json"}
			});
		}
	}

	function opcoesBuscaAvancada() {
		$('#busca_avancada').slideToggle('fast');
	}

	function callValidationForms(){
		if ($('.formValidate').length) {
			$('.formValidate').validator();
		}
	}
	
  function limpaTabela() {
    TABELA_LISTAGEM_GERAL.DataTable().clear();
	}
	
	function _addClassInput(input, classe) {
		let campo = $('#'+input);
		campo ? campo.addClass(classe) : false
		campo.attr('required', 'required');
	}
	
	function _removeClassInput(input, classe) {
		let campo = $('#'+input);
		if(campo.hasClass(classe)) {
			campo.removeClass(classe)
		}
	}

	function novoLancamento(){
		let FormLancamento  = document.querySelector('#formFinanceirolancamentoContas');
		let FormBaixaContas  = document.querySelector('#formFinanceiroBaixaContas');
		let FormRecebeContas  = document.querySelector('#formFinanceiroRecebimentoContas');
		let i;
		_resetFormulario(FormLancamento)
		_resetFormulario(FormBaixaContas)
		_resetFormulario(FormRecebeContas)
		if((document.getElementById("buttons_acao").style.display == "none") && (document.getElementById("buttons_acao").style.display != null)) {
			document.getElementById("buttons_acao").style.display = "";
		}
		for(i=0; i < FormLancamento.length; ++i) {
			if(FormLancamento[i].disabled == true) {
				FormLancamento[i].disabled = false
			}
		}
		acaoClass('#formFinanceiroBaixaContas','add','d-none')
		acaoClass('#formFinanceiroRecebimentoContas','add','d-none')
		acaoClass('#infobx','remove','d-none');
		
		document.getElementById('conta_id').value = null
		document.getElementById('bxconta_id').value = null
		descricao_processo1.innerHTML = '';
		descricao_processo2.innerHTML = '';
	}

	function cancelarAcaoBaixa() {
		var FormBaixaContas = document.querySelector('#formFinanceiroBaixaContas');
		for(i=0; i < FormBaixaContas.length; ++i) {
			FormBaixaContas[i].value = null
		}
		_resetFormulario(FormBaixaContas);
		descricao_processo1.innerHTML = null;
		acaoClass('#infobx','remove','d-none')
		_acaoCollapse('collapseProcessosFinanceiros', 'hide');
	}

	function cancelarAcaoReceber() {
		var FormRecebeContas = document.querySelector('#formFinanceiroRecebimentoContas');
		for(i=0; i < FormRecebeContas.length; ++i) {
			FormRecebeContas[i].value = null
		}
		_resetFormulario(FormRecebeContas);
		descricao_processo2.innerHTML = null;
		// _acaoCollapse('collapseProcessosFinanceiros', 'hide');
	}

	function salvarLancamento() {
		let flancamento  = document.querySelector('#formFinanceirolancamentoContas') || false;
		let conta_id = flancamento.conta_id || false;
		let conta_descricao = flancamento.conta_descricao.value;
		let conta_tipo = flancamento.conta_tipo.value;
		let conta_valor = flancamento.conta_valor.value;
		let conta_detalhamento = flancamento.conta_detalhamento.value;
		inputsvazios = [];
	
 		if(conta_descricao == "") {
		  inputsvazios.push("- Descrição da despesa");
		  _addClassInput('conta_descricao', "error");
		} else {
			_removeClassInput('lancamento_descricao', "error");
		}

 		if(conta_tipo == "") {
		  inputsvazios.push("- Tipo de Conta");
		  _addClassInput('conta_tipo', "error");
		} else {
			_removeClassInput('conta_tipo', "error");
		}

 		if(conta_valor == "") {
		  inputsvazios.push("- Valor da Conta");
		  _addClassInput('conta_valor', "error");
		} else {
			_removeClassInput('conta_valor', "error");
		}

		if(inputsvazios.length > 0) {
		  Swal.fire({
			title: 'Ops! Algo errado aqui ... ',
			type: 'warning',
			html: '<b>Você não preencheu:</b><br>' + inputsvazios.join('<br>'),
		  });
		} else {
			if(conta_descricao.length < 4 ) {
				Swal.fire({
					title: 'Ops! Algo errado aqui ... ',
					type: 'warning',
					html: '<b>Dados insuficientes</b>. Favor informar uma descrição valida</b>',
				});
				return
			}
			preloader()
			fetch(URL_BASE+`financeiro/financeiroLancamentoConta`, {
				method: 'post',
				body: new FormData(flancamento)
			}).then(function(response){
				response.json().then(function(retorno){
				if(retorno.status == "falha") {
					removePreloader()
					Swal.fire({
						title: retorno.title,
						type: retorno.tipo,
						html: retorno.message
					})
					_addClassInput(retorno.input, "error")
					return;
				}
				if(retorno.status == "sucesso") {
					removePreloader()
					if(!conta_id.value) {
						Swal.fire({
							title: retorno.title,
							html: retorno.message,
							type: 'success',
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Novo Registro ?',
							cancelButtonText: 'Não',
							allowOutsideClick: false,
							allowEscapeKey: false
						}).then((result) => {
							if (result.value) {
								preloader();
								_resetFormulario(flancamento)
								reloadTabela(TABELA_LISTAGEM_GERAL)
								removePreloader();
							} else {
								preloader();
								_acaoCollapse('collapseProcessosFinanceiros', 'hide')
									_resetFormulario(flancamento)
										reloadTabela(TABELA_LISTAGEM_GERAL)
											removePreloader();
							}
						})
					} else {
						Swal.fire({
							title: retorno.title,
							html: retorno.message,
							type: 'success',
							timer: retorno.close,
							showConfirmButton: false
						})
						_acaoCollapse('collapseProcessosFinanceiros', 'hide')
							reloadTabela(TABELA_LISTAGEM_GERAL)
					}
				}
				}).catch((err) =>
					Swal.fire({
					title: 'Erro Crítico!',
					type: 'error',
					html: 'Houve falha durante o processo de registro.'
					})
				);
			})
		}
	}

	function salvarBaixa() {
		let fbaixa  = document.querySelector('#formFinanceiroBaixaContas') || false;
		let conta_id = fbaixa.bxconta_id || false;
		let conta_descricao = fbaixa.bx_conta_descricao.value;
		// let conta_datapagamento = fbaixa.bx_conta_datapagamento.value;
		let conta_paga = fbaixa.bx_conta_paga;
		inputsvazios = []
		if(!conta_id || (conta_id.value == "" || conta_id.value == null)) {
			Swal.fire({
				title: 'Ops! Algo errado aqui ... ',
				type: 'error',
				html: 'Dados inconsistente para continuar, pois não conseguimos identificar a conta para pagamento.',
			});
			_acaoCollapse('collapseProcessosFinanceiros', 'hide')
			_resetFormulario(fbaixa)
			return
		}

		if(conta_descricao == "") {
		  inputsvazios.push("- Descrição da despesa");
		  _addClassInput('bx_conta_descricao', "error");
		} else {
			_removeClassInput('bx_conta_descricao', "error");
		}

		if(conta_paga.checked == false) {
		  inputsvazios.push("- Despesa paga");
		  _addClassInput('bx_conta_paga', "error");
		} else {
			_removeClassInput('bx_conta_paga', "error");
		}

		if(inputsvazios.length > 0) {
		  Swal.fire({
			title: 'Ops! Algo errado aqui ... ',
			type: 'warning',
			html: '<b>Para concluir este pagamento é necessário informar:</b><br>' + inputsvazios.join('<br>'),
		  });
		} else {
			preloader()
			fetch(URL_BASE+`financeiro/PagamentoDespesa`, {
				method: 'post',
				body: new FormData(fbaixa)
			}).then(function(response){
					response.json().then(function(retorno){
					if(retorno.status) {
						removePreloader()
						Swal.fire({title: retorno.title, html:retorno.message, type:retorno.tipo, time:retorno.close})
						_acaoCollapse('collapseProcessosFinanceiros', 'hide')
						reloadTabela(TABELA_LISTAGEM_GERAL)
						_resetFormulario(fbaixa)
						descricao_processo1.innerHTML = false;
						return;
					} else {
						removePreloader()
						Swal.fire({title: retorno.title,type: retorno.tipo,html: retorno.message})
						_addClassInput(retorno.input, "error")
						return;
					}
				}).catch((err) => Swal.fire({title: 'Erro Crítico!',type: 'error',html: 'Houve falha durante o processo de registro.'}));
			})
		}
	}

	function salvaRecebimento() {
		let frecebimento  = document.querySelector('#formFinanceiroRecebimentoContas') || false;
		let conta_id = frecebimento.recebeconta_id || false;
		let conta_titular = frecebimento.rcb_conta_titular_conta || false;
		let conta_descricao = frecebimento.rcb_conta_descricao.value;
		// let conta_datapagamento = frecebimento.bx_conta_datapagamento.value;
		let conta_recebida = frecebimento.rcb_conta_paga;
		inputsvazios = []
		if(!conta_id || (conta_id.value == "" || conta_id.value == null)) {
			Swal.fire({
				title: 'Ops! Algo errado aqui ... ',
				type: 'error',
				html: 'Dados inconsistente para continuar, pois não conseguimos identificar a conta para pagamento.',
			});
			_acaoCollapse('collapseProcessosFinanceiros', 'hide')
			_resetFormulario(fbaixa)
			return
		}

		if(conta_descricao == "") {
		  inputsvazios.push("- Descrição da despesa");
		  _addClassInput('bx_conta_descricao', "error");
		} else {
			_removeClassInput('bx_conta_descricao', "error");
		}

		if(conta_recebida.checked == false) {
		  inputsvazios.push("- Valor Recebido");
		  _addClassInput('rcb_conta_paga', "error");
		} else {
			_removeClassInput('rcb_conta_paga', "error");
		}

		if(inputsvazios.length > 0) {
		  Swal.fire({
			title: 'Ops! Algo errado aqui ... ',
			type: 'warning',
			html: '<b>Para concluir este recebimento é necessário informar:</b><br>' + inputsvazios.join('<br>'),
		  });
		} else {
			preloader()
			fetch(URL_BASE+`financeiro/RecebimentoConta`, {
				method: 'post',
				body: new FormData(frecebimento)
			}).then(function(response){
					response.json().then(function(retorno){
					if(retorno.status == true) {
						removePreloader()
						Swal.fire({title: retorno.title,html: retorno.message,type: retorno.tipo, time:retorno.close})
						_acaoCollapse('collapseProcessosFinanceiros', 'hide')
						reloadTabela(TABELA_LISTAGEM_GERAL)
						_resetFormulario(frecebimento)
						descricao_processo2.innerHTML = false;
						return;
					} else {
						removePreloader()
						Swal.fire({title: retorno.title,type: retorno.tipo,html: retorno.message})
						_addClassInput(retorno.input, "error")
						return;
					}
				}).catch((err) =>
					Swal.fire({
					title: 'Erro Crítico!',
					type: 'error',
					html: 'Houve falha durante o processo de registro.'
					})
				);
			})
		}
	}

	function recebimentoContas(objDocumento) {
		preloader()
		if(!objDocumento || (objDocumento.id == "")) {
			Swal.fire({
				title: 'Ops! Algo errado aqui ... ',
				type: 'error',
				html: 'É necessário informar o <b>número do documento.</b>',
			});
			return false;
		}
		_acaoCollapse('collapseProcessosFinanceiros', 'show');
		_acaoTab('opcoes_lancamentos', 'recebimentoContas')
		
		cancelarAcaoReceber()
		acaoClass('#inforcb','add','d-none');
		acaoClass('#formFinanceiroBaixaContas','add','d-none');
		acaoClass('#formFinanceiroRecebimentoContas','remove','d-none');
		/* Get Dados */
		
		fetch(URL_BASE+`financeiro/getDocumento`, {
			headers: { 'Accept': 'application/json','Content-Type': 'application/json' },
			method: 'POST',
			body: JSON.stringify({documento_id : objDocumento.id, tipo_lancamento : objDocumento.dataset.tipo_lancamento})
		}).then(function(response){
			response.json().then(function(retorno){
				if(retorno.status == "sucesso") {
					// $('#rcb_conta_titular_conta').empty();
					descricao_processo2.innerHTML = `<h5 class="element-header">Recebimento de Conta <span style="color:red;">#${retorno.dados.codigo_conta}</span></h5>`;
					document.getElementById('recebeconta_id').value = retorno.dados.idcontareceber
					document.getElementById('rcb_conta_tipo').value = objDocumento.dataset.tipo_lancamento
					document.getElementById('rcb_conta_descricao').value = retorno.dados.descricao
					_setdatapicker_dataInput('rcb_conta_lancamento', false, retorno.dados.data_lancamento)
					document.getElementById('rcb_conta_detalhamento').value = retorno.dados.detalhamento
					setDataSelect2('rcb_conta_titular_conta', retorno.dados.titular_id, retorno.dados.titular_nome)
					removePreloader()
				}
				if(retorno.status == "falha") {
					removePreloader()
					Swal.fire({ title: retorno.title, type: retorno.tipo, html: retorno.message }); return;
				}
			})
		})
	}
	
	async function cancelarRecebimento(documento) {
		if(!documento || (documento.id == "")) {
			Swal.fire({title: 'Ops! Algo errado aqui ... ',type: 'error',html: 'É necessário informar o <b>número do documento.</b>'});
			return false;
		}
		/**
		 * Conforme o click do usuário em cancelar o recebimento, o sistema deverá solicitar aqui
		 * o usuário a senha deste e validar na aplicação, e sendo aprovado a ação será concluida.
		 */
		await getAutorizacaoUsuario().then((autorizacao) => {
			if(autorizacao.status) {
				const cancelamento = fetch(`${URL_BASE}financeiro/cancelamentoRecebimentoConta`, {method: 'POST', body: JSON.stringify({codigo_documento: documento.id})});
				cancelamento
				.then((response) => {
					response.json()
					.then((retorno) => {
						if(!retorno.status) {
							Swal.fire({title: retorno.title,type: retorno.tipo,html: retorno.message})
						}
						Swal.fire({ title: retorno.title, type: retorno.tipo, html: retorno.message})
						.then(e => { if(e.value){ reloadTabela(TABELA_LISTAGEM_GERAL)} })
					})
				})
			}
		})
	}
	
	function realizarPagamento(objDocumento) {
		preloader()
		if(!objDocumento || (objDocumento.id == "")) {
			Swal.fire({
				title: 'Ops! Algo errado aqui ... ',
				type: 'error',
				html: 'É necessário informar o <b>número do documento.</b>',
			});
			return false;
		}
		//var FormBaixaContas  = document.querySelector('#formFinanceiroBaixaContas');
		_acaoCollapse('collapseProcessosFinanceiros', 'show');
		_acaoTab('opcoes_lancamentos', 'baixarContas');
		removePreloader()

		acaoClass('#formFinanceiroBaixaContas','remove','d-none');
		acaoClass('#infobx','add','d-none');

		cancelarAcaoBaixa()
		acaoClass('#inforbx','add','d-none');
		acaoClass('#formFinanceiroBaixaContas','remove','d-none');
		acaoClass('#formFinanceiroRecebimentoContas','add','d-none');
		/* Get Dados */
		preloader()
		fetch(URL_BASE+`financeiro/getDocumento`, {
			headers: { 'Accept': 'application/json','Content-Type': 'application/json' },
			method: 'POST',
			body: JSON.stringify({documento_id : objDocumento.id, tipo_lancamento : objDocumento.dataset.tipo_lancamento})
		}).then(function(response){
			response.json().then(function(retorno){
				if(retorno.status == "sucesso") {
					descricao_processo1.innerHTML = `<h5 class="element-header">Pagamento de Despesa <span style="color:red;">#${retorno.dados.codigo_conta}</span></h5>`;
					document.getElementById('bxconta_id').value = retorno.dados.idcontapagar
					document.getElementById('bx_conta_tipo').value = objDocumento.dataset.tipo_lancamento
					document.getElementById('bx_conta_descricao').value = retorno.dados.descricao
					document.getElementById('bx_conta_detalhamento').value = retorno.dados.detalhamento
					_setdatapicker_dataInput('bx_conta_lancamento', false, retorno.dados.data_lancamento)
					$('#bx_conta_valor').val(retorno.dados.vlr_conta)
					document.getElementById("opcoes_lancamentos").scrollIntoView();
					removePreloader()
				}
				if(retorno.status == "falha") {
					removePreloader()
					Swal.fire({ title: retorno.title, type: retorno.tipo, html: retorno.message }); return;
				}
			})
		})
	}

	async function cancelarPagamento(documento) {
		if(!documento || (documento.id == "")) {
			Swal.fire({title: 'Ops! Algo errado aqui ... ',type: 'error',html: 'É necessário informar o <b>número do documento.</b>'});
			return false;
		}
		/**
		 * Conforme o click do usuário em cancelar o pagamento, o sistema deverá solicitar aqui
		 * o usuário a senha deste e validar na aplicação, e sendo aprovado a ação será concluida.
		 */
		await getAutorizacaoUsuario().then((autorizacao) => {
			if(autorizacao.status) {
				const cancelamento = fetch(`${URL_BASE}financeiro/cancelamentoPagamentoDespesa`, {method: 'POST', body: JSON.stringify({codigo_documento: documento.id})});
				cancelamento
				.then((response) => {
					response.json()
					.then((retorno) => {
						if(!retorno.status) {
							Swal.fire({title: retorno.title,type: retorno.tipo,html: retorno.message})
						}
						Swal.fire({
							title: retorno.title,
							type: retorno.tipo,
							html: retorno.message
						}).then(e => {
							if(e.value){
								reloadTabela(TABELA_LISTAGEM_GERAL)
							}
						})
					})
				})
			}
		})
	}