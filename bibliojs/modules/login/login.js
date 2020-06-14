angular.module('login')

.factory('AuthenticationService',['$http','$localStorage', function($http,$localStorage ) {
                          
    var service = {};
    service.Login = function(username, password, callback) {

        $http.post('https://server.adolfodelcachoegea.es/index.php/login/getUsuario', {
            'user': username,
            'password': password
        }).then(function (response) {
                if (response.data != 0) {
                    console.log("holaaaa");
                    console.log(response.data);
                    $localStorage.currentUser = { username: username, token: response.data };
                    $http.defaults.headers.common.Authorization = 'Bearer ' + response.data;
                    callback(true);
                } else {
                    callback(false);
                    alert("Datos incorrectos");
                }
            });
    };
    service.Logout = function() {
        delete $localStorage.currentUser;
        $http.defaults.headers.common.Authorization = '';
    };

    return service;
}])

.controller("loginCtrl", loginCtrl);
    function loginCtrl($scope,AuthenticationService, $location){
      
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
        $scope.login = login;
        initController();
        function initController() {
            AuthenticationService.Logout();
        };
    
        function login() {
            console.log("hola");
            $scope.loading = true;
            AuthenticationService.Login($scope.username, $scope.password, function (result) {
                if (result === true) {
                    $location.path('/');
                } else {
                    $scope.error = 'Username or password is incorrect';
                    $scope.loading = false;
                }
            });
        };
}
