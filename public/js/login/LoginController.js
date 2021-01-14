var app = angular.module("paineladmin",["ng.deviceDetector", "ngSanitize","ngAnimate", "funcoesAngular"]);

app.controller("LoginController", function($scope, deviceDetector, loginApi){
  $scope.dadosLogin = {};
});