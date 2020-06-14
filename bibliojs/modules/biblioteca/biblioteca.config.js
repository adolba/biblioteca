angular.module('biblioteca', ['ngRoute']);
angular.module('biblioteca').config(config);
    function config($routeProvider){

        $routeProvider.when('/biblioteca', {
            templateUrl: 'modules/biblioteca/biblioteca.html',
            controller: 'bibliotecaCtrl'
          });
    }
