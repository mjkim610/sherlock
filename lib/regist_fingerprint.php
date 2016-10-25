<?php
	if (session_status() == PHP_SESSION_NONE) session_start();
	require_once "dbconn.php";

	if(isset($_SESSION['is_login']) && isset($_SESSION['user_id']))
    {
    	$user_id = $_SESSION['user_id'];

		$tempData = $_POST['datas'];
		$string = json_decode($tempData); // array 형태로 변환

		if($user_id !== $_POST['id'])
		{
			echo '7761';
			exit();
		}

		$reg_date = 'now()';

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

		$sql = "SELECT * FROM fingerprint WHERE user_id = '$user_id'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 3) {
			echo '7776';
			exit();
		}

        $sql = "INSERT INTO fingerprint(user_id,reg_date,user_agent,language,color_depth,pixel_ratio,resolution,available_resolution,timezone_offset,session_storage,local_storage,indexed_db,cpu_class,navigator_platform,do_not_track,regular_plugins,canvas,webgl,adblock,has_lied_languages,has_lied_resolution,has_lied_os,has_lied_browser,touch_support,js_fonts,ip_1,ip_2,ip_3,ip_4) VALUES ('$user_id', $reg_date,";

        $i = 0;
        foreach($options as $option) {
            if(isset($string[$i])) {
                $sql = $sql."'".hash('sha256', $string[$i], false)."', ";
            } else {
                $sql = $sql."'', ";
            }
            $i = $i + 1;
        }

        $sql = substr($sql, 0, -2);
        $sql = $sql.")";

        if ($conn->query($sql) === TRUE) {
            echo "7712";
            exit();
        }
        else {
            echo "7733";
            exit();
        }
	}
?>
