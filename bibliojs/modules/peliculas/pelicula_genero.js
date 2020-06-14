angular.module('peliculas')
.factory("PeliculasGeneroModel", function($http) {
    return {
        getPeliculas: function (genero) {
            return $http.get("https://server.adolfodelcachoegea.es/index.php/pelicula/getPeliculaByGenero/"+genero).then(function (response) {
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
.controller("peliculasGeneroCtrl", peliculasGeneroCtrl);
    function peliculasGeneroCtrl($scope,$routeParams,$localStorage,PeliculasGeneroModel,GeneroModel,pelisModel){

        var genero = $routeParams.genero;
		console.log("el genero:"+genero);
      
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

        PeliculasGeneroModel.getPeliculas(genero).then(function(data){
            $scope.peliculas = data;
            console.log($scope.peliculas);
          });
        GeneroModel.getGeneros().then(function(data){
           $scope.generos = data;
           console.log($scope.generos);
        });
    }