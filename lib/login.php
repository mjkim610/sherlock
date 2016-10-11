<?php
if (session_status() == PHP_SESSION_NONE) session_start();
?>

<!DOCTYPE html>
<html lang="en-us">

<head>
	<meta charset="utf-8">
	<title>Login Page</title>

	<link rel="stylesheet" type="text/css" href="/css/login.css"></link>
</head>

<body>
	<div class="center">
	    <form class="center">
	        Username: <input type="text" id="username"></input> <br/>
	        <input type="submit" id="login" value="Login"></input>
	    </form>
	</div>

	<?php
	require_once "lib/footer.php"
	?>

    <script src="/js/login.js"></script>
</body>

</html>
