angular.module('peliculas')
.factory("PeliculasModelInfo", function($http) {
    return {
        getPeliculasById: function (id) {
            return $http.get("https://server.adolfodelcachoegea.es/index.php/pelicula/getPeliculaById/"+id).then(function (response) {
               return response.data;
            });
        }
    };
  })
  .factory("ComentarioModel", function($http) {
    return {
        getComents: function (id) {
            return $http.get("https://server.adolfodelcachoegea.es/index.php/critica/getCriticaByIdDePelicula/"+id).then(function (response) {
               return response.data;
            });
        }
    };
  })
  .controller("peliculaInfoCtrl", peliculaInfoCtrl);

    function peliculaInfoCtrl($scope,$routeParams,$localStorage,$location,$http,PeliculasModelInfo,ComentarioModel,pelisModel){
        //el id viene de la url, iros al peliculas.config.js para ver mas que me da perece ponerlo aqui.
        //el routeParams es donde se guardan los parametros de la url

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
                $scope.peliVista = false;
                $scope.peliPendiente = false;
                $scope.ocultarStars = false;

                if($localStorage.currentUser.username == "admin"){
                    $scope.ocultarGestion = false;
                }

                $http.post("https://server.adolfodelcachoegea.es/index.php/pelicula/CheckPeliVista", {
                    'id_pelicula':id,
                    'usuario':$localStorage.currentUser.username,
                }).then(function(response){
                    console.log(response.data);
                    if(response.data == "true"){
                        $scope.peliVista = true;
                    }
                });

                $http.post("https://server.adolfodelcachoegea.es/index.php/pelicula/CheckPeliPendiente", {
                    'id_pelicula':id,
                    'usuario':$localStorage.currentUser.username,
                }).then(function(response){
                    console.log(response.data);
                    if(response.data == "true"){
                        $scope.peliPendiente = true;
                    }
                });
            }
            
        }catch{
            console.log("No hay usuario");
            $scope.ocultarBiblio = true;
            $scope.ocultarSesion = false;
        }
        console.log($scope.peliVista);

        $scope.Comentar = function(){
          try{
            $http.post("https://server.adolfodelcachoegea.es/index.php/critica/insertComentPelicula", {
                'id_pelicula':id,
                'usuario':$localStorage.currentUser.username,
                'mensaje':$scope.formData.coment
            }).then(function(response){
                console.log("Data Inserted Successfully");
                ComentarioModel.getComents(id).then(function(data){
                    $scope.comentarios = data;
                    console.log($scope.comentarios);
                });
            },function(error){
                alert("algo ha pasado");
                console.error(error);
            });
        };
          }catch(){
          	alert("Necesitas ser usuario");
          }
            
        
        PeliculasModelInfo.getPeliculasById(id).then(function(data){
            console.log(data);
            $scope.pelicula = data;
            console.log($scope.pelicula);
        });

        ComentarioModel.getComents(id).then(function(data){
            $scope.comentarios = data;
            console.log($scope.comentarios);
        });

        $scope.PeliculaVista = function(){
            console.log($scope.peliVista);
            if($scope.ocultarBiblio == false){
                if($scope.peliVista == false){
                    $http.post("https://server.adolfodelcachoegea.es/index.php/pelicula/MarcarVisto", {
                        'id_pelicula':id,
                        'usuario':$localStorage.currentUser.username,
                    }).then(function(){
                        $scope.peliVista = true;
                    });
                    $http.post("https://server.adolfodelcachoegea.es/index.php/pelicula/DeletePeliPendiente", {
                        'id_pelicula':id,
                        'usuario':$localStorage.currentUser.username,
                    }).then(function(){
                        $scope.peliPendiente = false;
                    });
                    console.log("añado");
                }else{
                    $http.post("https://server.adolfodelcachoegea.es/index.php/pelicula/DeletePeliVista", {
                        'id_pelicula':id,
                        'usuario':$localStorage.currentUser.username,
                    }).then(function(){
                        $scope.peliVista = false;
                    });
                    console.log("borro");
                }          
            }else{
                alert("debes iniciar sesion");
            }
        }

        $scope.PeliculaPendiente = function(){
            console.log($scope.peliPendiente);
            if($scope.ocultarBiblio == false){
                if($scope.peliPendiente == false){
                    $http.post("https://server.adolfodelcachoegea.es/index.php/pelicula/MarcarPendiente", {
                        'id_pelicula':id,
                        'usuario':$localStorage.currentUser.username,
                    }).then(function(){
                        $scope.peliPendiente = true;
                    });
                    $http.post("https://server.adolfodelcachoegea.es/index.php/pelicula/DeletePeliVista", {
                        'id_pelicula':id,
                        'usuario':$localStorage.currentUser.username,
                    }).then(function(){
                        $scope.peliVista = false;
                    });
                    console.log("añado");
                }else{
                    $http.post("https://server.adolfodelcachoegea.es/index.php/pelicula/DeletePeliPendiente", {
                        'id_pelicula':id,
                        'usuario':$localStorage.currentUser.username,
                    }).then(function(){
                        $scope.peliPendiente = false;
                    });
                    console.log("borro");
                }          
            }else{
                alert("debes iniciar sesion");
            }
        }
        $scope.Calificar = function($value){
            console.log($value);
            $http.post("https://server.adolfodelcachoegea.es/index.php/pelicula/CalificarPelicula", {
                        'id_pelicula':id,
                        'usuario':$localStorage.currentUser.username,
                        'valor':$value,
                    }).then(function(){
                    });
        }

        
    }
    