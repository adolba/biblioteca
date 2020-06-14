angular.module('App',['ngRoute','ngStorage','angularUtils.directives.dirPagination','home','peliculas','series','login','biblioteca','admin']);

angular.module('App').config(['$locationProvider', '$routeProvider', function ($locationProvider, $routeProvider) {

    $locationProvider.hashPrefix('!');
    $routeProvider.otherwise({redirectTo: '/home'})

}]);