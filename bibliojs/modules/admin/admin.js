angular.module('admin')
.factory("SeriesModel", function($http) {
    return {
        getSeries: function () {
            return $http.get("https://server.adolfodelcachoegea.es/index.php/serie/getSeries").then(function (response) {
               return response.data;
            });
        }
    };
  })
  .factory("PeliculasModel", function($http) {
    return {
        getPeliculas: function () {
            return $http.get("https://server.adolfodelcachoegea.es/index.php/pelicula/getPeliculas").then(function (response) {
               return response.data;
            });
        }
    };
})
  .factory("GeneroModel", function($http) {
    return {
        getGeneros: function () {
            return $http.get("https://server.adolfodelcachoegea.es/index.php/genero/getGeneros").then(function (response) {
               return response.data;
            });
        }
    };
})
.controller("adminCtrl", adminCtrl);
    function adminCtrl($scope,$localStorage,$location,$http,SeriesModel,GeneroModel,PeliculasModel){

        $scope.ocultarBiblio = true;
        $scope.ocultarSesion = false;
        $scope.ocultarGestion = true;

        try{
            if($localStorage.currentUser.username){
                console.log("estoy dentro");
                $scope.ocultarBiblio = false;
                $scope.ocultarSesion = true;
                
                if($localStorage.currentUser.username == "admin"){
                    $scope.ocultarGestion = false;
                }
            }
            
        }catch{
            console.log("No hay usuario");
            $scope.ocultarBiblio = true;
            $scope.ocultarSesion = false;
            $location.path("/")
        }

        SeriesModel.getSeries().then(function(data){
            $scope.series = data;
            console.log($scope.series);
          });

          PeliculasModel.getPeliculas().then(function(data){
            $scope.peliculas = data;
            console.log($scope.peliculas);
          });

          GeneroModel.getGeneros().then(function(data){
            $scope.generos = data;
            console.log($scope.generos);
         });
         
         $scope.InsertGenero = function(){
             console.log($scope.nombreGenero)
            $http.post("https://server.adolfodelcachoegea.es/index.php/genero/InsertGenero", {
                   'genero':$scope.nombreGenero,
               }).then(function(response){
                   console.log("genero añadido");
                   GeneroModel.getGeneros().then(function(data){
                       $scope.generos = data;
                       console.log($scope.generos);
                    });
               });
        }

        $scope.InsertPeli = function(){
            console.log($scope.nombreGenero)
           $http.post("https://server.adolfodelcachoegea.es/index.php/pelicula/InsertPeli", {
                'nombre':$scope.nombrePeli,
                'resumen':$scope.resumenPeli,
                'fecha':$scope.fechaPeli,
                'duracion':$scope.duracionPeli,
                'genero':$scope.generoPeli,
                'portada':$scope.imgPeli,
              }).then(function(response){
                  console.log("pelicula añadida");
                  PeliculasModel.getPeliculas().then(function(data){
                    $scope.peliculas = data;
                    console.log($scope.peliculas);
                  });
              });
       }

       $scope.InsertSerie = function(){
        console.log($scope.nombreGenero)
       $http.post("https://server.adolfodelcachoegea.es/index.php/serie/InsertSerie", {
            'nombre':$scope.nombreSerie,
            'resumen':$scope.resumenSerie,
            'fecha':$scope.fechaSerie,
            'duracion':$scope.capituloSerie,
            'genero':$scope.generoSerie,
            'portada':$scope.imgSerie,
          }).then(function(response){
              console.log("serie añadida");
              SeriesModel.getSeries().then(function(data){
                $scope.series = data;
                console.log($scope.series);
              });
          });
   }

         $scope.EliminarGenero = function(){
             console.log(this.genero.id_genero);
             $http.post("https://server.adolfodelcachoegea.es/index.php/genero/EliminarGenero", {
                    'id':this.genero.id_genero,
                }).then(function(response){
                    console.log("genero eliminado");
                    GeneroModel.getGeneros().then(function(data){
                        $scope.generos = data;
                        console.log($scope.generos);
                     });
                });
         }

         $scope.EliminarPelicula = function(){
            console.log(this.pelicula.id);
            $http.post("https://server.adolfodelcachoegea.es/index.php/pelicula/Eliminarpelicula", {
                   'id':this.pelicula.id,
               }).then(function(response){
                   console.log("genero eliminado");
                   PeliculasModel.getPeliculas().then(function(data){
                    $scope.peliculas = data;
                    console.log($scope.peliculas);
                  });
               });
        }

        $scope.EliminarSerie = function(){
            console.log(this.serie.id);
            $http.post("https://server.adolfodelcachoegea.es/index.php/serie/EliminarSerie", {
                   'id':this.serie.id,
               }).then(function(response){
                   console.log("genero eliminado");
                   SeriesModel.getSeries().then(function(data){
                    $scope.series = data;
                    console.log($scope.series);
                  });
               });
        }
    }
