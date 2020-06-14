angular.module('series')
.factory("SeriesGeneroModel", function($http) {
    return {
        getSeries: function (genero) {
            return $http.get("https://server.adolfodelcachoegea.es/index.php/serie/getSeriesByGenero/"+genero).then(function (response) {
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
.controller("serieGeneroCtrl", serieGeneroCtrl);
    function serieGeneroCtrl($scope,$routeParams,$localStorage,SeriesGeneroModel,GeneroModel,pelisModel){
		var genero = $routeParams.genero;
      
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

        SeriesGeneroModel.getSeries(genero).then(function(data){
            $scope.series = data;
            console.log($scope.series);
          });

          GeneroModel.getGeneros().then(function(data){
            $scope.generos = data;
            console.log($scope.generos);
         });
    }