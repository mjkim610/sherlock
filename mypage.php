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
				$tmp .= '			<img src="img/'.$i.'.png" alt="avatar" class="avatar">';
							
				$tmp .= '			<div class="hover">';
				$tmp .= '					<img src="img/favicon.png" alt="avatar" class="avatar">';
				$tmp .= '			</div>';
				$tmp .= '		</div>';
				$tmp .= '	</header>';
				$tmp .= '	<div class="content">';
				$tmp .= '		<div class="data">';
				$tmp .= '			<ul>';
				$tmp .= '				<li>'.$fingerprint['reg_date'].'<span>Regist day</span></li>';
				$tmp .= '				<li>1,119<span>Followers</span></li>';
				$tmp .= '			</ul>';
				$tmp .= '		</div>';

				$tmp .= '		<div class="replace_fp" id="replace_fp-'.$fingerprint['id'].'" onclick="replace_fp('.$fingerprint['id'].','.$i.')">';
				$tmp .= '			<div class="icon-twitter"></div> Renew';
				$tmp .= '		</div>';
				$tmp .= '	</div>';

				$tmp .= '</div>';				

				$fp_html[$i] = $tmp;
			}

			$blank_html = '<div class="fp-card-2">';
			$blank_html .= '	<header>						';
			$blank_html .= '		<div class="avatarcontainer">';
			$blank_html .= '			<img src="img/x.png" alt="avatar" class="avatar">';
						
			$blank_html .= '			<div class="hover">';
			$blank_html .= '					<img src="img/favicon.png" alt="avatar" class="avatar">';
			$blank_html .= '			</div>';
			$blank_html .= '		</div>';
			$blank_html .= '	</header>';
			$blank_html .= '	<div class="content">';
			$blank_html .= '		<div class="data">';
			$blank_html .= '			<ul>';
			$blank_html .= '				<li>nope<span>Regist day</span></li>';
			$blank_html .= '				<li>nope<span>Followers</span></li>';
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
        	<div class="col-sm-4" id="fp_1">
               	<?=$fp_html[1]?>
            </div>
            <div class="col-sm-4" id="fp_2">
            	<?=$fp_html[2]?>
            </div>
            <div class="col-sm-4" id="fp_3">
            	<?=$fp_html[3]?>
            </div>
        </div>
    </div>
</div>

<?php
	require_once "lib/footer.php"
?>

<script type="text/javascript">
	function replace_fp(index1, index2)
	{
		var ask = confirm("Wanna change Fingerprint?");
		if(ask)
		{
			var fp = new Fingerprint2();
		    var ips = getIP();
			var string = '';
			var i = 0;
			fp.get(function(result, components,a,b) {
				var strings = '';

				for (var property in components) {
					strings = strings + '!@#' + components[property]['value'];
				}

				for (var ip in ips) {
					 strings = strings + '!@#' + ip;
				}

				var ttt = strings.split('!@#'); // array 형태로 변환
				var ddd = ttt.shift(); // 첫번째 원소 제거
				$.ajax({
					type : "POST",
					data : {
						id : index1,
						datas : JSON.stringify(ttt) // json 형태로 변환
					},
					url : "lib/replace_fingerprint.php",
					success: function(result)
					{
						if(result == '5511')
						{
							alert('Try again (err 509)');
						}
						else if(result == '5522')
						{
							alert('Nice try (err 519)');
						}
						else if(result == '5532')
						{
							alert('Try again (err 512)');
						}
						else if(result == '5577') // 성공
						{
							var html_string = '';
							html_string = '<div class="fp-card-2">';
							html_string += '	<header>						';
							html_string += '		<div class="avatarcontainer">';
							html_string += '			<img src="http://www.croop.cl/UI/twitter/images/carl.jpg" alt="avatar" class="avatar">';
										
							html_string += '			<div class="hover">';
							html_string += '					<div class="icon-twitter"></div>';
							html_string += '			</div>';
							html_string += '		</div>';
							html_string += '	</header>';
							html_string += '	<div class="content">';
							html_string += '		<div class="data">';
							html_string += '			<ul>';
							html_string += '				<li>replaced<span>Regist day</span></li>';
							html_string += '				<li>replaced<span>Followers</span></li>';
							html_string += '			</ul>';
							html_string += '		</div>';

							html_string += '		<div class="replace_fp">';
							html_string += '			<div class="icon-twitter"></div> replaced';
							html_string += '		</div>';
							html_string += '	</div>';

							html_string += '</div>';
							$("#fp_"+index2).html(html_string);
						}
						else if(result == '5588')
						{
							alert('Try again (err 552)');
						}
						else
						{
							alert('Try again (err 510)');
						}

			        },
			        error: function (xhr, ajaxOptions, thrownError) {
				           alert(xhr.status);
				           alert(xhr.responseText);
				           alert(thrownError);
				       }
				});
			});
		}
	};
</script>