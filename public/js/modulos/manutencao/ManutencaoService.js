angular.module("ibnfsistema").service("manutencaoAPI", function($http, config) {
  
  this.getOpcoesMenus = function(menu_tipo){
    return $http.post(`${config.BASE_URL}manutencao_menu/getOpcoesMenus`,{menu_tipo:menu_tipo});
  };

  this.salvarMenu = function(dados, tipo) {
    return $http.post(`${config.BASE_URL}manutencao_menu/salvarMenu`,{...dados, tipoSelect:tipo});
  };

  this.getMenu = (_) => {
    return $http.post(`${config.BASE_URL}manutencao_menu/getMenu`);
  };

  this._editSecao = (editSecao) => {
    return $http.post(`${config.BASE_URL}manutencao_menu/_editSecao`, {secao:editSecao});
  }

  this.getDados = (tipo, dados) => {
    return $http.post(`${config.BASE_URL}manutencao_menu/getDados`, {tipo:tipo, dados:dados});
  }


});