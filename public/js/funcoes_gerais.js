/****************************
 *  FUNÇÕES DE ESCOPO JQUERY
 ***************************/
const URL_BASE = document.getElementById('base_url').value;
$(function() {
	//MASCARA PARA VALORES
 // $('.valores').mask('#.###.###.###,##', {reverse: true});
  $('.valores').mask('#.##0,00', {reverse: true});

  $('.numeros').mask('#########################');

	//MASCARA PARA CEP
	$('.endereco_cpf').mask('#####-###');

	//MASCARA PARA TELEFONE CELULAR '9º' DIGITO + DDD
	$('.telefone_celular').mask('(##) #####-####');

	//MASCARA PARA TELEFONE FIXO DDD
  $('.telefone_fixo').mask('(##) ####-####');
  
  //MASCARA PARA CPF
  $('.documento_cpf').mask('###.###.###-##');

  $('.data').datepicker({
    language: "pt-BR",
    autoclose: true,
    clearBtn: true,
    startView: 0,
    endDate: '0d',
    todayHighlight: true,
    format: "dd/mm/yyyy"
  });
  
  /*******************************
  * ACCORDION WITH TOGGLE ICONS
  *******************************/
  function toggleIcon(e) {
    $(e.target)
      .prev('.panel-heading')
      .find(".more-less")
      .toggleClass('os-icon os-icon-arrow-down5 os-icon os-icon-arrow-up5');
  }

  $('.panel-group').on('hidden.bs.collapse', toggleIcon);
  $('.panel-group').on('shown.bs.collapse', toggleIcon);
});


/**
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * ****************************
 * FUNÇÕES DE ESCOPO JAVASCRIPT
 ******************************/
function preloader(){
  $('body').append(
    `<div class="preloader">
      <img class="preloader_img" src="${URL_BASE}public/images/statics/loaders/s.png">
        <div>Carregando...</div><div class="preloader-button"></div>
    </div>`);
  setTimeout(function(){
    $('.preloader-button').html('<button onclick="removePreloader()" class="btn btn-dark btn-sm">Fechar</button>');
  },10);
}

