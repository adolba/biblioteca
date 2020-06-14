angular.module('peliculas', ['ngRoute']);
angular.module('peliculas').config(config);
  //aqui es donde se asignan las url y que controladores y plantilla html usa cada uno, para añadir otra justo antes del ultimo ";" repites lo del .when . Hay uno de estos por carpeta
  //Por si acaso, el ":id" es un parametro que paso por la url, en el html podeis ver donde
    function config($routeProvider){

        $routeProvider.when('/peliculas', {
            templateUrl: 'modules/peliculas/peliculas.html',
            controller: 'peliculasCtrl'
          })
          .when('/pelicula/:id', {
            templateUrl: 'modules/peliculas/pelicula_info.html',
            controller: 'peliculaInfoCtrl'
          })
          .when('/peliculas/:genero', {
            templateUrl: 'modules/peliculas/pelicula_genero.html',
            controller: 'peliculasGeneroCtrl'
          });
    }

