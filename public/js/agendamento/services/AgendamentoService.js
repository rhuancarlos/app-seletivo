angular.module('ibnfagendamento').service("agendamentoApi", function($http, config) {
  this.saveScheduling = function(dadosAgendamento) {
    return $http.post(`${config.BASE_URL}agendamento/saveScheduling`,{...dadosAgendamento});
  }
  
  this.getDataDefault = function() {
    return $http.get(`${config.BASE_URL}agendamento/getDataDefault`);
  }
  
  this.getVagancyCount = (dia_celebracao) => {
    return $http.post(`${config.BASE_URL}agendamento/getVagancyCount`, {dia_celebracao:dia_celebracao});
  }
  
  this.getAddressCep = (cepInput) => {
    return $http.get(`https://viacep.com.br/ws/${cepInput}/json/`);
  }
  
  this.getDataStages = (stage) => {
    return $http.post(`${config.BASE_URL}index/getDataStages`, {stage:stage});
  }
});