var app = angular.module("ibnfsistema",[])

app.controller("ManutencaoController", function($scope, manutencaoAPI) {
  // $scope.app = "ManutencaoController";
  $scope.dadosManutencao = [];
  $scope.secoesMenus = [{}];
  $scope.menuVinculo = [{}];
  $scope.menus = null;
  $scope.salvarMenu = function (dados, menu_tipo){
    let inputInvalids = [];
    if(!dados.menu_tipo || (dados.menu_tipo == '')) {
      inputInvalids.push('- Tipo');
    } else {
      switch(dados.menu_tipo) {
        case '1':
          if(!dados.descricao || (dados.descricao == '')) {
            inputInvalids.push('- Descrição');
          }
          break;

        case '2': 
          if(!dados.secao_menu || (dados.secao_menu == '')) {
            inputInvalids.push('- Seção de menu');
          }
          if(!dados.descricao || (dados.descricao == '')) {
            inputInvalids.push('- Descrição');
          }
          break;

          case '3': 
          if(!dados.menu_vinculo || (dados.menu_vinculo == '')) {
            inputInvalids.push('- Menu de vínculo');
          }
          if(!dados.descricao || (dados.descricao == '')) {
            inputInvalids.push('- Descrição');
          }
          if(!dados.path_servidor || (dados.path_servidor == '')) {
            inputInvalids.push('- Path repositório');
          }
          break;
      }
    }
    if(!dados.status || (dados.status == '')) {
      inputInvalids.push('- Status');
    }

		if(inputInvalids.length > 0) {
		  Swal.fire({ title: 'Ops! Algo errado aqui ... ', type: 'warning',html: '<b>Você não preencheu:</b><br>' + inputInvalids.join('<br>')});
		} else {
      manutencaoAPI.salvarMenu(dados, menu_tipo).then((response) => {
        if(response.data.status) {
          $scope.dadosManutencao = [];
          Swal.fire({title: response.data.title, type: response.data.tipo, html: response.data.message, timer:response.data.close});
          $scope.dadosManutencao = [];
          $scope.getMenu();
        } else {
          Swal.fire({title: response.data.title, type: response.data.tipo, html: response.data.message});return;
        }
      }).catch((err) => Swal.fire({ title: 'Erro Crítico!', type: 'error', html: 'Houve falha durante o processo de registro.'}));
    }
  };
  $scope.getOpcoesMenus = function(menu_tipo){
    if(!menu_tipo) {
      Swal.fire({title: 'Ops! Algo errado aqui ... ',type: 'warning',html: '<b>Favor selecione um tipo de menu para continuar</b>'});return
    }
    if(menu_tipo == '2') {
      manutencaoAPI.getOpcoesMenus(menu_tipo).then((response) => {
        if(response.data.status) {
         return $scope.secoesMenus = response.data.dados;
        } else {
          Swal.fire({title:response.data.title, type:response.data.tipo, html:response.data.message, timer:response.data.close});
          return
        }
      }).catch((err) => Swal.fire({ title: 'Erro Crítico!', type: 'error', html: 'Houve falha durante o processo de registro.'}));
    }
    if(menu_tipo == '3') {
      manutencaoAPI.getOpcoesMenus(menu_tipo).then((response) => {
        if(response.data.status) {
         return $scope.menuVinculo = response.data.dados;
        } else {
          Swal.fire({title:response.data.title, type:response.data.tipo, html:response.data.message, timer:response.data.close});
          return
        }
      }).catch((err) => Swal.fire({ title: 'Erro Crítico!', type: 'error', html: 'Houve falha durante o processo de registro.'}));
    }
  };
// });
// 
// app.controller("ManutencaoListController", function($scope, manutencaoAPI) {

  $scope.getMenu = function(){
    $scope.menus = [];
    $scope.editSecao = {};
    $scope.dadosManutencao = [];
    preloader();
    manutencaoAPI.getMenu().then((response) => {
      $scope.menus = response.data;
      removePreloader();
    });
  };
  $scope.getMenu();

  $scope.editItem = function(tipo, secao) {
    $scope.editSecao = {};
    $scope.dadosManutencao = [];
    $scope.secao_menu = null;
    console.log(secao)
    if(tipo || (tipo != '')) {
      $scope.editSecao.itens_secao = secao;
      preloader();
      manutencaoAPI.getDados(tipo, $scope.editSecao).then(function(response) {
        if(response.data.status) {
          if(response.data.dados.id) {
            $scope.dadosManutencao.id = response.data.dados.id;
          }
          $scope.dadosManutencao.menu_tipo = tipo;
          $scope.dadosManutencao.descricao = response.data.dados.descricao;
          $scope.dadosManutencao.descricao_completa = response.data.dados.descricao_completa;
          $scope.dadosManutencao.sigla = response.data.dados.sigla;
          $scope.dadosManutencao.status = response.data.dados.status;
          if(tipo == 2 && response.data.dados.id) {
            $scope.secoesMenus = response.data.secoesMenus;
            $scope.dadosManutencao.secao_menu = response.data.dados.menu_id;
          }
          if(tipo == 3 && response.data.dados.id) {
            $scope.menuVinculo = response.data.itensMenus;
            $scope.dadosManutencao.menu_vinculo = response.data.dados.iditem_sub_menu;
            // $scope.dadosManutencao.menu_id = response.data.dados.menu_id;
            $scope.dadosManutencao.path_servidor = response.data.dados.repositorio_link;
            $scope.dadosManutencao.target = response.data.dados.target;
          }
        }
        removePreloader();
      }).catch(function(error){
        Swal.fire({title: 'Erro Crítico!',type: 'error',html: 'Houve falha durante o processo de registro.'})
        console.log(error)
        removePreloader();
      });
    }
  };

  $scope.deleteItem = function() {
   Swal.fire('ops', 'in desenvolvimento', 'warning'); 
  };
  
});
