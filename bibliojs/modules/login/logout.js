angular.module('login').controller("logoutCtrl", logoutCtrl);

    function logoutCtrl($scope,$localStorage,$http,$location){

        delete $localStorage.currentUser;
        $http.defaults.headers.common.Authorization = '';
        $location.path('/');
    }
