<?php
    if (session_status() == PHP_SESSION_NONE) session_start();
    require_once "lib/dbconn.php";
    require_once "lib/head.php";

    if(isset($_SESSION['is_login']) && isset($_SESSION['user_id']))
    {
    	$user_id = $_SESSION['user_id'];

    	$sql0 = "SELECT * FROM fingerprint WHERE user_id = '$user_id' ORDER BY reg_date DESC";
		$result0 = mysqli_query($conn, $sql0);
		
		if (mysqli_num_rows($result0) > 0)
		{
			$fingerprints = [];
			
			while($row = mysqli_fetch_assoc($result0))
			{
				$fingerprints[] = $row;
			}

			$fp_num = count($fingerprints);

			$fp_html = [];
			$i = 0;
			foreach ($fingerprints as $fingerprint) {
				
				$i++;

				$tmp = '<div class="fp-card-2">';
				$tmp .= '	<header>						';
				$tmp .= '		<div class="avatarcontainer">';
				$tmp .= '			<img src="http://www.croop.cl/UI/twitter/images/carl.jpg" alt="avatar" class="avatar">';
							
				$tmp .= '			<div class="hover">';
				$tmp .= '					<div class="icon-twitter"></div>';
				$tmp .= '			</div>';
				$tmp .= '		</div>';
				$tmp .= '	</header>';
				$tmp .= '	<div class="content">';
				$tmp .= '		<div class="data">';
				$tmp .= '			<ul>';
				$tmp .= '				<li>'.$fingerprint['reg_date'].'<span>Tweets</span></li>';
				$tmp .= '				<li>1,119<span>Followers</span></li>';
				$tmp .= '				<li>530<span>Following</span></li>';
				$tmp .= '			</ul>';
				$tmp .= '		</div>';

				$tmp .= '		<div class="replace_fp" id="replace_fp-'.$i.'" onclick="replace_fp('.$i.')">';
				$tmp .= '			<div class="icon-twitter"></div> Renew';
				$tmp .= '		</div>';
				$tmp .= '	</div>';

				$tmp .= '</div>';				

				$fp_html[$i] = $tmp;
			}

			$blank_html = '<div class="fp-card-2">';
			$blank_html .= '	<header>						';
			$blank_html .= '		<div class="avatarcontainer">';
			$blank_html .= '			<img src="http://www.croop.cl/UI/twitter/images/carl.jpg" alt="avatar" class="avatar">';
						
			$blank_html .= '			<div class="hover">';
			$blank_html .= '					<div class="icon-twitter"></div>';
			$blank_html .= '			</div>';
			$blank_html .= '		</div>';
			$blank_html .= '	</header>';
			$blank_html .= '	<div class="content">';
			$blank_html .= '		<div class="data">';
			$blank_html .= '			<ul>';
			$blank_html .= '				<li>nope<span>Tweets</span></li>';
			$blank_html .= '				<li>nope<span>Followers</span></li>';
			$blank_html .= '				<li>nope<span>Following</span></li>';
			$blank_html .= '			</ul>';
			$blank_html .= '		</div>';

			$blank_html .= '		<div class="replace_fp">';
			$blank_html .= '			<div class="icon-twitter"></div> Renew';
			$blank_html .= '		</div>';
			$blank_html .= '	</div>';

			$blank_html .= '</div>';


			if($i == 1) // fp가 1개면
			{
				$fp_html[2] = $blank_html;
				$fp_html[3] = $blank_html;
			}
			else if($i == 2) // fp가 2개면
			{
				$fp_html[3] = $blank_html;
			}
			//갯수 계산해서 html 문으로 cadr_html[0,1,2] 에 넣어주기
			//없으면 불투명 또는 이미지로 대체
			//있을 때 보여줄만한 정보가 뭐가있을까나
		}
		else
		{
			echo "<script type='text/javascript'>";
			echo "window.alert('다시 시도해주세요.(err 921)');";
			echo "history.back();";
			echo "</script>";
			exit();
		}

    }
    else
    {
    	echo "<script type='text/javascript'>";
		echo "window.alert('잘못된 접근입니다.(err 991)');";
		echo "history.back();";
		echo "</script>";
		exit();
    }



?>
<!-- 로그인 폼 -->
<div class="container-fluid tran-light-gray" id="mypage">
    <div class="container">
        <div class="row">
        	<div class="col-sm-4">
               	<?=$fp_html[1]?>
            </div>
            <div class="col-sm-4">
            	<?=$fp_html[2]?>
            </div>
            <div class="col-sm-4">
            	<?=$fp_html[3]?>
            </div>
        </div>
    </div>
</div>

<?php
	require_once "lib/footer.php"
?>

<script>

function replace_fp(index)
{
	var ask = confirm("Wanna change Fingerprint?");
	if(ask) alert('yyy');
	else alert('nnn');
	
	$('#replace_fp-'+index).css('background-color','#34CF7A');
	$('#replace_fp-'+index).html('<div class="icon-ok"></div> Replaced!');
};

</script>