angular.module('series')
.factory("SeriesModelInfo", function($http) {
    return {
        getSerieById: function(id) {
            return $http.get("https://server.adolfodelcachoegea.es/index.php/serie/getSerieById/"+id).then(function (response) {
               return response.data;
            });
        }
    };
  })
  .factory("ComentarioModelSerie", function($http) {
    return {
        getComents: function (id) {
            return $http.get("https://server.adolfodelcachoegea.es/index.php/critica/getCriticaByIdDeSerie/"+id).then(function (response) {
               return response.data;
            });
        }
    };
  })
  .controller("serieInfoCtrl", serieInfoCtrl);

    function serieInfoCtrl($scope,$localStorage,$http,$routeParams,SeriesModelInfo,ComentarioModelSerie){

        var id = $routeParams.id;
        $scope.formData = {};
        console.log($scope.formData.coment);
        console.log($scope.CurrentDate);
        $scope.ocultarBiblio = true;
        $scope.ocultarSesion = false;
        $scope.ocultarGestion = true;
        $scope.ocultarStars = true;

        try{
            if($localStorage.currentUser.username){
                console.log("estoy dentro");
                $scope.ocultarBiblio = false;
                $scope.ocultarSesion = true;
                $scope.serVista = false;
                $scope.serPendiente = false;
                $scope.ocultarStars = false;

                if($localStorage.currentUser.username == "admin"){
                    $scope.ocultarGestion = false;
                }

                $http.post("https://server.adolfodelcachoegea.es/index.php/serie/CheckSerieVista", {
                    'id_serie':id,
                    'usuario':$localStorage.currentUser.username,
                }).then(function(response){
                    console.log(response.data);
                    if(response.data == "true"){
                        $scope.serVista = true;
                    }
                });

                $http.post("https://server.adolfodelcachoegea.es/index.php/serie/CheckSeriePendiente", {
                    'id_serie':id,
                    'usuario':$localStorage.currentUser.username,
                }).then(function(response){
                    console.log(response.data);
                    if(response.data == "true"){
                        $scope.serPendiente = true;
                    }
                });
            }
            
        }catch{
            console.log("No hay usuario");
            $scope.ocultarBiblio = true;
            $scope.ocultarSesion = false;
        }

        $scope.Comentar = function(){
            $http.post("https://server.adolfodelcachoegea.es/index.php/critica/insertComentSerie", {
                'id_serie':id,
                'usuario':$localStorage.currentUser.username,
                'mensaje':$scope.formData.coment
            }).then(function(response){
                console.log("Data Inserted Successfully");
                ComentarioModelSerie.getComents(id).then(function(data){
                    $scope.comentarios = data;
                    console.log($scope.comentarios);
                });
            },function(error){
                alert("algo ha pasado");
                console.error(error);
            });
        };

        SeriesModelInfo.getSerieById(id).then(function(data){
            console.log(data);
            $scope.serie = data;
            console.log($scope.serie);
        });

        ComentarioModelSerie.getComents(id).then(function(data){
            $scope.comentarios = data;
            console.log($scope.comentarios);
        });

        $scope.SerieVista = function(){
            console.log($scope.serVista);
            if($scope.ocultarBiblio == false){
                if($scope.serVista == false){
                    $http.post("https://server.adolfodelcachoegea.es/index.php/serie/MarcarVisto", {
                        'id_serie':id,
                        'usuario':$localStorage.currentUser.username,
                    }).then(function(){
                        $scope.serVista = true;
                    });
                    $http.post("https://server.adolfodelcachoegea.es/index.php/serie/DeleteSeriePendiente", {
                        'id_serie':id,
                        'usuario':$localStorage.currentUser.username,
                    }).then(function(){
                        $scope.serPendiente = false;
                    });
                    console.log("añado");
                }else{
                    $http.post("https://server.adolfodelcachoegea.es/index.php/serie/DeleteSerieVista", {
                        'id_serie':id,
                        'usuario':$localStorage.currentUser.username,
                    }).then(function(){
                        $scope.serVista = false;
                    });
                    console.log("borro");
                }          
            }else{
                alert("debes iniciar sesion");
            }
        }

        $scope.SeriePendiente = function(){
            console.log($scope.serPendiente);
            if($scope.ocultarBiblio == false){
                if($scope.serPendiente == false){
                    $http.post("https://server.adolfodelcachoegea.es/index.php/serie/MarcarPendiente", {
                        'id_serie':id,
                        'usuario':$localStorage.currentUser.username,
                    }).then(function(){
                        $scope.serPendiente = true;
                    });
                    $http.post("https://server.adolfodelcachoegea.es/index.php/serie/DeleteSerieVista", {
                        'id_serie':id,
                        'usuario':$localStorage.currentUser.username,
                    }).then(function(){
                        $scope.serVista = false;
                    });
                    console.log("añado");
                }else{
                    $http.post("https://server.adolfodelcachoegea.es/index.php/serie/DeleteSeriePendiente", {
                        'id_serie':id,
                        'usuario':$localStorage.currentUser.username,
                    }).then(function(){
                        $scope.serPendiente = false;
                    });
                    console.log("borro");
                }          
            }else{
                alert("debes iniciar sesion");
            }
        }

        $scope.Calificar = function($value){
            console.log($value);
            $http.post("https://server.adolfodelcachoegea.es/index.php/serie/CalificarSerie", {
                        'id_serie':id,
                        'usuario':$localStorage.currentUser.username,
                        'valor':$value,
                    }).then(function(){
                        SeriesModelInfo.getSerieById(id).then(function(data){
                            console.log(data);
                            $scope.serie = data;
                            console.log($scope.serie);
                        });
                    });
        }
    }