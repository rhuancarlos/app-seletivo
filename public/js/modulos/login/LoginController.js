const app = angular.module("ibnfsistema", []);

app.controller("LoginController", function($scope){
  $scope.message = "rhuan";
  $scope.typeForm = 1;

  $scope.changeForm = (form) => {
    $scope.typeForm = form
  }
});