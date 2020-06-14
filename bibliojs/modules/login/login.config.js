angular.module('login', ['ngRoute']);
angular.module('login').config(config);
    function config($routeProvider){

        $routeProvider.when('/login', {
            templateUrl: 'modules/login/login.html',
            controller: 'loginCtrl'
          })
          .when('/register', {
            templateUrl: 'modules/login/register.html',
            controller: 'regCtrl'
          })
          .when('/logout', {
            templateUrl: 'modules/login/logout.html',
            controller: 'logoutCtrl'
          });
    }
