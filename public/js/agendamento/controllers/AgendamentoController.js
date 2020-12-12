var app = angular.module("ibnfagendamento",["ng.deviceDetector", "ngSanitize","ngAnimate", "funcoesAngular"]);

app.controller("AgendamentoController", function($scope, deviceDetector, agendamentoApi){
  $scope.screenStage = 1;
  $scope.screenLimiteStage = 5;
  $scope.dados = [];
  $scope.dadosAgendamento = {};
  $scope.btnNextStage = document.getElementById('btnNextStage');
  $scope.btnBackStage = document.getElementById('btnBackStage');
  $scope.data = deviceDetector;
  $scope.allData = JSON.stringify($scope.data, null, 2);
  $scope.dataDefault = {};
  $scope.load = false;
  $scope.cpfValid = false;
  $scope.dadosStages = {};
  $scope.ofertaSelecionada = null;
  $scope.mostrarBrinde = false;

  $scope.getDataDefault = (_) => {
    preloader();
    agendamentoApi.getDataDefault().then((response) => {
      removePreloader();
      if(response.data.status) {
        for (const key in response.data.dados.Campanhas) {
          if (response.data.dados.Campanhas.hasOwnProperty(key)) {
            const element = response.data.dados.Campanhas[key];
            if(element.parametro == 'habilitar_agendamento') {
              $scope.dataDefault.habilitar_agendamento = element.value;
            }
            if(element.parametro == 'validar_autenticidade_por') {
              $scope.dataDefault.validar_autenticidade_por = element.value;
            }
            if(element.parametro == 'exibir_contagem_vagas') {
              $scope.dataDefault.exibir_contagem_vagas = element.value == 1 ? true : false;
            }
          }
        }
      }
    });
  }
  $scope.getDataDefault();

  $scope.nextScreenStage = (form, dados) => {
    $scope.checkNextStage(form, dados);
    if(form != $scope.screenLimiteStage) {
      $scope.screenStage = form+1;
      if($scope.screenStage == 4) {
        $scope.getDataStages($scope.screenStage);
      }
      return $scope.screenStage;
    }
  }

  $scope.myData = _ => {
    return $scope.screenStage = 'myData';
  }

  $scope.getDataStages = (stage) => {
    preloader();
    agendamentoApi.getDataStages(stage).then((response) => {
      removePreloader();
      if(response.data.status) {
        if(typeof $scope.dadosStages[response.data.dados.name] === 'undefined') {
          $scope.dadosStages[response.data.dados.name] = {};
        }
        $scope.dadosStages[response.data.dados.name] = response.data.dados.conteudo;
      }
    });
  }

  $scope.backScreenStage = (form) => {
    if(form == 'myData') {
      return $scope.screenStage = 1;
    }
    return $scope.screenStage = form-1;
  }
  
  $scope.cancelScheduling = () => {
    $scope.dadosAgendamento.dados_pessoais = {}
    $scope.screenStage = 1;
  }
  
  $scope.checkNextStage = (stageCurrent, formulario) => {
    let inputsInvalids = []
    if(stageCurrent == 2) {
      if(!$scope.dadosAgendamento.dados_pessoais) {
        return true;
      } else {
        if(!$scope.isEmpty(formulario)) {
          return true;
        } else {
          console.log($scope.cpfValid)
          if(!$scope.cpfValid) {
            return true;
          }
        }
      }
      return false;
    }
    if(stageCurrent == 3) {
      if(!$scope.dadosAgendamento.dados_pessoais) {
        return true;
      } else {
        if(!$scope.isEmpty(formulario)) {
          return true;
        }
      }
      return false;
    }
    if(stageCurrent == 4) {
      if(!$scope.dadosAgendamento.dados_oferta) {
        return true;
      } else {
        if(!$scope.isEmpty(formulario)) {
          return true;
        }
      }
      return false;
    }
    if(stageCurrent == $scope.screenLimiteStage) { 
      return true;
    }
  }

  $scope.isEmpty = function(obj) {
    for(var prop in obj) {
      if(obj.hasOwnProperty(prop))
        return false;
    }
    return true;
  }

  $scope.trocarOferta = function() {
    $scope.dadosAgendamento.dados_oferta.ofertaSelecionada = null;
    $scope.ofertaSelecionada = null;
  }
  
  $scope.confirmedOffer = (opcaoEscolhida, index) => { 
    if(index !== document.getElementById(index).id) {
      $scope.ofertaSelecionada = index;
    }
  }

  $scope.finishScheduling = (dadosAgendamento) => {
    preloader();
    let inputsvazios = [];
    if($scope.isEmpty(dadosAgendamento)) {
      removePreloader();
      Swal.fire({type: 'warning',title: 'Ops... Algo errado',html: 'Por favor verifique as opções do formulário'});
      return false;
    } else {
      if(!$scope.dadosAgendamento.dados_pessoais.nome_completo || $scope.dadosAgendamento.dados_pessoais.nome_completo == "") {
        inputsvazios.push("- Nome Completo");
      }
      if(!$scope.dadosAgendamento.dados_pessoais.cpf || $scope.dadosAgendamento.dados_pessoais.cpf == "") {
        inputsvazios.push("- CPF");
      }
      if(!$scope.dadosAgendamento.dados_pessoais.email || $scope.dadosAgendamento.dados_pessoais.email == "") {
        inputsvazios.push("- E-mail");
      }
      if(!$scope.dadosAgendamento.dados_pessoais.data_nascimento || $scope.dadosAgendamento.dados_pessoais.data_nascimento == "") {
        inputsvazios.push("- Data de Nascimento");
      }
      if(!$scope.dadosAgendamento.dados_pessoais.telefone || $scope.dadosAgendamento.dados_pessoais.telefone == "") {
        inputsvazios.push("- Telefone");
      }
      if(!$scope.dadosAgendamento.dados_pessoais.descendencia || $scope.dadosAgendamento.dados_pessoais.descendencia == "") {
        inputsvazios.push("- Descendência");
      }
      if(inputsvazios.length > 0) {
        removePreloader();
        Swal.fire({title: 'Ops! Algo errado aqui ... ', type: 'warning', html: '<b>Você não preencheu:</b><br>' + inputsvazios.join('<br>') });
      } else {
        agendamentoApi.saveScheduling(dadosAgendamento).then((response) => {
          removePreloader();
          if(!response.data.status) {
            Swal.fire({type:response.data.tipo, title: 'Ops... Algo errado', html: response.data.mensagem});
            return false;
          }
          if(response.data.status) {
            Swal.fire({type:response.data.tipo, title: 'êba! Tudo certo aqui', html: response.data.mensagem, showCancelButton: true, confirmButtonText: 'Dados de Inscrição', cancelButtonText: 'Cancelar', cancelButtonColor: '#d33'
            }).then((result) => {
              if(result.value) {
                Swal.fire({type:response.data.tipo, title: 'Dados da inscrição', html: `<br><br>Inscrição: ${response.data.dados_inscricao.codigoInscricao}</br>Data de Inscrição: ${response.data.dados_inscricao.data_inscricao}<br>Nome do Solicitante: ${response.data.dados_inscricao.nomeSolicitante}<br>Data de Nascimento: ${response.data.dados_inscricao.dataNascimento}`});
              }
              $scope.EmptyData();
            });
            $scope.EmptyData();
          }
        });
      }
    }
  }
  
  $scope.EmptyData = _ => {
    $scope.dadosAgendamento = {};
    $scope.screenStage = 1;
    $scope.ofertaSelecionada = null;    
  }

  $scope.checkCPF = (cpf, formAgendamento) => {
    if(cpf !== '' && (typeof cpf !== 'undefined')) {
      if(isValidCPF(cpf)) {
        $scope.cpfValid = true;
      } else {
        $scope.cpfValid = false;
      }
    }
  }

  $scope.getAddressCep = (cepInput) => {
    preloader();
    $scope.load = true;
    if(cepInput) {
      removePreloader();
      agendamentoApi.getAddressCep(cepInput).then((response) => {
        if(!response) {
          $scope.load = false;
          Swal.fire({type:'danger', html: 'Cep inválido ou não informado. Verifique e tente novamente'});
          return;
        } else {
          $scope.load = false;
          $scope.dadosAgendamento.dados_pessoais.localizacao.endereco = response.data.logradouro
          $scope.dadosAgendamento.dados_pessoais.localizacao.bairro = response.data.bairro
          $scope.dadosAgendamento.dados_pessoais.localizacao.complemento = response.data.complemento
          $scope.dadosAgendamento.dados_pessoais.localizacao.estado = response.data.uf
          $scope.dadosAgendamento.dados_pessoais.localizacao.cidade = response.data.localidade
        }
      });
    } else {
      removePreloader();
      $scope.dadosAgendamento.dados_pessoais.localizacao = {};
      $scope.load = false;
    }
  }

  $scope.infoInput = (typeinfo) => {
    preloader();
    if(typeinfo == 'cpf') {
      removePreloader();
      Swal.fire({type:'info', html: 'Esta informação servirá para validação de seus dados, além de tornar autentico seu registro em nossos dados.'});
    }
  }

  $scope.verBrinde = (brindeId) => {
    if(typeof document.getElementById(`brindeimg_${brindeId}`).id !== 'undefined') {
      if('brindeimg_'+brindeId == document.getElementById(`brindeimg_${brindeId}`).id) {
        // $scope.mostrarBrinde = true;
        if(document.getElementById(`brindeimg_${brindeId}`).style.display == ''){
          document.getElementById(`brindeimg_${brindeId}`).style.display = 'none';
        } else {
          document.getElementById(`brindeimg_${brindeId}`).style.display = '';
        }
      }
    } else {
      // $scope.mostrarBrinde = false;
      if(document.getElementById(`brindeimg_${brindeId}`).style.display == 'none'){
        document.getElementById(`brindeimg_${brindeId}`).style.display = '';
      } else {
        document.getElementById(`brindeimg_${brindeId}`).style.display = '';
      }
    }
  }

});