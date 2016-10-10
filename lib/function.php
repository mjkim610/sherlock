<?php
function get_timeago( $ptime )
{
	$estimate_time = time() - strtotime($ptime);

	if( $estimate_time < 1 )
	{
		return '방금 전';
	}

	$condition = array(
		12 * 30 * 24 * 60 * 60  =>  '년',
		30 * 24 * 60 * 60       =>  '달',
		24 * 60 * 60            =>  '일',
		60 * 60                 =>  '시간',
		60                      =>  '분',
		1                       =>  '초'
		);

	foreach( $condition as $secs => $str )
	{
		$d = $estimate_time / $secs;

		if( $d >= 1)
		{
			if($str == '시간' || $str == '분' || $str == '초')
			{
				$r = round( $d );
				return $r . $str . ' 전';
			}
			else
			{
				$ripple_date = explode(' ', $ptime);
				$date = $ripple_date[0];
				$time = $ripple_date[1];
				$date_2 = explode('-', $date);
				$str = $date_2[1].'월 '.$date_2[2].'일';
				return $str;
			}

		}
	}
}

function goback_with_alert($string)
{
	echo "<script type='text/javascript'>";
	echo "window.alert('" . $string . "');";
	echo "history.back();";
	echo "</script>";
}

function goto_with_alert($string, $href)
{
	echo "<script type='text/javascript'>";
	echo "window.alert('" . $string . "');";
	echo "location.href = '". $href ."';";
	echo "</script>";
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>