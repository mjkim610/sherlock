<?php
	if (session_status() == PHP_SESSION_NONE) session_start();
	require_once "dbconn.php";

	$tempData = $_POST['datas'];
	$string = json_decode($tempData); // array 형태로 변환
	// echo count($string);

	$thresh_hold = 10;

	$options = [];
	$options[] = 'user_agent';
	$options[] = 'language';
	$options[] = 'color_depth';
	$options[] = 'pixel_ratio';
	$options[] = 'resolution';
	$options[] = 'available_resolution';
	$options[] = 'timezone_offset';
	$options[] = 'session_storage';
	$options[] = 'local_storage';
	$options[] = 'indexed_db';
	$options[] = 'cpu_class';
	$options[] = 'navigator_platform';
	$options[] = 'do_not_track';
	$options[] = 'regular_plugins';
	$options[] = 'canvas';
	$options[] = 'webgl';
	$options[] = 'adblock';
	$options[] = 'has_lied_languages';
	$options[] = 'has_lied_resolution';
	$options[] = 'has_lied_os';
	$options[] = 'has_lied_browser';
	$options[] = 'touch_support';
	$options[] = 'js_fonts';
	$options[] = 'ip_1';
	$options[] = 'ip_2';
	$options[] = 'ip_3';
	$options[] = 'ip_4';

	$email = $_POST['email'];

	$sql0 = "SELECT * FROM user WHERE email = '$email'";
	$result = mysqli_query($conn, $sql0);

	if (mysqli_num_rows($result) === 0) {
		echo "3111"; // 이메일 존재하지 않음
		exit();
	}

	$sql2 = "SELECT * FROM user WHERE email = '$email'";
	$result2 = mysqli_query($conn, $sql2);
	$row = mysqli_fetch_assoc($result2);
	$user_id = $row['id'];
	$pin = $row['pin_password'];

	$sql3 = "SELECT * FROM fingerprint WHERE user_id = '$user_id'";
	$result3 = mysqli_query($conn, $sql3);
	if (mysqli_num_rows($result3) > 0) {
		$fingerprints = [];
		while($row = mysqli_fetch_assoc($result3)) {
			$fingerprints[] = $row;
		}
	} else {
		echo "3112"; // fingerprint 가 존재하지 않음
		exit();
	}

	if($pin == hash('sha256', $_POST['pin']))
	{
		$is_pin_ok = true;
	}
	else $is_pin_ok = false;

	foreach ($fingerprints as $fingerprint) {
		$test_value = 0;
		$i = 0;
		foreach($options as $option) {
			if(isset($string[$i])) {
				if($fingerprint[$option] == hash('sha256', $string[$i], false)) {
					$test_value = $test_value + 1;
				}
			}
			$i = $i + 1;
		}

		// fingerprint 일치!
		if($test_value > $thresh_hold && $is_pin_ok === true) {
			$_SESSION['is_login'] = true;
			$_SESSION['user_id'] = $user_id;
			echo "3101"; // login
			exit();
		}
	}

	if($is_pin_ok === true)
	{
		echo '3323'; // fingerprint error -> 장난질
	}
	else echo '3233'; // login failed -> password login
	exit();
?>
