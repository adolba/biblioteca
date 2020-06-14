angular.module('admin', ['ngRoute']);
angular.module('admin').config(config);
    function config($routeProvider){

        $routeProvider.when('/admin', {
            templateUrl: 'modules/admin/admin.html',
            controller: 'adminCtrl'
          });
    }