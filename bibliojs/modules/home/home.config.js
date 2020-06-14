angular.module('home', ['ngRoute']);
angular.module('home').config(config);
    function config($routeProvider){

        $routeProvider.when('/home', {
            templateUrl: 'modules/home/home.html',
            controller: 'homeCtrl'
          });
    }
