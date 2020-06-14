angular.module('peliculas').factory('pelisModel', function($http){
//aqui se supone que deben estar los metodos guardados en el json pelismodel justo abajo estos metodos cogen la info de la base de datos a traves de CodeIgniter
//Este js en concreto es para todo lo que hay que coger sobre las pelis, por lo que aqui iran todo lo relacionado
    var pelisModel = {
        'getPeliculas' : getPeliculas,
        'getPeliculasById' : getPeliculasById,
    };

    function getPeliculas(){
        return $http.get("http://localhost:80/biblioteca/index.php/pelicula/getPeliculas").then(function (response) {
            return response.data;
        });       
    }

    function getPeliculasById(){
        return $http.get("http://localhost:80/biblioteca/index.php/pelicula/getPeliculasById").then(function (response) {
            return response.data;
        });       
    }

    return pelisModel;
});