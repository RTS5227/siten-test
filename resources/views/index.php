<!DOCTYPE html>
<html lang="en" ng-app="siten">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- include material design icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <!-- Style -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="css/main.css">
    <title>Siten Test</title>
</head>
<body>
<br>

<div class="container" ng-controller="userCtrl" ng-cloak>
    <div class="row">
        <div class="col-sm-12">
            <!--function button-->
            <div class="personnel">
                <button class="btn btn-primary" ng-click="addEmptyUser()">Đăng ký</button>
                <button class="btn btn-primary">Logout</button>
            </div>
            <br>
            <!-- search box -->
            <form action="" class="search_frm">
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label for="id">ID</label>
                        <input id="id" type="text" class="form-control">
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="office">Cơ quan</label>
                        <select ng-options="item.code as item.name for item in commons.offices track by item.code"
                                ng-model="search.office" class="form-control">
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="office">Phân loại sử dụng</label>
                        <select ng-options="item.code as item.name for item in commons.types track by item.code"
                                ng-model="search.type" class="form-control"></select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label for="office">Role</label>
                        <select ng-options="item.code as item.name for item in commons.roles track by item.code"
                                ng-model="search.role" class="form-control"></select>
                    </div>
                    <div class="form-group col-sm-5">
                        <label for="mail">Mail address</label>
                        <input id="mail" type="email" class="form-control" ng-model="search.email"/>
                    </div>
                    <div class="form-group col-sm-offset-2 col-sm-2">
                        <label for="">&nbsp;</label>
                        <button type="button" class="form-control btn btn-warning" ng-click="search()">Search</button>
                    </div>
                </div>
            </form>
            <!--user list-->
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Cơ quan</td>
                    <td>Email</td>
                    <td>Người tạo</td>
                    <td>Ngày giờ update cuối cùng</td>
                    <td>Phân loại sử dụng</td>
                    <td>Role</td>
                    <td>PW</td>
                    <td>Thao tác</td>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="i in users">
                    <td>
                        <input type="hidden" ng-model="i.id">
                        <input type="text" class="form-control" ng-model="i.uid" required>
                    </td>
                    <td>
                        <select ng-options="item.code as item.name for item in commons.offices"
                                ng-model="i.office" class="form-control"></select>
                    </td>
                    <td><input type="email" class="form-control" ng-model="i.email"/></td>
                    <td><input type="text" class="form-control" ng-model="i.created_by"/></td>
                    <td><input type="text" class="form-control" ng-model="i.last_update_at"></td>
                    <td>
                        <select ng-options="item.code as item.name for item in commons.types"
                                ng-model="i.type" class="form-control"></select>
                    </td>
                    <td>
                        <select ng-options="item.code as item.name for item in commons.roles"
                                ng-model="i.role" class="form-control"></select>
                    </td>
                    <td><input type="password" class="form-control" ng-model="i.password" ng-pattern="/^(?:[0-9]+[a-z]|[a-z]+[0-9])[a-z0-9]*$/i"></td>
                    <td><button class="btn btn-success" type="button" ng-click="save(i)">{{i.id ? 'Lưu' : 'Đăng ký'}}</button></td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- end col s12 -->
    </div>
    <!-- end row -->
</div>
<!-- end container -->

<!--  Scripts-->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-resource.js"></script>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>

