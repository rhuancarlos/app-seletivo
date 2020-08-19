var app = angular.module("Acampoder",[]);

app.controller("CompeticaoController", function($scope, competicaoService){
  $scope.screen = 1;
  $scope.dados = [];
  // $scope.LoadPage();

  // $scope.LoadPage = function(){
  // };
  // intervaloDatas('periodo-competicao');
  $scope.changeForm = (form) => {
    return $scope.screen = form
  }
  
  // $scope.intervaloDatas = (obj) =>{
  //   // $('input[name="periodo_competicao"]').daterangepicker({
  //   $(`#${obj}`).daterangepicker({
  //     opens: 'left'
  //   }, function(start, end, label) {
  //     console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  //   });
  //   console.log(obj)
  // };

  // intervaloDatas()
  $scope.inicarCompeticao = () => {
    intervaloDatas('periodo_competicao')
  };

  $scope.handleAction = () => {
    competicaoService.call().then((response) =>{
      if(response.data.status) {
        $scope.dados = response.data.content;
      }
      console.log(response);
    });
  };


});