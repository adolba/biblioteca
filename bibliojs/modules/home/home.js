angular.module('home')
 .factory("PeliculasModelLimit", function($http) {
    //esto lo he hecho como apaño para que funcione, pero esto deberia hacerse en pelisModel.js
    return {
        getPeliculas: function () {
            return $http.get("http://server.adolfodelcachoegea.es/index.php/pelicula/getPeliculasPorFecha").then(function (response) {
               return response.data;
            });
        }
    };
})
.factory("SeriesModelLimit", function($http) {
    return {
        getSeries: function () {
            return $http.get("http://server.adolfodelcachoegea.es/index.php/serie/getSeriesPorFecha").then(function (response) {
               return response.data;
            });
        }
    };
  })
.controller("homeCtrl", homeCtrl);

    function homeCtrl($scope,$localStorage,PeliculasModelLimit,SeriesModelLimit){


        $scope.ocultarBiblio = true;
        $scope.ocultarSesion = false;
        $scope.ocultarGestion = true;

        try{
            if($localStorage.currentUser.username){
                $scope.ocultarBiblio = false;
                $scope.ocultarSesion = true;
                
                if($localStorage.currentUser.username == "admin"){
                    $scope.ocultarGestion = false;
                }
            }     
            
        }catch{
            console.log("No hay usuario");
        }
	
        PeliculasModelLimit.getPeliculas().then(function(data){
            $scope.peliculas = data;
            console.log($scope.peliculas);
          });

        SeriesModelLimit.getSeries().then(function(data){
            $scope.series = data;
            console.log($scope.series);
          });
    }

   
   
   
