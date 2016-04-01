var app = angular.module('siten', ['ngResource']);

app.constant('AUTH_EVENTS', {
    loginSuccess: 'auth-login-success',
    loginFailed: 'auth-login-failed',
    logoutSuccess: 'auth-logout-success',
    sessionTimeout: 'auth-session-timeout',
    notAuthenticated: 'auth-not-authenticated',
    notAuthorized: 'auth-not-authorized'
}).constant('USER_ROLES', {
    all: '*',
    admin: 'ADMIN',
    editor: 'GENERAL'
});

app.service('Session', function () {
    this.create = function (sessionId, userId, userRole) {
        this.id = sessionId;
        this.userId = userId;
        this.userRole = userRole;
    };
    this.destroy = function () {
        this.id = null;
        this.userId = null;
        this.userRole = null;
    };
});

app.factory('User', function ($resource) {
    return $resource('home/user/:id', {id: '@id'}, {
        update: {
            method: 'PUT'
        }
    });
});

app.factory('AuthService', function ($http, Session) {
    var authService = {};

    authService.login = function (credentials) {
        return $http
            .post('/home/login', credentials)
            .then(function (res) {
                Session.create(res.data.id, res.data.user.id,
                    res.data.user.role);
                return res.data.user;
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

app.controller('userCtrl', function ($scope, $rootScope, $http, User, AuthService, AUTH_EVENTS, USER_ROLES) {
    $scope.credentials = {
        username: '',
        password: ''
    };
    $scope.currentUser = null;
    $scope.userRoles = USER_ROLES;
    $scope.isAuthorized = AuthService.isAuthorized;
    $scope.isAuthenticated = AuthService.isAuthenticated();

    $scope.setCurrentUser = function (user) {
        $scope.currentUser = user;
    };
    $scope.login = function (credentials) {
        AuthService.login(credentials).then(function (user) {
            $rootScope.$broadcast(AUTH_EVENTS.loginSuccess);
            $scope.setCurrentUser(user);
            init();
        }, function () {
            $rootScope.$broadcast(AUTH_EVENTS.loginFailed);
        });
    };

    function init(){
        $http.get('home/common').success(function (data) {
            $scope.commons = data;
        });
        $scope.users = User.query(function () {
            $scope.addEmptyUser();
        });
    }

    $scope.save = function (user) {
        $scope.currentUser = new User(user);
        if (angular.isDefined(user.id)) {
            $scope.currentUser.$update(function(res){
                toastr.info('Lưu thành công!');
            }, function(res){
                error(res.data);
            });
        } else {
            $scope.currentUser.$save(function(res){
                toastr.info('Đăng ký thành công!');
            }, function(res){
                error(res.data);
            });
        }
    };

    $scope.addEmptyUser = function () {
        var newUser = new User();
        newUser.username = leftPadding(String(1 + getMaxUid()), 4);
        $scope.users.push(newUser);
    };

    function error(data){
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