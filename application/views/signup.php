<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sherlock API DEMO PAGE</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=site_url('static/css/signup-login-form.css')?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="<?=site_url('static/js/sherlock.js')?>"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4" style="min-width: 300px">
                <h1 class="text-center login-title">Sherlock API Demo: Sign Up</h1>
                <div class="account-wall">
                    <img class="profile-img" src="<?=site_url('static/img/team/1.jpg')?>"
                        alt="">
                    <form class="form-signin">
                        <input type="email" class="form-control" id="sherlock_email" name="email" placeholder="Email" required autofocus>
                        <input type="password" class="form-control" id="sherlock_password" name="password" placeholder="Password" required>
                        <input type="password" class="form-control" id="sherlock_pin" name="pin" placeholder="PIN" required>
                        <button class="btn btn-lg btn-primary btn-block" type="button" id="wow" onclick="sherlock_signup()">Sign up</button>
                        <p id="result"></p>
                        <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                    </form>
                </div>
                <a href="<?=site_url('login')?>" class="text-center new-account" id="wow" onclick="javascript">Log in </a>

            </div>
        </div>
    </div>

</body>
</html>

<script type="text/javascript">
function sherlock_signup() {
	sherlock.SignUp('QWERTY');
};

</script>