intervaloDatas = (obj) =>{
  // $('input[name="periodo_competicao"]').daterangepicker({
  $(`#${obj}`).daterangepicker({
    opens: 'left',
    locale: {
      "format": "DD/MM/YYYY",
      "separator": " - ",
      "applyLabel": "Aplicar",
      "cancelLabel": "Cancelar",
      "fromLabel": "De",
      "toLabel": "Para",
      "customRangeLabel": "Custom",
      "weekLabel": "W",
      "daysOfWeek": [
          "Do",
          "Seg",
          "Ter",
          "Qua",
          "Qui",
          "Sex",
          "Sab"
      ],
      "monthNames": [
        "Janeiro",
        "Fevereiro",
        "Março",
        "Abril",
        "Posso",
        "Junho",
        "Julho",
        "Agosto",
        "Setembro",
        "Outubro",
        "Novembro",
        "Dezembro"
      ],
      "firstDay": 1
    },

  // }, function(start, end, label) {
  //   console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
  console.log(obj)
}

function removePreloader(){
  $('.preloader').remove();
}

function convertUppercase(e) {
  return e.value = e.value.toUpperCase();
  //this.value = this.value.toUpperCase();
}

function redirecionar(destino,time) {
  let tempo = time || false;
  if(destino) {
    if(tempo) {
      preloader()
      setTimeout(function() {
        window.location.href = `${destino}`;
      }, tempo);
    } else {
      window.location.href = `${destino}`;
    }
  }
  return false;
}

function reloadTabela(obj_tabela) {
  if(typeof obj_tabela.id !== "undefined") {
    return $(`#${obj_tabela.id}`).DataTable().ajax.reload();
  }

  if(obj_tabela) {
    return obj_tabela.DataTable().ajax.reload();
  }
}

function _resetFormulario(objForm) {
  if(objForm) {
    return objForm.reset();
  }
}

function _acaoCollapse(id_objHTML, action) {
  //console.log('a')
  if(id_objHTML && action) { //verifica se o objeto e a acao enviada são válidos
    //console.log('b')
    if($(`#${id_objHTML}`).hasClass("show")) { //procura no objeto se existe a classe 'show', ou seja, esteja aberto.
      //console.log('c')
      if(action == 'hide') { // verifica se a ação enviada é ocultar, se sim aplica a ação no objeto
        //console.log('d')
        return $(`#${id_objHTML}`).collapse(`${action}`);
        //console.log('e')
      }
      if(action == 'show') { //verifica se a ação enviada é mostrar, se sim aplica a ação no objeto 
        //console.log('f')
        return $(`#${id_objHTML}`).collapse(`${action}`); //${action}
        //console.log('g')
      }
    } else {
      //caso o objeto não tenha a classe show, ou seja, esteja fechado aplica-se as ações abaixo.
      if(action == 'show') {
        // console.log('h')
        return $(`#${id_objHTML}`).collapse(`${action}`);
        //console.log('i')
      }
      // console.log('j')
    }
  }
}

/**
 * @param id_objULtabs = id do objeto html <ul> que contem as href TABS
 * @param href_objTabDestino = referencia href que corresponde a TAB que deseja realizar a exibição do conteudo
 */
function _acaoTab(id_objULtabs, href_objTabDestino, action = 'show') {
  if(id_objULtabs && href_objTabDestino && action ) { 
    return $(`#${id_objULtabs} a[href="#${href_objTabDestino}"]`).tab(action);
  }
}

function onlynumber(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  //var regex = /^[0-9.,]+$/;
  var regex = /^[0-9.]+$/;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}

/**
 * 
 * @param obj_name ID do elemento html que deseja transformar em um CKEDITOR
 */
function ativaCKEDITOR(obj_name){
  if($(`#${obj_name}`).length) {
    CKEDITOR.replace(obj_name, {
      height: 250,
      extraPlugins: 'colorbutton,colordialog'
    });
  } else {
    return false;
  }
}

function setDataSelect2(obj_name, obj_value, obj_text) {
  $(`#${obj_name}`).empty();
  return $(`#${obj_name}`).append(`<option value="${obj_value}"> ${obj_text}</option>`);
}

function injectionContent(obj, content) {
  document.getElementById(obj).innerHTML = content;
}

function limpaTabela(obj_tabela) {
  obj_tabela.DataTable().clear();
}

function _setdatapicker_dataInput(IdSeletor, ClassSelector = false, data) {
  if(IdSeletor) {
    return $(`#${IdSeletor}`).datepicker( "setDate",data);
  }
  if(ClassSelector) {
    return $(`#${ClassSelector}`).datepicker( "setDate",data);
  }
}

async function getAutorizacaoUsuario () {
  mensagem = 'Para continuar informe suas credenciais de acesso';
  url_validation_user = `${URL_BASE}usuarios/validarCredenciaisUsuario`;
  
  /** Solicitando formulario de captura de credenciais do usuario ... */
  return await geraSwalConfirm(mensagem)
  .then((dadosUsuario) => {
    
    /** Verificando de os dados retornados do formulario estão validos */
    if(dadosUsuario.login != null || (dadosUsuario.senha != null)) {

      /** Processando credenciais no servidor ... */
      return processarCredenciaisUsuario(url_validation_user, dadosUsuario)
      .then((retornoServer) => {
        /** Neste if apenas verifico de o 'status' é false se sim, informo no swal a mensagem vinda do servidor e em seguida chamo o swal novamente*/
        if(!retornoServer.status) {
          getAutorizacaoUsuario (mensagem, url_validation_user);
          Swal.showValidationMessage(retornoServer.message);
          return false;
        }

        /** Se o 'status' do processamento for true, returno aqui a resposta do servido  */
        return retornoServer;
      })
    }
  })
}

const processarCredenciaisUsuario = (url_validation_user, send) => {
  /** Envio os dados do usuário no 'fetch' para requisitar do servidor */
  return fetch(url_validation_user,{method: 'POST', body: JSON.stringify({login:send.login, senha:send.senha})})
  /** Recebo o retorno do processamento no servidor e faço return da 'resposta em JSON' */
  .then(response => response.json())
}

const geraSwalConfirm = (mensagem) => {
  return new Promise ((resolve, reject) => { 
    Swal.fire({
      title: 'Autorização',
      html:
        `<div>${mensagem}</div><br>` +
        '<label for="check-login"><strong>E-mail</strong></label>' +
        '<input id="check-login" type="email" class="form-control"><br>' +
        '<label for="check-senha"><strong>Senha</strong></label>' +
        '<input id="check-senha" type="password" class="form-control">',
      width: 450,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirmar',
      cancelButtonText: 'Cancelar',
      allowEnterKey: false,
      allowEscapeKey: false,
      showLoaderOnConfirm: true,
      preConfirm: () => {
        login = document.getElementById('check-login').value != "" ? document.getElementById('check-login').value : false,
        senha = document.getElementById('check-senha').value != "" ? document.getElementById('check-senha').value : false
        if(!login) {Swal.showValidationMessage(`Favor informe o login`);return false}
        if(!senha) {Swal.showValidationMessage(`Favor informe a senha de acesso`);return false}    
        return {login, senha}
      },
      allowOutsideClick: false
    })
    .then(result => {
      if(result.value) {
        resolve(result.value);
      }
    });
  })
}

function acaoClass(objSeletorAlvo, acao, classParam) {
  if(!objSeletorAlvo) {return false;}
  let retorno = false;
  if(acao == 'add') {
    retorno = (!$(`${objSeletorAlvo}`).hasClass(`${classParam}`)) ? $(`${objSeletorAlvo}`).addClass(`${classParam}`) : retorno;
    // retorno = document.getElementById(`${objSeletorAlvo}`).style.display = 'none';
  } else if(acao == 'remove') {
    retorno = ($(`${objSeletorAlvo}`).hasClass(`${classParam}`)) ? $(`${objSeletorAlvo}`).removeClass(`${classParam}`) : retorno;
    // retorno = document.getElementById(`${objSeletorAlvo}`).style.display = "";
  }
  return retorno;
}