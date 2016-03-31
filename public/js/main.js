var app = angular.module('siten', ['ngResource']);

app.factory('User', function($resource){
    return $resource('home/user/:id', {id: '@id'},{
        update: {
            method: 'PUT'
        }
    });
});
app.controller('userCtrl', function ($scope, $http, User) {
    $http.get('home/common').success(function(data){
        $scope.commons = data;
    });

    $scope.users = User.query(function(){
        $scope.users.push(new User());
    });
});