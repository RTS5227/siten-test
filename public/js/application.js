var app = angular.module('siten', ['ngResource']);

app.controller('userCtrl', function ($scope, $http, User, AuthService, USER_ROLES) {
    var last_insert_id = 0;
    $scope.credentials = {
        username: '',
        password: ''
    };
    $scope.currentUser = null;
    $scope.userRoles = USER_ROLES;
    /**
     * check auth
     */
    AuthService.check().then(function(res){
        $scope.reload(res.data);
    });

    /**
     * reload auth
     * @param user
     */
    $scope.reload = function(user){
        $scope.isAuthorized = AuthService.isAuthorized;
        $scope.isAuthenticated = AuthService.isAuthenticated;
        $scope.setCurrentUser(user);
        if ($scope.isAuthenticated()) {
            $http.get('api/common').success(function (data) {
                $scope.commons = data;
            });
        }
    };

    /**
     * set current user
     * @param user
     */
    $scope.setCurrentUser = function (user) {
        $scope.currentUser = user;
    };

    /**
     * login and reload auth
     * @param credentials
     */
    $scope.login = function (credentials) {
        AuthService.login(credentials).success(function (user) {
            $scope.reload(user);
        }).error(function (res) {
            error(res);
        });
    };

    /**
     * logout and reload view
     */
    $scope.logout = function () {
        AuthService.logout().then(function () {
            $scope.isAuthenticated = AuthService.isAuthenticated;
        });
    };

    /**
     * search user
     * @param data
     */
    $scope.doSearch = function (data) {
        data = data || {};
        User.query(data, function (res) {
            $scope.users = res.result.data;
            last_insert_id = Number(res.last_id) || last_insert_id;
            $scope.addEmptyUser();
        });
    };

    /**
     * create/update user
     *
     * @param user
     * @param index
     */
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
                $scope.addEmptyUser();
            }, function (res) {
                error(res.data);
            });
        }
    };

    /**
     * insert empty user to last row
     */
    $scope.addEmptyUser = function () {
        if (!AuthService.isAuthorized(USER_ROLES.admin))return;
        last_insert_id++;
        var newUser = new User();
        newUser.username = leftPadding(String(last_insert_id), 4);
        $scope.users.push(newUser);
    };

    /**
     * display error alert
     * @param data
     * @returns {*}
     */
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
});



app.constant('USER_ROLES', {
    all: '*',
    admin: 'ADMIN',
    general: 'USER',
    guest: 'GUEST'
});


app.factory('User', function ($resource) {
    return $resource('api/user/:id', {id: '@id'}, {
        update: {
            method: 'PUT'
        },
        query: {method: 'GET', isArray: false}
    });
});

app.service('Session', function () {
    this.create = function (userId, userRole) {
        this.userId = userId;
        this.userRole = userRole;
    };
    this.destroy = function () {
        this.userId = null;
        this.userRole = null;
    };
});

/**
 * AuthService:check auth, login and logout session
 */
app.factory('AuthService', function ($http, Session) {
    var authService = {};

    authService.check = function () {
        return $http.post('auth').success(function (res) {
            Session.create(res.id, res.role);
        })
    };

    authService.login = function (credentials) {
        return $http
            .post('login', credentials)
            .success(function (res) {
                Session.create(res.id, res.role);
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

/**
 * insert n of 0 to left
 * @param input
 * @param n
 * @returns {string}
 */
function leftPadding(input, n) {
    var input = (typeof input === 'string') ? input : '';
    if (input.length >= n)
        return input;
    var zeros = "0".repeat(n);
    return (zeros + input).slice(-1 * n)
}