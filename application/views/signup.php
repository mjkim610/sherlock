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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="<?=site_url('static/js/sherlock.js')?>"></script>
</head>
<body>
	<div class="container" style="margin-top:100px">
		<div class="col-sm-8 col-sm-offset-2">
			<a href="<?=site_url('login')?>" class="btn btn-default pull-right" id="wow" onclick="javascript">Test Login</a>
			<h2>TRY Sherlock API (Sign up)</h2>
			<div class="form-group form-sherlock-email">
				<label for="sherlock_email">Email:</label>
				<input type="email" class="form-control" id="sherlock_email" name="email" placeholder="Email" value="email@email.email">
			</div>
			<div class="form-group form-sherlock-password">
				<label for="sherlock_password">Password:</label>
				<input type="password" class="form-control" id="sherlock_password" name="password" placeholder="Password">
			</div>
			<div class="form-group form-sherlock-pin">
				<label for="sherlock_pin">Pin:</label>
				<input type="password" class="form-control" id="sherlock_pin" name="pin" placeholder="PIN">
			</div>
			<button type="button" class="btn btn-default pull-right" id="wow" onclick="sherlock_signup()">Click</button>
			<p id="result"></p>
		</div>
	</div>

<!-- <div id="container">
	<h1> TRY Sherlock API </h1>

	<input type="email" id="sherlock_email" name="email" placeholder="Email" value="email@email.email" autofocus>

	<input type="password" id="sherlock_password" name="password" placeholder="Password">

	<input type="password" id="sherlock_pin" name="pin" placeholder="PIN">

	<button type="button" id="wow" onclick="sherlock_signup()">Click</button>

	<p id="result"></p>

</div> -->

</body>
</html>

<script type="text/javascript">
function sherlock_signup() {
	sherlock.SignUp('QWERTY');
};

</script>
