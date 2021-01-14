var app = angular.module("paineladmin",["ngAnimate"]);

app.controller("PainelController", function($scope, painelApi){
  $scope.display = null;
  $scope.listaInscricoes = [];
  $scope.listaCursos = [];
  $scope.dadosRegistro = {};
  const URL_BASE = document.getElementById('base_url').value;

  $scope.getInscricoes = _ => {
    $scope.preloader();
    painelApi.getInscricoes().then((response) => {
      $scope.removePreloader();
      if(response.data.status) {
        $scope.display = 'inscricoes';
        $scope.listaInscricoes = response.data.inscricoes;
      }
    }).catch(e => {$scope.removePreloader();Swal.fire({title:'Falha ao requisitar dados'});})
  }

  $scope.editItem = (Item) => {
    if(!Item) {return false;}
    $scope.display = 'manutencao_registro';
    $scope.dadosRegistro.idinscricao = Item.idinscricao;
    $scope.dadosRegistro.token = Item.token;
    $scope.dadosRegistro.nome_completo = Item.nome_completo;
    $scope.dadosRegistro.email = Item.email;
    $scope.dadosRegistro.telefone = Item.telefone;
    $scope.dadosRegistro.colegio_atual = Item.colegio_atual;
    $scope.dadosRegistro.como_ficou_sabendo = Item.como_ficou_sabendo;
    $scope.dadosRegistro.serie = Item.serie;
    console.log($scope.dadosRegistro);
    painelApi.getlistaCursos().then((e) => {if(e.data.status) {$scope.listaCursos = e.data.cursos;}})
  }
  $scope.preloader = function(){
    $('body').append(
      `<div class="preloader">
        <img class="preloader_img" src="${URL_BASE}public/images/statics/loaders/s.png">
          <div>Carregando...</div><div class="preloader-button"></div>
      </div>`);
    setTimeout(function(){
      $('.preloader-button').html('<button onclick="removePreloader()" class="btn btn-dark btn-sm">Fechar</button>');
    },10);
  }
  
  $scope.removePreloader = function(){
    $('.preloader').remove();
  }

  $scope.removerItem = (Item) => {
    if(!Item) {return false;}
    Swal.fire({
      title:'Aviso',
      html: `Você tem certeza que deseja excluir esta inscrição do aluno ${Item.nome_completo}?`,
      showCancelButton: true,
      confirmButtonText: 'Sim',
      cancelButtonText: 'Cancelar',
    }).then((e) => {
      if(!e.value) {
        return;
      } else {
        $scope.preloader();
        painelApi.removerItem(Item.idinscricao).then((response) => {
          $scope.removePreloader();
          if(!response.data.status) {
            Swal.fire({title: 'Falha',type: 'danger',html: response.data.mensagem})
          } else {
            Swal.fire({title: 'Registro removido com sucesso!',type: 'success'})
            $scope.getInscricoes();
          }
        }).catch(e => {$scope.removePreloader();Swal.fire({title:'Falha ao realizar processo'});})
      }
    })
  }

  $scope.salvarAlteracoes = (dadosRegistro) => {
    let inputsvazios = [];
    if(!dadosRegistro.nome_completo || dadosRegistro.nome_completo == "") {
      inputsvazios.push("- Nome Completo");
    }
    if(!dadosRegistro.email || dadosRegistro.email == "") {
      inputsvazios.push("- E-mail");
    }
    if(!dadosRegistro.telefone || dadosRegistro.telefone == "") {
      inputsvazios.push("- Telefone");
    }
    if(!dadosRegistro.serie || dadosRegistro.serie == "") {
      inputsvazios.push("- Série");
    }
    if(!dadosRegistro.colegio_atual || dadosRegistro.colegio_atual == "") {
      inputsvazios.push("- Colegio Atual");
    }
    if(inputsvazios.length > 0) {
      Swal.fire({title: 'Ops! Algo errado aqui ... ', type: 'warning', html: '<b>Você não preencheu:</b><br>' + inputsvazios.join('<br>') });
    } else {
      $scope.preloader();
      painelApi.salvarAlteracoes(dadosRegistro).then((response) => {
        $scope.removePreloader();
        if(response.data.status) {
          Swal.fire({title: 'Registro atualizado com sucesso!',type: 'success'})
        }
      }).catch(e => {$scope.removePreloader();Swal.fire({title:'Falha ao efetivar processo'});})
    }
  }
});