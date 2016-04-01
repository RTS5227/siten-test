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
            <div ng-if="isAuthenticated" ng-include="'user.html'"></div>
            <div ng-if="!isAuthenticated" ng-include="'login.html'"></div>
        </div>
        <!-- end col s12 -->
    </div>
    <!-- end row -->
</div>
<!-- end container -->
<script type="text/javascript">
    var isAuthenticated = {{Auth::check()}};
</script>
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

