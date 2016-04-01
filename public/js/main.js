var app = angular.module('siten', ['ngResource']);

app.constant('USER_ROLES', {
    all: '*',
    admin: 'ADMIN',
    general: 'GENERAL',
    guest: 'GUEST'
});


app.factory('User', function ($resource) {
    return $resource('api/user/:id', {id: '@id'}, {
        update: {
            method: 'PUT'
        }
    });
});

app.service('Session', function () {
    this.create = function (sessionId, userId, userRole) {
        this.userId = userId;
        this.userRole = userRole;
    };
    this.destroy = function () {
        this.userId = null;
        this.userRole = null;
    };
});

app.factory('AuthService', function ($http, Session) {
    var authService = {};

    authService.login = function (credentials) {
        return $http
            .post('login', credentials)
            .success(function (res) {
                Session.create(res.id,
                    res.role);
            });
    };

    authService.logout = function () {
        return $http
            .post('logout')
            .then(function () {
                Session.destroy();
            });
    };

    authService.isAuthenticated = function () {
        return !!Session.userId;
    };

    authService.isAuthorized = function (authorizedRoles) {
        if (!angular.isArray(authorizedRoles)) {
            authorizedRoles = [authorizedRoles];
        }
        return (authService.isAuthenticated() &&
        authorizedRoles.indexOf(Session.userRole) !== -1);
    };

    return authService;
});

app.controller('userCtrl', function ($scope, $http, User, AuthService, USER_ROLES) {
    $scope.credentials = {
        username: '',
        password: ''
    };
    $scope.currentUser = null;
    $scope.userRoles = USER_ROLES;
    $scope.isAuthorized = AuthService.isAuthorized;
    $scope.isAuthenticated = isAuthenticated;
    if ($scope.isAuthenticated) {
        $http.get('api/common').success(function (data) {
            $scope.commons = data;
        });
    }

    $scope.setCurrentUser = function (user) {
        $scope.currentUser = user;
    };
    $scope.login = function (credentials) {
        AuthService.login(credentials).success(function (user) {
            $scope.isAuthenticated = AuthService.isAuthenticated();
            $scope.setCurrentUser(user);
        }).error(function (res) {
            error(res);
        });
    };
    $scope.logout = function(){
        AuthService.logout().then(function(){
            $scope.isAuthenticated = AuthService.isAuthenticated();
        })
    };
    $scope.doSearch = function(data){
        reload();
        for(var i in data){
            if(!data.hasOwnProperty(i))continue;
            if(data[i] == null){
                delete data[i];
            }
        }
        $scope.search = data;
    };

    function reload() {
        $scope.users = User.query(function () {
            $scope.addEmptyUser();
        });
    }

    $scope.save = function (user, index) {
        $scope.currentUser = new User(user);
        if (angular.isDefined(user.id)) {
            $scope.currentUser.$update(function (res) {
                toastr.info('Lưu thành công!');
                $scope.users[index] = res;
            }, function (res) {
                error(res.data);
            });
        } else {
            $scope.currentUser.$save(function (res) {
                toastr.info('Đăng ký thành công!');
                $scope.users[index] = res;
            }, function (res) {
                error(res.data);
            });
        }
    };

    $scope.addEmptyUser = function () {
        var newUser = new User();
        newUser.username = leftPadding(String(1 + getMaxUid()), 4);
        $scope.users.push(newUser);
    };

    function error(data) {
        for (var key in data) {
            // skip loop if the property is from prototype
            if (!data.hasOwnProperty(key)) continue;
            var list = data[key];
            for (var item in list) {
                return toastr.error(list[item]);
            }
        }
    }

    function getMaxUid() {
        var max = 0;
        for (var i in $scope.users) {
            var uid = parseInt($scope.users[i].username) || 0;
            if (max < uid) {
                max = uid;
            }
        }
        return max;
    }
});


function leftPadding(input, n) {
    var input = (typeof input === 'string') ? input : '';
    if (input.length >= n)
        return input;
    var zeros = "0".repeat(n);
    return (zeros + input).slice(-1 * n)
}