angular.module('paineladmin').service("loginApi", function($http, config) {
  this.saveScheduling = function(dadosAgendamento) {
    return $http.post(`${config.BASE_URL}agendamento/saveScheduling`,{...dadosAgendamento});
  }
});