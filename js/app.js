'use strict';

var app = angular.module('anSlim', ['ngRoute']);

app.config(['$routeProvider', function($routeProvider) {
    $routeProvider
        .when(
            '/', {
                templateUrl: 'partials/list.html',
                controller: 'listController'
            })
        .when(
            '/stuEdition/:id', {
                templateUrl: 'partials/edit.html',
                controller: 'editController'
            })
        .when(
            '/stuAddition', {
                templateUrl: 'partials/add.html',
                controller: 'addController'
            })
        .otherwise({
            redirectTo: '/'
        });
    // $locationProvider.html5Mode(true);
}]);

function listController($scope, $http) {
    $http.get('api/index.php/stu').then(function(data) {
        $scope.students = data;
    });
}