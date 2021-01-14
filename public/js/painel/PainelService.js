angular.module('paineladmin').service("painelApi", function($http, config2) {
  this.getInscricoes = function() {
    return $http.post(`${config2.BASE_URL}administrador.php/painel/getInscricoes`);
  } 
  this.removerItem = function(idItem) {
    return $http.post(`${config2.BASE_URL}administrador.php/painel/removerItem`,{idItem:idItem});
  } 
  this.salvarAlteracoes = function(dadosRegistro) {
    return $http.post(`${config2.BASE_URL}administrador.php/painel/salvarAlteracoes`,{...dadosRegistro});
  }
  this.getlistaCursos = function() {
    return $http.post(`${config2.BASE_URL}administrador.php/painel/getListaCursos`);
  }
});