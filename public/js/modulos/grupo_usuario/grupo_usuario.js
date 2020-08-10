  //CONSTANTES
  var TABELA_LISTAGEM_GERAL = $("#tabela_grupousuarios") ? $("#tabela_grupousuarios") : false; 
  const URL_BASE		= document.getElementById('base_url').value;
	const CONTROLLER	= document.getElementById('currentcontroller').value;

  //VARIAVEIS
	let inputsvazios    = [];
	
	$(document).ready(function() {
		callValidationForms();
		if(Object.keys(TABELA_LISTAGEM_GERAL).length !== 0) {
			getDadosListagem()
		}
	});

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
				url: URL_BASE+CONTROLLER+'/getListGroup',
				type: 'POST',
				headers: {'X-Requested-With': 'XMLHttpRequest'},
				crossDomain: false
			},
			columns: [
				{"data": `${CONTROLLER}_descricao`},
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
			body: JSON.stringify({grupo_usuario_id : obj.id, acao : obj.dataset.value})
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

	function alterarPermissoesGrupo(obj) {
		if(obj) {
			preloader()
			fetch(URL_BASE+`${CONTROLLER}/getPermissoesGrupoUsuario`, {
				headers: { 'Accept': 'application/json','Content-Type': 'application/json' },
				method: 'POST',
				body: JSON.stringify({grupo_usuario_id : obj.id})
			}).then(function(response){
				response.json().then(function(retorno){
					if(retorno.status == "sucesso") {
						_acaoCollapse('collapseFormPermissoes', 'show')
						let inputsForm = document.querySelector('#formPermissoes');
						let getAcessos = { permissoes : retorno.dados.acessos };
						for(var i = 0; i < inputsForm.length; i++) {
							if (inputsForm[i].type == 'radio') { 
								for (x in getAcessos.permissoes) {
									for (var [key, opcao] of Object.entries(getAcessos.permissoes[x])) {
										if(opcao.menu_item === inputsForm[i].dataset.permissao && (opcao.nivel_acesso === inputsForm[i].value)) {
											inputsForm[i].checked = true;
										}
									}
								}
							}
						}
						document.getElementById('grupo_acessos_permissoes').value = obj.id
						document.getElementById('grupo_acesso').value = obj.id
						if((document.getElementById("buttons_acao").style.display == "none") && (document.getElementById("buttons_acao").style.display != null)) {
							document.getElementById("buttons_acao").style.display = "";
						}
						removePreloader()
					}
					if(retorno.status == "falha") {
						removePreloader()
						Swal.fire({
							title: retorno.title,
							html: retorno.message,
							type: retorno.tipo,
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Sim',
							cancelButtonText: 'Não, fazer depois'
						}).then((result) => {
							if (result.value) {
								_acaoCollapse('collapseFormPermissoes', 'show')
								document.getElementById('grupo_acessos_permissoes').value = obj.id
								document.getElementById('grupo_acesso').value = obj.id
								if((document.getElementById("buttons_acao").style.display == "none") && (document.getElementById("buttons_acao").style.display != null)) {
									document.getElementById("buttons_acao").style.display = "";
								}
								return;
							}
						})
						//Swal.fire({ title: retorno.title, type: retorno.tipo, html: retorno.message }); return;
					}
				})
			})
		}
	}

	function salvarDados() {
		var inputsvazios = inputserrados = [];
		let FormGrupoUsuario = document.querySelector('#formCadastroGrupoUsuario') || false;
		//let iForm_grupousuario_codigo = FormGrupoUsuario.grupo_codigo.value || false;
		let iForm_grupousuario_descricao = FormGrupoUsuario.grupo_descricao.value || false;
		let iForm_grupousuario_status = FormGrupoUsuario.grupo_status.value || false;

		if(iForm_grupousuario_status == "") { inputsvazios.push("- Status"); _addClassInput('grupo_status', "error") }
		if(iForm_grupousuario_descricao != "" || iForm_grupousuario_descricao) { 
			if(iForm_grupousuario_descricao.length > 30) {
				inputsvazios.push("- <b>Campo Descrição</b> ultrapassou o limite permitido de 30 caracteres. Verifique e tente novamente."); _addClassInput('grupo_descricao', "error") 
			}
		} else {
			inputsvazios.push("- Descrição"); _addClassInput('grupo_descricao', "error") 
		}

		if(inputsvazios.length > 0) {
			Swal.fire({title: 'Ops! Algo errado aqui ... ', type: 'warning', html: '<b>Você não preencheu:</b><br>' + inputsvazios.join('<br>')});
			return;
		}
		if (inputserrados.length > 0 ) {
			Swal.fire({title: 'Ops! Algo errado aqui ... ', type: 'warning', html: '<b>Erros de preenchimento:</b><br>' + inputserrados.join('<br>')});
			return;
		} else {
			preloader()
			fetch(URL_BASE+`${CONTROLLER}/salvarGrupoUsuario`, {
				method: 'post',
				body: new FormData(FormGrupoUsuario)
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
					_resetFormulario(FormGrupoUsuario)
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
	
	function salvarDadosPermissoes(){
		var inputs = document.querySelector('#formPermissoes');
		var permissoes = {};
		var acessos = {};
		if(document.getElementById('grupo_acesso').value == '') {
			Swal.fire({ title: 'Erro de preenchimento', type: 'warning', html: 'Selecione um <b>grupo de usuário</b> que você deseja atribuir as permissões' }); 
			return;
		}
		/**
		 *  faz a contagem de quantos radios inputs tem e para cada opção marcada, adicona o array o id do 'menu' juntamente com o 'nivel de permissao' 
		 */
		for(var i = 0; i < inputs.length; i++) {
			if (inputs[i].type == 'radio' && inputs[i].checked == true) {
				if(typeof acessos[inputs[i].dataset.menu_pai] === 'undefined') { //VERIFICA SE A CHAVE 'ID_MENU_PAI' EXISTE
					acessos[inputs[i].dataset.menu_pai] = [] //CRIA CHAVE COM ID-MENU_PAI
				}
				//POPULA OBJETO COM O OS DADOS DO INPUT RADIO
				acessos[inputs[i].dataset.menu_pai].push({menu_item : inputs[i].dataset.permissao, nivel_acesso : inputs[i].value})
			}
		}
			//ATRIBUI DADOS DO ARRAY 'ACESSOS' AO OBJETO 'PERMISSOES'
			permissoes = ({acessos})

		if(Object.keys(permissoes).length === 0) { //VERIFICA SE O OBJETO 'PERMISSOES' ESTA VAZIO
			Swal.fire({ title: 'Erro de preenchimento', type: 'warning', html: 'Selecione pelo menos uma <b>permissão de acesso</b> para este grupo' }); 
			return;
		} else {
			preloader()
			fetch(URL_BASE+`${CONTROLLER}/salvarDadosPermissoes`, {
				method: 'post',
				headers: {'Content-Type': 'application/json'},
				body: JSON.stringify({
					dados:permissoes, 
					grupo_usuario_id : document.getElementById('grupo_acesso').value 
				})
			}).then(function(response){
				response.json().then(function(retorno){
					if(retorno.status == "falha") {
						removePreloader()
						Swal.fire({
							title: retorno.title,
							type: retorno.tipo,
							html: retorno.message
						})
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
						_acaoCollapse('collapseFormPermissoes', 'hide')
						_resetFormulario(inputs)
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

	function novoGrupoUsuario(){
		var FormCadGrupoUsuario  = document.querySelector('#formCadastroGrupoUsuario'), i;
		_resetFormulario(FormCadGrupoUsuario)
		if((document.getElementById("buttons_acao").style.display == "none") && (document.getElementById("buttons_acao").style.display != null)) {
			document.getElementById("buttons_acao").style.display = "";
		}
		for(i=0; i < FormCadGrupoUsuario.length; ++i) {
			if(FormCadGrupoUsuario[i].disabled == true) {
				FormCadGrupoUsuario[i].disabled = false
			}
		}
		document.getElementById('grupo_codigo').value = null
	}

	function definirPermissoesGrupo(){
		var FormPermissoesGrupo  = document.querySelector('#formPermissoes');
		_resetFormulario(FormPermissoesGrupo)
		document.getElementById('grupo_acessos_permissoes').value = null
	}

	function editarRegistro(obj) {
		if(obj) {
			preloader()
			fetch(URL_BASE+`${CONTROLLER}/getGrupoUsuario`, {
				headers: { 'Accept': 'application/json','Content-Type': 'application/json' },
				method: 'POST',
				body: JSON.stringify({grupo_usuario_id : obj.id})
			}).then(function(response){
				response.json().then(function(retorno){
					if(retorno.status == "sucesso") {
						document.getElementById('grupo_descricao').value = retorno.dados.descricao
						document.getElementById('grupo_codigo').value = retorno.dados.id
						if((document.getElementById("buttons_acao").style.display == "none") && (document.getElementById("buttons_acao").style.display != null)) {
							document.getElementById("buttons_acao").style.display = "";
						}
						if(retorno.dados.status != 0) {
							document.getElementById('grupo_status').value = retorno.dados.status
						}else {
							document.getElementById('grupo_status').value = null
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

	function removerRegistro(obj){
		if(obj.id == "") {
			return false;
		}
		preloader()
		fetch(URL_BASE+`${CONTROLLER}/removerRegistro`, {
			headers: { 'Accept': 'application/json','Content-Type': 'application/json' },
			method: 'POST',
			body: JSON.stringify({grupo_usuario_id : obj.id})
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

	function cancelaOpcao(id) {
		let radio = document.getElementsByName('permissao_'+id)
		let grupo_acesso = document.getElementById('grupo_acesso') ? document.getElementById('grupo_acesso').value : false;
		if(grupo_acesso) {
			radio.forEach((e) =>{
				if(e.checked) {
					preloader()
					e.checked = false
					fetch(URL_BASE+`${CONTROLLER}/cancelarOpcaoDeAcesso`, {
						headers: { 'Accept': 'application/json','Content-Type': 'application/json' },
						method: 'POST',
						body: JSON.stringify({permissao_id : id, grupo_usuario : grupo_acesso})
					}).then(function(response){
							response.json().then(function(retorno){
							if(retorno.status == "sucesso") {
								removePreloader()
								_acaoCollapse('collapseFormPermissoes', 'hide')
								return true;
							}
							if(retorno.status == "falha") {
								removePreloader()
								Swal.fire({ title: 'Erro Crítico!', type: 'error', html: 'Houve falha durante o processo de registro.' })
								return false;
							}
						}).catch((err) =>
							Swal.fire({ title: 'Erro Crítico!', type: 'error', html: 'Houve falha durante o processo de registro.' })
						)
						removePreloader()
					})
				}
			})
		} else {
			Swal.fire({ title: 'Erro Critico!', type: 'error', html: '<b>Grupo de Acesso</b> não identificado'});
			return false
		}
	}