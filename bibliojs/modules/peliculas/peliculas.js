angular.module('peliculas')
.factory("PeliculasModel", function($http) {
    //esto lo he hecho como apaño para que funcione, pero esto deberia hacerse en pelisModel.js
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
.controller("peliculasCtrl", peliculasCtrl);
    //este es el controlador donde manejamos todo lo que se va a ver y lo que va ha hacer la pagina /peliculas
    function peliculasCtrl($scope,$localStorage,PeliculasModel,GeneroModel,pelisModel){

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
        }

        PeliculasModel.getPeliculas().then(function(data){
            $scope.peliculas = data;
            console.log($scope.peliculas);
          });
          //$scope.pelisModel = pelisModel.getPeliculas();
          //console.log($scope.pelisModel);
        GeneroModel.getGeneros().then(function(data){
           $scope.generos = data;
           console.log($scope.generos);
        });
    }
