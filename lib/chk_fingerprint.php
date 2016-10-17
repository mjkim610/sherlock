<?php
	if (session_status() == PHP_SESSION_NONE) session_start();
	require_once "dbconn.php";

	$tempData = $_POST['datas'];
	$string = json_decode($tempData); // array 형태로 변환
	// echo count($string);

	$thresh_hold1 = 20;
	$thresh_hold2 = 10;

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

	// echo $sql0;
	// var_dump($result);

	if (mysqli_num_rows($result) === 0) {
		echo "1111"; // 이메일 존재하지 않음
		exit();
	}

	$sql2 = "SELECT * FROM user WHERE email = '$email'";
	$result2 = mysqli_query($conn, $sql2);
	$row = mysqli_fetch_assoc($result2);
	$user_id = $row['id'];

	$sql3 = "SELECT * FROM fingerprint WHERE user_id = '$user_id'";
	$result3 = mysqli_query($conn, $sql3);
	if (mysqli_num_rows($result3) > 0) {
		$fingerprints = [];
		while($row = mysqli_fetch_assoc($result3)) {
			$fingerprints[] = $row;
		}
	} else {
		echo "1112"; // fingerprint 가 존재하지 않음
		exit();
	}

	$max_test_value = 0;

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
		if($test_value > $thresh_hold1) {
			$_SESSION['is_login'] = true;
			echo "1101"; // login
			exit();
		}

		if($max_test_value < $test_value)
		{
			$max_test_value = $test_value;
		}
	}

	if($max_test_value > $thresh_hold2){
		echo "1151"; // PIN 사용
		exit();
	}
	else
	{
		echo "1122"; // login failed
		exit();
	}
?>
