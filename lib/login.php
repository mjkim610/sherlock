<!DOCTYPE html>

<head>
    <meta charset="utf-8">

    <title>Sherlock - Sign Up</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="../css/signup.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <form class="form-signup">
            <h2 class="form-signup-heading">Please Log In</h2>
            <label for="inputUsername" class="sr-only">Username</label>
            <input type="text" id="username" class="form-control" placeholder="Username" required autofocus>
            <br />
            <label for="inputPin" class="sr-only">PIN</label>
            <input type="password" id="inputPin" class="form-control" placeholder="PIN">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Password">
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="save-fp"> Save current browser fingerprint
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Log In</button>
        </form>

    </div>

	<script src="/js/login.js"></script>
</body>

</html>
