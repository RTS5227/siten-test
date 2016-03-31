var app = angular.module('siten', ['ngResource']);

app.factory('User', function ($resource) {
    return $resource('home/user/:id', {id: '@id'}, {
        update: {
            method: 'PUT'
        }
    });
});
app.controller('userCtrl', function ($scope, $http, User) {
    $http.get('home/common').success(function (data) {
        $scope.commons = data;
    });

    $scope.users = User.query(function () {
        $scope.users.push(new User());
    });

    $scope.save = function (user) {
        if(!angular.isDefined(user.uid)) return;
        $scope.currentUser = new User(user);
        if (angular.isDefined(user.id)) {
            $scope.currentUser.$update();
        } else {
            $scope.currentUser.$save();
        }
    }
});