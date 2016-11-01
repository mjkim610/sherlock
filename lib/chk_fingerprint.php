<?php
	if (session_status() == PHP_SESSION_NONE) session_start();
	require_once "dbconn.php";
	require_once "function.php";

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

	$email = test_input($_POST['email']);
	$final_fp = test_input($_POST['final_fp']);

	$sql0 = "SELECT * FROM user WHERE email = '$email'";
	$result = mysqli_query($conn, $sql0);

	// echo $sql0;
	// var_dump($result);

	if (mysqli_num_rows($result) === 0) {
		echo "1111"; // 이메일 존재하지 않음

		$reg_date = 'now()';
        $sql = "INSERT INTO trial_log(user_id,email,result,reg_date) VALUES ('', '$email', 'fp-email-err', $reg_date)";

        $conn->query($sql);

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

		$reg_date = 'now()';
        $sql = "INSERT INTO trial_log(user_id,email,result,reg_date) VALUES ('', '$email', 'fp-err', $reg_date)";

        $conn->query($sql);

		exit();
	}

	$max_test_value = 0;

	$num_of_fp = count($fingerprints);
	foreach ($fingerprints as $fingerprint) {
		$fp_num = 1;
		$fp_trial = [];
		$test_value = 0;
		$i = 0;
		foreach($options as $option) {
			if(isset($string[$i])) {
				if($fingerprint[$option] == hash('sha256', $string[$i], false)) {
					$test_value = $test_value + 1;
					$fp_trial[$i] = 1;
				}
				else $fp_trial[$i] = 0;
			}
			else $fp_trial[$i] = 0;
			$i = $i + 1;
		}

		// fingerprint 일치!
		if($test_value > $thresh_hold1) {

			if($email == 'gold@is.here')
			{
				$_SESSION['gold'] = 'got_it';
			}

			$_SESSION['is_login'] = true;
			$_SESSION['user_id'] = $user_id;
			echo "1101"; // login

			$reg_date = 'now()';
            $sql = "INSERT INTO trial_log(user_id,email,num_of_fp,fp_num,result,num_of_match,reg_date,user_agent,language,color_depth,pixel_ratio,resolution,available_resolution,timezone_offset,session_storage,local_storage,indexed_db,cpu_class,navigator_platform,do_not_track,regular_plugins,canvas,webgl,adblock,has_lied_languages,has_lied_resolution,has_lied_os,has_lied_browser,touch_support,js_fonts,ip_1,ip_2,ip_3,ip_4,final_fp) VALUES ('$user_id', '$email', '$num_of_fp', '$fp_num', 'fp-ok', '$test_value', $reg_date,";

            foreach($fp_trial as $trial) {
                    $sql = $sql."'".$trial."', ";
            }
            $sql = $sql."'".$final_fp."', ";
            $sql = substr($sql, 0, -2);
            $sql = $sql.")";

            $conn->query($sql);

			exit();
		}

		if($max_test_value < $test_value)
		{
			$max_test_value = $test_value;
			$max_fp_num = $fp_num;
		}

		$fp_num++;
	}

	if($max_test_value > $thresh_hold2)
	{
		if($email == 'gold@is.here')
		{
			echo "1155"; // 다시 fp 검사
		}
		else
		{
			echo "1151"; // PIN 사용
		}

		$reg_date = 'now()';
           $sql = "INSERT INTO trial_log(user_id,email,num_of_fp,fp_num,result,num_of_match,reg_date,user_agent,language,color_depth,pixel_ratio,resolution,available_resolution,timezone_offset,session_storage,local_storage,indexed_db,cpu_class,navigator_platform,do_not_track,regular_plugins,canvas,webgl,adblock,has_lied_languages,has_lied_resolution,has_lied_os,has_lied_browser,touch_support,js_fonts,ip_1,ip_2,ip_3,ip_4,final_fp) VALUES ('$user_id', '$email', '$num_of_fp', '$max_fp_num', 'fp-pin', '$max_test_value', $reg_date,";

        foreach($fp_trial as $trial) {
                $sql = $sql."'".$trial."', ";
        }
        $sql = $sql."'".$final_fp."', ";
        $sql = substr($sql, 0, -2);
        $sql = $sql.")";

        $conn->query($sql);
		
		exit();
	}
	else
	{
		if($email == 'gold@is.here')
		{
			echo "1155"; // 다시 fp 검사
		}
		else
		{
			echo "1122"; // login failed
		}

		$reg_date = 'now()';
        $sql = "INSERT INTO trial_log(user_id,email,num_of_fp,fp_num,result,num_of_match,reg_date,user_agent,language,color_depth,pixel_ratio,resolution,available_resolution,timezone_offset,session_storage,local_storage,indexed_db,cpu_class,navigator_platform,do_not_track,regular_plugins,canvas,webgl,adblock,has_lied_languages,has_lied_resolution,has_lied_os,has_lied_browser,touch_support,js_fonts,ip_1,ip_2,ip_3,ip_4,final_fp) VALUES ('$user_id', '$email', '$num_of_fp', '$max_fp_num', 'fp-pw', '$max_test_value', $reg_date,";

        foreach($fp_trial as $trial) {
                $sql = $sql."'".$trial."', ";
        }
        $sql = $sql."'".$final_fp."', ";
        $sql = substr($sql, 0, -2);
        $sql = $sql.")";

        $conn->query($sql);

		exit();
	}
?>
