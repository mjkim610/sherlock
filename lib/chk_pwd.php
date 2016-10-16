<?php
	if (session_status() == PHP_SESSION_NONE) session_start();
	require_once "dbconn.php";

	$email = $_POST['email'];	
	$password = $_POST['password'];	
	
	$sql0 = "SELECT * FROM user WHERE email = '$email'";
	$result = mysqli_query($conn, $sql0);

	if (mysqli_num_rows($result) === 0) {
		echo "2111"; // 이메일 존재하지 않음
		exit();
	}

	$sql2 = "SELECT * FROM user WHERE email = '$email'";
	$result2 = mysqli_query($conn, $sql2);
	$row = mysqli_fetch_assoc($result2);
	$user_pwd = $row['password'];

	if($user_pwd === hash('sha256', $password, false))
	{
		$_SESSION['is_login'] = true;
		echo "2221";
		exit();
	}
	else echo "2223";

	exit();

?>