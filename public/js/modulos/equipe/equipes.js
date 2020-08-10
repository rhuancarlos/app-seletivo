  //CONSTANTES
  var TABELA_LISTAGEM_GERAL = $("#tabela_equipes") || null; 
  const URL_BASE		= document.getElementById('base_url').value;
	const CONTROLLER	= document.getElementById('currentcontroller').value;

  //VARIAVEIS
  let acao            = document.getElementById('acao') ? document.getElementById('acao').value : null;
  let hostname        = $(location).attr('hostname');
  let host            = $(location).attr('pathname');
  let options         = [];
	let inputsvazios    = [];
	let filtro_equipe 	= document.getElementById('filtro_equipe');
	
	$(function(){
		callValidationForms();
		getDadosListagem();
	});

	function opcoesBuscaAvancada() {
		let busca_avancada = $('#busca_avancada');
		busca_avancada.slideToggle('fast');
	}
	
	function getDadosListagem() {
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
				{"data": `${CONTROLLER}_codigo`},
				{"data": `${CONTROLLER}_descricao`},
				{"data": `${CONTROLLER}_sigla`},
				{"data": `${CONTROLLER}_botoes`}
			],
			language: {"url": "public/libs/datatables.net/language/Portuguese-Brasil.json"}
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
	
	function novaEquipe(){
		var FormCadEquipe  = document.querySelector('#formCadastroEquipe'), i;
		_resetFormulario(FormCadEquipe)
		if((document.getElementById("buttons_acao").style.display == "none") && (document.getElementById("buttons_acao").style.display != null)) {
			document.getElementById("buttons_acao").style.display = "";
		}
		for(i=0; i < FormCadEquipe.length; ++i) {
			if(FormCadEquipe[i].disabled == true) {
				FormCadEquipe[i].disabled = false
			}
		}
		document.getElementById('equipe_codigo').value = null
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

	function mudarStatus(obj) {
		if(obj.id == "" || obj.dataset.value == "") {
			return false;
		}
		preloader()
		fetch(URL_BASE+`${CONTROLLER}/mudarStatus`, {
			headers: { 'Accept': 'application/json','Content-Type': 'application/json' },
			method: 'POST',
			body: JSON.stringify({equipe_id : obj.id, acao : obj.dataset.value})
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

	function salvarDados() {
		var inputsvazios = [];
		let FormCadEquipe  = document.querySelector('#formCadastroEquipe') || false;
		let iForm_equipe_codigo = FormCadEquipe.equipe_codigo || false;
		let iForm_equipe_nome  = FormCadEquipe.equipe_nome || false;
		let iForm_equipe_sigla  = FormCadEquipe.equipe_sigla || false;

		if(iForm_equipe_nome.value == "") { inputsvazios.push("- Nome da Equipe"); _addClassInput('equipe_nome', "error") }
		if(iForm_equipe_sigla.value == "") { inputsvazios.push("- Sigla da Equipe"); _addClassInput('equipe_sigla', "error") }
		if(iForm_equipe_nome.value.length > 30) { inputsvazios.push("- Nome da equipe ultrapassa o limite permitido. "); _addClassInput('equipe_nome', "error")}
		if(iForm_equipe_sigla.value.length > 6) { inputsvazios.push("- Sigla da equipe ultrapassa o limite permitido. "); _addClassInput('equipe_sigla', "error")}

		if(inputsvazios.length > 0) {
			Swal.fire({
			title: 'Ops! Algo errado aqui ... ',
			type: 'warning',
			html: '<b>Você não preencheu:</b><br>' + inputsvazios.join('<br>'),
			});
		} else {
			preloader()
			fetch(URL_BASE+`${CONTROLLER}/salvarEquipe`, {
				method: 'post',
				body: new FormData(FormCadEquipe)
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
					Swal.fire({
						title: retorno.title,
						html: retorno.message,
						type: retorno.tipo,
						timer: retorno.close,
						showConfirmButton: false
					})
					_acaoCollapse('collapseFormCadastro', 'hide')
					reloadTabela(TABELA_LISTAGEM_GERAL)
					_resetFormulario(FormCadEquipe)
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
			//_acaoCollapse('collapseFormCadastro', 'hide')
			fetch(URL_BASE+`${CONTROLLER}/getEquipe`, {
				headers: { 'Accept': 'application/json','Content-Type': 'application/json' },
				method: 'POST',
				body: JSON.stringify({equipe_id : obj.id})
			}).then(function(response){
				response.json().then(function(retorno){
					if(retorno.status == "sucesso") {
						var FormCadEquipe  = document.querySelector('#formCadastroEquipe'), i;
						for(i=0; i < FormCadEquipe.length; ++i) {
							if(FormCadEquipe[i].disabled == true) {
								FormCadEquipe[i].disabled = false
							}
						}
						document.getElementById('equipe_nome').value = retorno.dados.descricao
						document.getElementById('equipe_sigla').value = retorno.dados.sigla
						document.getElementById('equipe_cor_1').value = retorno.dados.style_backgroud_cor_1
						document.getElementById('equipe_cor_2').value = retorno.dados.style_backgroud_cor_2
						document.getElementById('equipe_codigo').value = retorno.dados.idequipe
						retorno.dados.mostrar_widget_tela_inicial == 1 ? document.getElementById('equipe_mostra_tela_inicial').checked = true : document.getElementById('equipe_mostra_tela_inicial').checked = false;
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

	function abrirRegistro(obj) {
		_acaoCollapse('collapseFormCadastro', 'hide')
		if(obj) {
			preloader()
			fetch(URL_BASE+`${CONTROLLER}/getEquipe`, {
				headers: { 'Accept': 'application/json','Content-Type': 'application/json' },
				method: 'POST',
				body: JSON.stringify({equipe_id : obj.id})
			}).then(function(response){
				response.json().then(function(retorno){
					_acaoCollapse('collapseFormCadastro', 'show')
					if(retorno.status == "sucesso") {
						var FormCadEquipe  = document.querySelector('#formCadastroEquipe'), i;
						for(i=0; i < FormCadEquipe.length; ++i) {
							FormCadEquipe[i].disabled = true;
							if(FormCadEquipe[i].name == "equipe_nome") { FormCadEquipe[i].value = retorno.dados.descricao }
							if(FormCadEquipe[i].name == "equipe_sigla") { FormCadEquipe[i].value = retorno.dados.sigla }
							if(FormCadEquipe[i].name == "equipe_cor_1") { FormCadEquipe[i].value = retorno.dados.style_backgroud_cor_1 }
							if(FormCadEquipe[i].name == "equipe_cor_2") { FormCadEquipe[i].value = retorno.dados.style_backgroud_cor_2 }
							if(FormCadEquipe[i].name == "equipe_codigo") { FormCadEquipe[i].equipe_codigo = null }
							retorno.dados.mostrar_widget_tela_inicial == 1 ? document.getElementById('equipe_mostra_tela_inicial').checked = true : document.getElementById('equipe_mostra_tela_inicial').checked = false;
						}
						document.querySelector("#buttons_acao").style.display='none'
						removePreloader()
					}
					if(retorno.status == "falha") {
						removePreloader()
						Swal.fire({ title: retorno.title, type: retorno.tipo, html: retorno.message }); return;
					}
				})
			})
		}	
	}