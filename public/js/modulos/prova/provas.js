  //CONSTANTES
  var TABELA_LISTAGEM_GERAL = $("#tabela_provas") ? $("#tabela_provas") : false; 
  const URL_BASE		= document.getElementById('base_url').value;
	const CONTROLLER	= document.getElementById('currentcontroller').value;

  //VARIAVEIS
  let acao            = document.getElementById('acao') ? document.getElementById('acao').value : null;
  let hostname        = $(location).attr('hostname');
  let host            = $(location).attr('pathname');
  let options         = [];
	let inputsvazios    = [];
	let filtro_prova = document.getElementById('filtro_prova');
	
	$(document).ready(function() {
		callValidationForms();
		if(Object.keys(TABELA_LISTAGEM_GERAL).length !== 0) {
			getDadosListagem()
		}
		if($('#prova_detalhamento')) {
			ativaCKEDITOR('prova_detalhamento')
		}
	});

	function opcoesBuscaAvancada() {
		let busca_avancada = $('#busca_avancada');
		busca_avancada.slideToggle('fast');
	}
	
	function getDadosListagem() {
		var table	= $("#tabela_provas").DataTable({
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
				{"data": `${CONTROLLER}_codigo`},
				{"data": `${CONTROLLER}_descricao`},
				{"data": `${CONTROLLER}_botoes`}
			],
			language: {url: "public/libs/datatables.net/language/Portuguese-Brasil.json"}
		});
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

	function _resetFormulario(objForm) {
		objForm.reset();
	}

	function novaProva(){
		var FormCadProva  = document.querySelector('#formCadastroProva'), i;
		_resetFormulario(FormCadProva)
		if((document.getElementById("buttons_acao").style.display == "none") && (document.getElementById("buttons_acao").style.display != null)) {
			document.getElementById("buttons_acao").style.display = "";
		}
		for(i=0; i < FormCadProva.length; ++i) {
			if(FormCadProva[i].disabled == true) {
				FormCadProva[i].disabled = false
			}
		}
		document.getElementById('prova_id').value = null
		document.getElementById('cip').style.display = "none";
		injectionContent('cip', ``)
	}

	function salvarDados() {
		inputsvazios = [];
		let fprova  = document.querySelector('#formCadastroProva') || false;
		let prova_id = fprova.prova_id || false;
		let prova_descricao = fprova.prova_descricao.value;
		let prova_qtd_pontos = fprova.prova_qtd_pontos.value;
		let prova_tipo = fprova.prova_tipo.value;
	
 		if(prova_descricao == "") {
		  inputsvazios.push("- Descrição da prova");
		  _addClassInput('prova_descricao', "error");
		} else {
			_removeClassInput('prova_descricao', "error");
		}

 		if(prova_qtd_pontos == "") {
		  inputsvazios.push("- Qtd. Provas");
		  _addClassInput('prova_qtd_pontos', "error");
		} else {
			_removeClassInput('prova_qtd_pontos', "error");
		}

 		if(prova_tipo == "") {
		  inputsvazios.push("- Uf");
		  _addClassInput('prova_tipo', "error");
		} else {
			_removeClassInput('prova_tipo', "error");
		}

		if(inputsvazios.length > 0) {
		  Swal.fire({
			title: 'Ops! Algo errado aqui ... ',
			type: 'warning',
			html: '<b>Você não preencheu:</b><br>' + inputsvazios.join('<br>'),
		  });
		} else {
			if(prova_descricao.length < 2 ) {
				Swal.fire({
					title: 'Ops! Algo errado aqui ... ',
					type: 'warning',
					html: '<b>Dados insuficientes. Favor informar uma descrição valida</b>',
				});
				return
			}
			preloader()
			fprova.prova_detalhamento.value = CKEDITOR.instances['prova_detalhamento'].getData()
			fetch(URL_BASE+`${CONTROLLER}/salvarProva`, {
				method: 'post',
				body: new FormData(fprova)
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
					if(!prova_id.value) {
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
								_resetFormulario(fprova)
									reloadTabela(TABELA_LISTAGEM_GERAL)
									 removePreloader();
							} else {
								preloader();
									_acaoCollapse('collapseFormCadastro', 'hide')
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

	function editarRegistro(obj) {
		if(obj) {
			preloader()
			fetch(URL_BASE+`${CONTROLLER}/getProva`, {
				headers: { 'Accept': 'application/json','Content-Type': 'application/json' },
				method: 'POST',
				body: JSON.stringify({prova_id : obj.id})
			}).then(function(response){
				response.json().then(function(retorno){
					if(retorno.status == "sucesso") {
						var FormCadProva  = document.querySelector('#formCadastroProva'), i;
						for(i=0; i < FormCadProva.length; ++i) {
							if(FormCadProva[i].disabled == true) {
								FormCadProva[i].disabled = false
							}
						}

						injectionContent('cip', `<div class="form-group">
						<label for="prova_codigo">CIP</label>
							<input class="form-control" type="text" id="prova_codigo" name="prova_codigo" minlength="10" required="required" disabled="disabled" value="">
						<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>`)
						document.getElementById('cip').style.display = "";
						document.getElementById('prova_descricao').value = retorno.dados.descricao
						document.getElementById('prova_tipo').value = retorno.dados.tipo_disputa
						document.getElementById('prova_qtd_pontos').value = retorno.dados.qtd_pontos
						document.getElementById('prova_status').value = retorno.dados.status
						document.getElementById('prova_detalhamento').value = CKEDITOR.instances['prova_detalhamento'].setData(retorno.dados.detalhamento)
						document.getElementById('prova_codigo').value = retorno.dados.codigo
						document.getElementById('prova_id').value = retorno.dados.idprova
						if((document.getElementById("buttons_acao").style.display == "none") && (document.getElementById("buttons_acao").style.display != null)) {
							document.getElementById("buttons_acao").style.display = "";
						}
						removePreloader()
						_acaoCollapse('collapseFormCadastro', 'show')
					}
					if(retorno.status == "falha") {
						removePreloader()
						Swal.fire({ title: retorno.title, type: retorno.tipo, html: retorno.message }); return;
					}
				})
			})
		}	
	}

	function mudarStatus(obj) {
		if(obj.id == "" || obj.dataset.value == "") {
			return false;
		}
		preloader()
		fetch(URL_BASE+`${CONTROLLER}/mudarStatus`, {
			headers: { 'Accept': 'application/json','Content-Type': 'application/json' },
			method: 'POST',
			body: JSON.stringify({prova_id : obj.id, acao : obj.dataset.value})
		}).then(function(response){
			response.json().then(function(retorno){
			if(retorno.status == "falha") {
				removePreloader()
				Swal.fire({ title: retorno.title, type: retorno.tipo, html: retorno.message })
				return;
			}
			if(retorno.status == "sucesso") {
				removePreloader()
				Swal.fire({ title: retorno.title, type: retorno.tipo, html: retorno.message, timer: retorno.close, showConfirmButton: false })
				reloadTabela(TABELA_LISTAGEM_GERAL)
			}
			}).catch((err) =>
				Swal.fire({ title: 'Erro Crítico!', type: 'error', html: 'Houve falha durante o processo de registro.' })
			)
			removePreloader()
		})
	}