  //CONSTANTES
  var TABELA_LISTAGEM_GERAL = $("#tabela_usuarios") || null; 
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
				url: URL_BASE+`${CONTROLLER}/getListUsers`,
				type: 'POST',
				headers: {'X-Requested-With': 'XMLHttpRequest'},
				crossDomain: false
			},
			columns: [
				{"data": "usuarios_nomecompleto"},
				{"data": "usuarios_grupo_acesso"},
				{"data": "usuarios_email"},
				{"data": "usuarios_botoes"}
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
/* 	
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
 */
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
			body: JSON.stringify({usuario_id : obj.id, acao : obj.dataset.value})
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
		var inputsvazios = inputserrados = [];
		let FormCadUsuario = document.querySelector('#formCadastroUsuario') || false;
		let iForm_usuario_codigo = FormCadUsuario.usuario_codigo.value || false;
		let iForm_usuario_email = FormCadUsuario.usuario_email.value || false;
		let iForm_usuario_grupo_acesso  = FormCadUsuario.usuario_grupo_acesso.value || false;
		let iForm_usuario_nome  = FormCadUsuario.usuario_nome.value || false;
		let iForm_usuario_senha  = FormCadUsuario.usuario_senha.value || false;
		let iForm_usuario_senha_repetir  = FormCadUsuario.usuario_senha_repetir.value || false;
		let iForm_usuario_vinculo_participante  = FormCadUsuario.usuario_vinculo_participante.value || false;

		if(iForm_usuario_email.value == "") { inputsvazios.push("- Email"); _addClassInput('usuario_email', "error") }
		if(iForm_usuario_grupo_acesso.value == "") { inputsvazios.push("- Grupo de Acesso"); _addClassInput('usuario_grupo_acesso', "error") }
		if(iForm_usuario_vinculo_participante == '') {
			if(iForm_usuario_nome != "") {
				if(iForm_usuario_nome.length > 50) {
					inputserrados.push("- <b>Campo Nome completo</b>, ultrapassou o limite permitido de 40 caracteres. Verifique e tente novamente."); _addClassInput('usuario_nome', "error") 
				}
			}
		}
		if(iForm_usuario_senha_repetir != ""){
			if(iForm_usuario_senha_repetir != iForm_usuario_senha){
				inputserrados.push("<b>As senhas não coincidem</b>.Verifique e tente novamente."); _addClassInput('usuario_senha', "error") 
			}
		}
		if(inputsvazios.length > 0) {
			Swal.fire({title: 'Ops! Algo errado aqui ... ', type: 'warning', html: '<b>Você não preencheu:</b><br>' + inputsvazios.join('<br>')});
		}
		if (inputserrados.length > 0 ) {
			Swal.fire({title: 'Ops! Algo errado aqui ... ', type: 'warning', html: '<b>Erros de preenchimento:</b><br>' + inputserrados.join('<br>')});
		} else {
			preloader()
			fetch(URL_BASE+`${CONTROLLER}/salvarUsuario`, {
				method: 'post',
				body: new FormData(FormCadUsuario)
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
					_resetFormulario(FormCadUsuario)
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

	function novoUsuario(){
		var FormCadUsuario  = document.querySelector('#formCadastroUsuario'), i;
		_resetFormulario(FormCadUsuario)
		if((document.getElementById("buttons_acao").style.display == "none") && (document.getElementById("buttons_acao").style.display != null)) {
			document.getElementById("buttons_acao").style.display = "";
		}
		for(i=0; i < FormCadUsuario.length; ++i) {
			if(FormCadUsuario[i].disabled == true) {
				FormCadUsuario[i].disabled = false
			}
		}
		document.getElementById('usuario_codigo').value = null
	}

	function editarRegistro(obj) {
		if(obj) {
			preloader()
			fetch(URL_BASE+`${CONTROLLER}/getUsuario`, {
				headers: { 'Accept': 'application/json','Content-Type': 'application/json' },
				method: 'POST',
				body: JSON.stringify({usuario_id : obj.id})
			}).then(function(response){
				response.json().then(function(retorno){
					if(retorno.status == "sucesso") {
						document.getElementById('usuario_email').value = retorno.dados.login
						document.getElementById('usuario_nome').value = retorno.dados.usuario_primeiro_nome
						document.getElementById('usuario_nome_display').value = retorno.dados.usuario_nome_display
						document.getElementById('usuario_telefone').value = retorno.dados.usuario_telefone
						mascara(document.getElementById('usuario_telefone'), telefone)						
						document.getElementById('usuario_codigo').value = retorno.dados.idusuario
						retorno.dados.administrador == 1 ? document.getElementById('usuario_administrador').checked = true : document.getElementById('usuario_administrador').checked = false;
						var botoes = document.getElementById("buttons_acao") ? document.getElementById("buttons_acao") : false
						if(botoes) {
							if((botoes.style.display == "none") && (botoes.style.display != null)) {
								botoes.style.display = "";
							}
						}
						if(retorno.dados.atribuicao_id != 0) {
							document.getElementById('usuario_atribuicao').value = retorno.dados.atribuicao_id
						}else {
							document.getElementById('usuario_atribuicao').value = null
						}
						document.getElementById('usuario_grupo_acesso').value = retorno.dados.grupo_usuario_id;
						document.getElementById('usuario_genero').value = retorno.dados.genero;
						document.getElementById('usuario_vinculo_participante').value = retorno.dados.id_cadparticipante;
						
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