var app = angular.module("ibnfagendamento",["ng.deviceDetector", "ngSanitize"]);

app.controller("AgendamentoController", function($scope, deviceDetector, agendamentoApi){
  $scope.screenStage = 1;
  $scope.screenLimiteStage = 4;
  $scope.dados = [];
  $scope.dadosAgendamento = {};
  $scope.btnNextStage = document.getElementById('btnNextStage');
  $scope.btnBackStage = document.getElementById('btnBackStage');
  $scope.data = deviceDetector;
  $scope.allData = JSON.stringify($scope.data, null, 2);
  $scope.dataDefault = {};
  $scope.contentVagas = "";

  $scope.getVagancyCount = () => {
    $scope.contentVagas = `aguarde ...`;
    agendamentoApi.getVagancyCount($scope.dataDefault.dia_celebracao).then((response) => {
      $scope.dataDefault.situacao_vagas = response.data.status;
      if(response.data.status) {
        $scope.contentVagas = `Vaga(s) disponível(is): ${response.data.qtd_agendamentos_disponiveis}`;
      } else {
        $scope.contentVagas = `Vagas Esgotadas !<br><small>(novas vagas aos Domingos as 21h)</small><br><br> 
        -        Não conseguiu reservar sua vaga? Não se preocupe, a Celebração das 18h é livre de agendamento.<br>Seja muito bem vindo, esperamos você e sua Família.`;
      }
    });
    //$scope.getDataDefault();
  }

  $scope.getDataDefault = (_) => {
    agendamentoApi.getDataDefault().then((response) => {
      if(response.data.status) {
        for (const key in response.data.dados.Agendamento) {
          if (response.data.dados.Agendamento.hasOwnProperty(key)) {
            const element = response.data.dados.Agendamento[key];
            if(element.parametro == 'habilitar_agendamento') {
              $scope.dataDefault.habilitar_agendamento = element.value;
            }
            if(element.parametro == 'dia_celebracao') {
              $scope.dataDefault.dia_celebracao = element.value;
            }
            if(element.parametro == 'validar_autenticidade_por') {
              $scope.dataDefault.validar_autenticidade_por = element.value;
            }
            if(element.parametro == 'total_vagas_ofertadas') {
              $scope.getVagancyCount();
            }
          }
        }
      }
    });
    //$scope.getVagancyCount();
  }
  $scope.getDataDefault();

  $scope.nextScreenStage = (form, dados) => {
    $scope.checkNextStage(form, dados);
    if(form != $scope.screenLimiteStage) {
      return $scope.screenStage = form+1;
    }
  }

  $scope.backScreenStage = (form) => {
    return $scope.screenStage = form-1;
  }
  //$scope.getVagancyCount();
  
  $scope.cancelScheduling = () => {
    $scope.dadosAgendamento.dados_pessoais = {}
    $scope.screenStage = 1;
  }


  $scope.checkNextStage = (stageCurrent, formulario) => {
    let inputsInvalids = []
    // if(dados.nome_completo && (dados.nome_completo == '' && dados.nome_completo.length < 4)) {
    //   inputsInvalids.push('- Por favor preenche o campo nome corretamente');
    // }
    // if(dados.descendencia && (dados.descendencia == '')) {
    //   inputsInvalids.push('- Por favor informe sua geração');
    // }
    // if(dados.telefone && (dados.telefone == '' && dados.telefone.length < 11)) {
    //   inputsInvalids.push('- Por favor informe número de celular válido.');
    // }
    // console.log(Object.keys($scope.dadosAgendamento.dados_pessoais));
    // dadosAgendamento.dados_pessoais
    // var logDadosPessoais =  Object.keys($scope.dadosAgendamento.dados_pessoais);
    // if(logDadosPessoais.length < 4) {
    //   return true;
    // }
    if(stageCurrent == 2) {
      if(!$scope.dadosAgendamento.dados_pessoais) {
        return true;
      } else {
        if(!$scope.isEmpty(formulario)) {
          return true;
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

  $scope.finishScheduling = (dadosAgendamento) => {
    if($scope.isEmpty(dadosAgendamento)) {
      Swal.fire({type: 'warning',title: 'Ops... Algo errado',html: 'Por favor verifique as opções do formulário'});
      return false;
    } else {
      
      dadosAgendamento.dia_celebracao = $scope.dataDefault.dia_celebracao;
      agendamentoApi.saveScheduling(dadosAgendamento).then((response) => {
        if(!response.data.status) {
          Swal.fire({type:'error', title: 'Ops... Algo errado', html: response.data.mensagem});
          return false;
        }
        if(response.data.status) {
          Swal.fire({type:'success', title: 'êba! Tudo certo aqui', html: response.data.mensagem});
          $scope.getVagancyCount();
          $scope.dadosAgendamento = {};
          $scope.screenStage = 1;
          return false;
        }
      });
    }
  }

  $scope.infoInput = (typeinfo) => {
    console.log(typeinfo);
    if(typeinfo == 'cpf') {
      Swal.fire({
        type:'info',
        html: 'Esta informação terá como finalidade a autenticação do seu agendamento na data da celebação.'
      });
    }
  }


});