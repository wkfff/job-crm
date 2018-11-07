<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/login.css">

<div ng-app="loginApp" class="container">
    <div class="login-page">

        <div class="form" name="myForm" ng-controller="loginController">
            <form>

                <div style="text-align: center; margin-bottom: 10px">
                    <center><img class="img-responsive" src="<?= base_url() ?>assets/img/logo.png"></center>
                    <font style="font-family: verdana;font-weight: 900;font-size: 2em;color: #F07D00">ASDP</font>
                    <font style="font-family: 'Trebuchet MS';font-weight: bolder;font-size: 2em; color: #005DAA">Indonesia Ferry</font>
                    <br>
                    <font style=" font-size : 15px; font-weight: 400">Customer Relationship Management</font>
                </div>

                <div class="form-group has-feedback">
                    <input name="username" ng-keydown="input()" class="form-control has-feedback-left" id="username" ng-model="username" type="email" placeholder="username" required />
                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                </div>
                <div class="form-group has-feedback">
                    <input name="password" ng-keydown="input()" class="form-control has-feedback-left" id="password" ng-model="password" type="password" placeholder="password" required/>
                    <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                </div>
                <button type="submit" ng-click="userCheck()">login</button>
                <p></p>
                <b><p style="color: red">{{tes}}</p></b>
            </form>
        </div>
    </div>
</div>

<script>
    var app = angular.module('loginApp', []);
    app.controller('loginController', function($window, $scope, $http) {

        $scope.input = function() {
            $scope.tes = '';
        }

        $scope.userCheck = function() {
            if (!$scope.username || !$scope.password) {
                $scope.tes = 'Silahkan masukkan username dan password anda!';
            } else {

                $http.get('<?=base_url()?>login/auth/' + $scope.username + '/' + $scope.password).then(function(response) {
                    $scope.hasil = response.data;
                    if (!$scope.hasil.verified) {
                        $scope.tes = 'Pastikan username dan password benar!';
                    } else {
                        window.location.href = '<?= base_url()?>login/auth_exec/' + $scope.username + '/' + $scope.password;
                    }
                })
            }
        };
    });

</script>
