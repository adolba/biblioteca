angular.module('biblioteca')
.factory("PeliculasUserModel", function($http,$localStorage) {
    return {
        getPeliculas: function () {
            return $http.get("https://server.adolfodelcachoegea.es/index.php/pelicula/getPeliculaByuser/"+$localStorage.currentUser.username).then(function (response) {
               return response.data;
            });
        },
        getPeliculasPendientes: function () {
            return $http.get("https://server.adolfodelcachoegea.es/index.php/pelicula/getPeliculaPendienteByuser/"+$localStorage.currentUser.username).then(function (response) {
               return response.data;
            });
        }
    };
})
.factory("SeriesUserModel", function($http,$localStorage) {
    return {
        getSeries: function () {
            return $http.get("https://server.adolfodelcachoegea.es/index.php/serie/getSerieByuser/"+$localStorage.currentUser.username).then(function (response) {
               return response.data;
            });
        },
        getSeriesPendientes: function () {
            return $http.get("https://server.adolfodelcachoegea.es/index.php/serie/getSeriePendienteByUser/"+$localStorage.currentUser.username).then(function (response) {
               return response.data;
            });
        }
    };
})
.controller("bibliotecaCtrl", bibliotecaCtrl);
    function bibliotecaCtrl($scope,$localStorage,$location,PeliculasUserModel,SeriesUserModel){

        $scope.ocultarBiblio = true;
        $scope.ocultarSesion = false;
        $scope.ocultarGestion = true;
        $scope.peliculas = [];
        $scope.series = [];

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
            $scope.ocultarBiblio = true;
            $scope.ocultarSesion = false;
            $location.path("/")
        }

        PeliculasUserModel.getPeliculas().then(function(data){
            $scope.peliculas = data;
        });


        SeriesUserModel.getSeries().then(function(data){
            $scope.series = data;
        });

        PeliculasUserModel.getPeliculasPendientes().then(function(data){
            $scope.peliculasPendientes = data;
        });


        SeriesUserModel.getSeriesPendientes().then(function(data){
            $scope.seriesPendientes = data;
        });
    }