const app = angular.module("Siscamp", []);
app.controller("LoginController", function($scope){
  $scope.message = "rhuan";
  $scope.typeForm = 1;

  $scope.changeForm = (form) => {
    $scope.typeForm = form
  }
});