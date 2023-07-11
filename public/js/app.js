angular.module("pbrApp", [], function($interpolateProvider){
    // para no interferir con laravel
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});