angular.module('login').controller("regCtrl", regCtrl);

    function regCtrl($scope,$http,AuthenticationService, $location){
		
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
      	$scope.volver = function(){
          $location.path('/login');
        }
        $scope.insertData = function(){

            $http.post("https://server.adolfodelcachoegea.es/index.php/login/Register", {
                'user':$scope.username,
                'correo':$scope.email,
                'password':$scope.password
            }).then(function(response){
                    console.log("Data Inserted Successfully");
                    $location.path('/home');
                },function(error){
                    alert("El usuario ya existe");
                    console.error(error);
                });
            };
    }