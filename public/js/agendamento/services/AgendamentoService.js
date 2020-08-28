angular.module('ibnfagendamento').service("agendamentoApi", function($http, config) {
  this.saveScheduling = function(dadosAgendamento) {
    return $http.post(`${config.BASE_URL}agendamento/saveScheduling`,{...dadosAgendamento});
  }

  this.getDataDefault = function() {
    return $http.get(`${config.BASE_URL}agendamento/getDataDefault`);
  }
});