angular.module('IbnfAgendamento').service('AgendamentoService', function($http) {
    this.call = function () {
      return $http.get(`${document.getElementById('base_url').value}competicao/iniciarCompeticao`);
    }
});