angular.module('series', ['ngRoute']);
angular.module('series').config(config);

    function config($routeProvider){

        $routeProvider.when('/series', {
            templateUrl: 'modules/series/series.html',
            controller: 'seriesCtrl'
          })
          .when('/serie/:id', {
            templateUrl: 'modules/series/serie_info.html',
            controller: 'serieInfoCtrl'
          })
      	  .when('/series/:genero', {
            templateUrl: 'modules/series/serie_genero.html',
            controller: 'serieGeneroCtrl'
          });
    }

