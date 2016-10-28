<?php
	if (session_status() == PHP_SESSION_NONE) session_start();
	require_once "dbconn.php";
	require_once "function.php";

	$email = test_input($_POST['email']);	
	$password = test_input($_POST['password']);	
	
	$sql0 = "SELECT * FROM user WHERE email = '$email'";
	$result = mysqli_query($conn, $sql0);

	if (mysqli_num_rows($result) === 0) {
		echo "2111"; // 이메일 존재하지 않음

		$reg_date = 'now()';
        $sql = "INSERT INTO trial_log(user_id,email,result,reg_date) VALUES ('', '$email', 'pw-email-err', $reg_date)";

        $conn->query($sql);

		exit();
	}

	$sql2 = "SELECT * FROM user WHERE email = '$email'";
	$result2 = mysqli_query($conn, $sql2);
	$row = mysqli_fetch_assoc($result2);
	$user_pwd = $row['password'];
	$user_id = $row['id'];

	if($user_pwd === hash('sha256', $password, false))
	{			

		if($email == 'gold@is.here')
		{
			$_SESSION['gold'] = 'got_it';
		}

		$_SESSION['is_login'] = true;
		$_SESSION['user_id'] = $user_id;
		echo "2221";

		$reg_date = 'now()';
        $sql = "INSERT INTO trial_log(user_id,email,result,reg_date) VALUES ('$user_id', '$email', 'pw-ok', $reg_date)";

        $conn->query($sql);
		exit();
	}
	else 
	{
		echo "2223";

		$reg_date = 'now()';
        $sql = "INSERT INTO trial_log(user_id,email,result,reg_date) VALUES ('$user_id', '$email', 'pw-fail', $reg_date)";

        $conn->query($sql);
	}
	exit();

?>