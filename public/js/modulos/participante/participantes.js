  //CONSTANTES
  var TABELA_LISTAGEM_GERAL = $("#tabela_participantes") || null; 
  const URL_BASE		= document.getElementById('base_url').value;
	const CONTROLLER	= document.getElementById('currentcontroller').value;

  //VARIAVEIS
  let acao            = document.getElementById('acao') ? document.getElementById('acao').value : null;
  let hostname        = $(location).attr('hostname');
  let host            = $(location).attr('pathname');
  let options         = [];
	let inputsvazios    = [];
	let filtro_equipe = document.getElementById('filtro_equipe');
	
	$(document).ready(function() {
		//getEstado(false)
		$('input[name="participante_datanascimento"]').datepicker({
			language: "pt-BR",
			autoclose: true,
			clearBtn: true,
			startView: 0,
			endDate: '0d',
			todayHighlight: true,
			format: "dd/mm/yyyy"
		});
		if(Object.keys(TABELA_LISTAGEM_GERAL).length !== 0) {
			getDadosListagem()
		}
		callValidationForms();
		getCidadesByEstado();
	});

	function opcoesBuscaAvancada() {
		let busca_avancada = $('#busca_avancada');
		busca_avancada.slideToggle('fast');
	}
	
	function getDadosListagem() {
		let equipe = document.getElementById('filtro_equipe')
		var filtros = {
			equipe: equipe
		}

		if(filtros) {
			TABELA_LISTAGEM_GERAL.DataTable({
				pageLength: 25,
				lengthMenu: [5, 10, 25, 100],
				searching: true,
				ordering: false,
				processing: true,
				serverSide: true,
				filter: true,
				ajax: {
					url: URL_BASE+`${CONTROLLER}/getListParticipant`,
					type: 'POST',
					headers: {'X-Requested-With': 'XMLHttpRequest'},
					crossDomain: false,
					data: function (d) {
						d.filtro_equipe = filtros.equipe.value
					}
				},
				columns: [
					{"data": `${CONTROLLER}_codigo`},
					{"data": `${CONTROLLER}_nome`},
					{"data": `${CONTROLLER}_dados_pessoais`},
					{"data": `${CONTROLLER}_dados_competicao`},
					{"data": `${CONTROLLER}_telefone1`},
					{"data": `${CONTROLLER}_botoes`}
				],
				language: {"url": "public/libs/datatables.net/language/Portuguese-Brasil.json"}
			});
			$("#filtro_equipe").on("change", function() {
				reloadTabela(TABELA_LISTAGEM_GERAL)
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
					url: URL_BASE+`${CONTROLLER}/getListParticipant`,
					type: 'POST',
					headers: {'X-Requested-With': 'XMLHttpRequest'},
					crossDomain: false
				},
				columns: [
					{"data": `${CONTROLLER}_codigo`},
					{"data": `${CONTROLLER}_nome`},
					{"data": `${CONTROLLER}_dados_pessoais`},
					{"data": `${CONTROLLER}_dados_competicao`},
					{"data": `${CONTROLLER}_telefone1`},
					{"data": `${CONTROLLER}_botoes`}
				],
				language: {"url": "public/libs/datatables.net/language/Portuguese-Brasil.json"}
			});
		}
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

	function salvarDados(e) {
		e.preventDefault();
	
		inputsvazios = [];
		let formulario_cadastro  = document.querySelector('#formCadastroParticipante') || false;
		let participante_codigo = formulario_cadastro.participante_codigo || false;
		let participante_nomecompleto = formulario_cadastro.participante_nomecompleto.value; 
		let participante_cidade = formulario_cadastro.participante_cidade.value; 
		let participante_uf = formulario_cadastro.participante_uf.value; 
		let participante_endereco = formulario_cadastro.participante_endereco.value; 
		let participante_telefone = formulario_cadastro.participante_telefone.value; 
		let participante_bairro = formulario_cadastro.participante_bairro.value; 
		let participante_sexo = formulario_cadastro.participante_sexo.value; 
		let participante_cpf = formulario_cadastro.participante_cpf.value;
		let participante_faixa_etaria = formulario_cadastro.participante_faixa_etaria.value;
		let participante_datanascimento = formulario_cadastro.participante_datanascimento.value;
		let participante_estado_civil = formulario_cadastro.participante_estado_civil.value;
	
 		if(participante_nomecompleto == "") {
		  inputsvazios.push("- Nome do Participante");
		  _addClassInput('participante_nomecompleto', "error");
		} else {
			_removeClassInput('participante_nomecompleto', "error");
		}

 		if(participante_cidade == "") {
		  inputsvazios.push("- Cidade");
		  _addClassInput('participante_cidade', "error");
		} else {
			_removeClassInput('participante_cidade', "error");
		}

 		if(participante_uf == "") {
		  inputsvazios.push("- Uf");
		  _addClassInput('participante_uf', "error");
		} else {
			_removeClassInput('participante_uf', "error");
		}

 		if(participante_endereco == "") {
		  inputsvazios.push("- Endereço");
		  _addClassInput('participante_endereco', "error");
		} else {
			_removeClassInput('participante_endereco', "error");
		}

 		if(participante_bairro == "") {
		  inputsvazios.push("- Bairro");
		  _addClassInput('participante_bairro', "error");
		} else {
			_removeClassInput('participante_bairro', "error");
		}

 		if(participante_datanascimento == "") {
		  inputsvazios.push("- Data de Nascimento");
		  _addClassInput('participante_datanascimento', "error");
		} else {
			_removeClassInput('participante_datanascimento', "error");
		}

 		if(participante_telefone == "") {
		  inputsvazios.push("- Telefone Whatsapp");
		  _addClassInput('participante_telefone', "error");
		} else {
			_removeClassInput('participante_telefone', "error");
		}

 		if(participante_sexo == "") {
		  inputsvazios.push("- Gênero");
		  _addClassInput('participante_sexo', "error");
		} else {
			_removeClassInput('participante_sexo', "error");
		}

 		if(participante_cpf == "") {
		  inputsvazios.push("- Cpf");
		  _addClassInput('participante_cpf', "error");
		} else {
			_removeClassInput('participante_cpf', "error");
		}

		if(participante_faixa_etaria == "") {
		  inputsvazios.push("- Faixa Etária");
		  _addClassInput('participante_faixa_etaria', "error");
		} else {
			_removeClassInput('participante_faixa_etaria', "error");
		}

		if(participante_estado_civil == "") {
		  inputsvazios.push("- Estado Civil");
		  _addClassInput('participante_estado_civil', "error");
		} else {
			_removeClassInput('participante_estado_civil', "error");
		}

		if(inputsvazios.length > 0) {
		  Swal.fire({
			title: 'Ops! Algo errado aqui ... ',
			type: 'warning',
			html: '<b>Você não preencheu:</b><br>' + inputsvazios.join('<br>'),
		  });
		  //$("#nextstep").prop("disabled",)
		} else {
			if(participante_nomecompleto.length < 10 ) {
				Swal.fire({
					title: 'Ops! Algo errado aqui ... ',
					type: 'warning',
					html: '<b>Dados insuficientes. Favor informar o nome completo</b>',
				});
				return
			}
			preloader()
			fetch(URL_BASE+`${CONTROLLER}/salvarParticipante`, {
				method: 'post',
				body: new FormData(formulario_cadastro)
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
					if(!participante_codigo.value) {
						Swal.fire({
							title: retorno.title,
							html: retorno.message,
							type: 'success',
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Novo Registro ?',
							cancelButtonText: 'Não'
						}).then((result) => {
							if (result.value) {
								preloader();
								_resetFormulario(formulario_cadastro)
								removePreloader();
							} else {
								preloader();
								//setTimeout(function() {
									window.location.href = `${URL_BASE}`+`${CONTROLLER}`;
								//}, 3000);
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

	function getCidadesByEstado(obj = false) {
		if(obj){
			var estado = !obj || obj.options[obj.selectedIndex];
			let cidade = document.getElementById('participante_cidade');
			let total_registros = document.getElementById('total_registros_encontrados') || false;
			let params = {
				method: "post",
				body: JSON.stringify({'estado_id':estado.value}),
				headers: {
				'Content-Type': 'application/json',  // sent request
				'Accept':       'application/json'   // expected data sent back
				}
			};
			options = [];
			if(estado.value != "") {
				preloader();
				cidade.innerHTML = '<option> Carregando ... </option>';
				fetch(URL_BASE+'cidade/getCidadesByEstado', params)
				.then(function(response){
					response.json().then(function(retorno){
						$.each(retorno.cidades, function(i, e){	
							total_registros.innerHTML = retorno.total_registros;
							options.push(`<option value=${e.idcidade}>${e.municipio}</option>`);
						});
						cidade.innerHTML = options;
						cidade.disabled = false;
						removePreloader();
					}).catch(function(error){
						Swal.fire({
							title: 'Erro Crítico!',
							type: 'error',
							html: 'Houve falha durante o processo de registro.'
						})
						console.log(error)
					});
				})
			} else {
				cidade.innerHTML = '<option value="">- Selecione um estado</option>';
				cidade.disabled = true;
				total_registros.innerHTML = '';
			}
		} else {
			var estado = document.getElementById('participante_uf') || false ;
			let cidade = document.getElementById('participante_cidade') || false;
			let cidade_db = document.getElementById('bd_cidade_participante') || false;
			let total_registros = document.getElementById('total_registros_encontrados') || false;
			let params = {
				method: "post",
				body: JSON.stringify({'estado_id':estado.value}),
				headers: {
				'Content-Type': 'application/json',  // sent request
				'Accept':       'application/json'   // expected data sent back
				}
			};
			options = [];
			if(cidade_db.value != "") {
				preloader();
				cidade.innerHTML = '<option> Carregando ... </option>';
				fetch(URL_BASE+'cidade/getCidadesByEstado', params)
				.then(function(response){
					response.json().then(function(retorno){
						if(retorno.status == 'falha') {
							cidade.innerHTML = '<option value="">- Selecione um estado</option>';
							removePreloader();
							return;
						}
						$.each(retorno.cidades, function(i, e){	
							total_registros.innerHTML = retorno.total_registros;
								if(cidade_db.value == e.idcidade) {
									options.push(`<option value=${e.idcidade} selected>${e.municipio}</option>`);
								} else {
									options.push(`<option value=${e.idcidade} >${e.municipio}</option>`);
								}
							});
						cidade.innerHTML = options;
						cidade.disabled = false;
						removePreloader();
					}).catch(function(error){
						Swal.fire({
							title: 'Erro Crítico!',
							type: 'error',
							html: 'Houve falha durante o processo de registro.'
						})
						console.log(error)
					});
				})
			}
		}
	}