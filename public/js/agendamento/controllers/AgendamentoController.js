var app = angular.module("ibnfagendamento",["ng.deviceDetector", "ngSanitize","ngAnimate", "funcoesAngular"]);

app.controller("AgendamentoController", function($scope, deviceDetector, agendamentoApi){
  $scope.screenStage = 1;
  $scope.screenLimiteStage = 3;
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

  $scope.nextScreenStage = (form, dados) => {
    $scope.checkNextStage(form, dados);
    if(form != $scope.screenLimiteStage) {
      $scope.screenStage = form+1;
      return $scope.screenStage;
    }
  }

  $scope.myData = _ => {
    return $scope.screenStage = 'myData';
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
          return false;
        }
      }
      return false;
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
      if(!$scope.dadosAgendamento.dados_pessoais.email || $scope.dadosAgendamento.dados_pessoais.email == "") {
        inputsvazios.push("- E-mail");
      }
      if(!$scope.dadosAgendamento.dados_pessoais.telefone || $scope.dadosAgendamento.dados_pessoais.telefone == "") {
        inputsvazios.push("- Telefone");
      }
      if(!$scope.dadosAgendamento.dados_pessoais.serie || $scope.dadosAgendamento.dados_pessoais.serie == "") {
        inputsvazios.push("- Série");
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
                Swal.fire({type:response.data.tipo, title: 'Dados da inscrição', html: `<br><br>Inscrição: ${response.data.dados_inscricao.codigoInscricao}</br>Data de Inscrição: ${response.data.dados_inscricao.data_inscricao}`});
              }
              $scope.EmptyData();
            });
            $scope.EmptyData();
          }
        }).catch(e => {removePreloader();});
      }
    }
  }
  
  $scope.EmptyData = _ => {
    $scope.dadosAgendamento = {};
    $scope.screenStage = 1;
    $scope.ofertaSelecionada = null;    
  }

  $scope.infoInput = (typeinfo) => {
    preloader();
    if(typeinfo == 'cpf') {
      removePreloader();
      Swal.fire({type:'info', html: 'Esta informação servirá para validação de seus dados, além de tornar autentico seu registro em nossos dados.'});
    }
  }

});