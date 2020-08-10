  //CONSTANTES
  var TABELA_LISTAGEM_GERAL = $("#tabela_materiais") ? $("#tabela_materiais") : false; 
  const URL_BASE		= document.getElementById('base_url').value;
	const CONTROLLER	= document.getElementById('currentcontroller').value;

  //VARIAVEIS
  let hostname        = $(location).attr('hostname');
  let host            = $(location).attr('pathname');
  let options         = [];
	let inputsvazios    = [];
	
	$(document).ready(function() {
		callValidationForms();
		if(Object.keys(TABELA_LISTAGEM_GERAL).length !== 0) {
			getDadosListagem()
		}
		if($('#material_detalhes')) {
			ativaCKEDITOR('material_detalhes')
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
				url: URL_BASE+`${CONTROLLER}/getListagemGeral`,
				type: 'POST',
				headers: {'X-Requested-With': 'XMLHttpRequest'},
				crossDomain: false
			},
			columns: [
				{"data": `${CONTROLLER}_descricao`},
				{"data": `${CONTROLLER}_qtd_estoque`},
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

	function novoMaterial(){
		var FormCadMaterial  = document.querySelector('#formCadastroMaterial'), i;
		_resetFormulario(FormCadMaterial)
		if((document.getElementById("buttons_acao").style.display == "none") && (document.getElementById("buttons_acao").style.display != null)) {
			document.getElementById("buttons_acao").style.display = "";
		}
		for(i=0; i < FormCadMaterial.length; ++i) {
			if(FormCadMaterial[i].disabled == true) {
				FormCadMaterial[i].disabled = false
			}
		}
		CKEDITOR.instances['material_detalhes'].setData()
		document.getElementById('material_id').value = null
	}

	function salvarDados() {
		inputsvazios = [];
		let fmaterial  = document.querySelector('#formCadastroMaterial') || false;
		let material_id = fmaterial.material_id || false;
		let material_descricao = fmaterial.material_descricao.value;
		let material_qtd = fmaterial.material_quantidade.value;
		let material_unidade = fmaterial.material_unidade.value;
	
 		if(material_descricao == "") {
		  inputsvazios.push("- Descrição do material");
		  _addClassInput('material_descricao', "error");
		} else {
			_removeClassInput('material_descricao', "error");
		}

 		if(material_qtd == "") {
		  inputsvazios.push("- Quantidade Atual");
		  _addClassInput('material_quantidade', "error");
		} else {
			_removeClassInput('material_quantidade', "error");
		}

 		if(material_unidade == "") {
		  inputsvazios.push("- Unidade não informada");
		  _addClassInput('material_unidade', "error");
		} else {
			_removeClassInput('material_unidade', "error");
		}

		if(inputsvazios.length > 0) {
		  Swal.fire({
			title: 'Ops! Algo errado aqui ... ',
			type: 'warning',
			html: '<b>Você não preencheu:</b><br>' + inputsvazios.join('<br>'),
		  });
		} else {
			if(material_descricao.length < 8 ) {
				Swal.fire({
					title: 'Ops! Algo errado aqui ... ',
					type: 'warning',
					html: '<b>Dados insuficientes. Favor informar uma descrição valida</b>',
				});
				return
			}
			preloader()
			fmaterial.material_detalhes.value = CKEDITOR.instances['material_detalhes'].getData()
			fetch(URL_BASE+`${CONTROLLER}/salvarMaterial`, {
				method: 'post',
				body: new FormData(fmaterial)
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
					if(!material_id.value) {
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
								_resetFormulario(fmaterial)
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
						_acaoCollapse('collapseFormCadastro', 'hide')
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

	function editarRegistro(obj) {
		if(obj) {
			preloader()
			fetch(URL_BASE+`${CONTROLLER}/getMaterial`, {
				headers: { 'Accept': 'application/json','Content-Type': 'application/json' },
				method: 'POST',
				body: JSON.stringify({material_id : obj.id})
			}).then(function(response){
				response.json().then(function(retorno){
					console.log(retorno.dados)
					if(retorno.status == "sucesso") {
						var FormCadMaterial  = document.querySelector('#formCadastroMaterial'), i;
						for(i=0; i < FormCadMaterial.length; ++i) {
							if(FormCadMaterial[i].disabled == true) {
								FormCadMaterial[i].disabled = false
							}
						}
						document.getElementById('material_descricao').value = retorno.dados.descricao
						document.getElementById('material_unidade').value = retorno.dados.tipo_medida
						document.getElementById('material_quantidade').value = retorno.dados.qtd_estoque
						document.getElementById('material_status').value = retorno.dados.status
						document.getElementById('material_detalhes').value = CKEDITOR.instances['material_detalhes'].setData(retorno.dados.detalhamento)
						document.getElementById('material_id').value = retorno.dados.idmaterial
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
			body: JSON.stringify({material_id : obj.id, acao : obj.dataset.value})
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