var app = angular.module("IbnfAgendamento",[]);

app.controller("AgendamentoController", function($scope, AgendamentoService){
  $scope.screenStage = 1;
  $scope.dados = [];
  // $scope.LoadPage();

  // $scope.LoadPage = function(){
  // };
  // intervaloDatas('periodo-competicao');
  $scope.nextScreenStage = (form) => {
    return $scope.screenStage = form+1;
  }
  $scope.backScreenStage = (form) => {
    return $scope.screenStage = form-1;
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