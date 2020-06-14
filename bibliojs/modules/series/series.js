angular.module('series')
.factory("SeriesModel", function($http) {
    return {
        getSeries: function () {
            return $http.get("https://server.adolfodelcachoegea.es/index.php/serie/getSeries").then(function (response) {
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
.controller("seriesCtrl", seriesCtrl);
    function seriesCtrl($scope,$localStorage,SeriesModel,GeneroModel,pelisModel){

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

        SeriesModel.getSeries().then(function(data){
            $scope.series = data;
            console.log($scope.series);
          });

          GeneroModel.getGeneros().then(function(data){
            $scope.generos = data;
            console.log($scope.generos);
         });
    }
