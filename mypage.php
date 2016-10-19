<?php
    if (session_status() == PHP_SESSION_NONE) session_start();
    require_once "lib/dbconn.php";
    require_once "lib/head.php";

    if(isset($_SESSION['is_login']) && isset($_SESSION['user_id']))
    {
    	$user_id = $_SESSION['user_id'];

    	$sql0 = "SELECT * FROM fingerprint WHERE user_id = '$user_id'";
		$result0 = mysqli_query($conn, $sql0);
		
		if (mysqli_num_rows($result0) > 0)
		{
			$fingerprints = [];
			
			while($row = mysqli_fetch_assoc($result0))
			{
				$fingerprints[] = $row;
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
                <!-- <div class="fp-card">
                <h4>1. Browser fingerprinting</h4>
                <p>JavaScript calculates the browser fingerprint of the session.</p>
                </div> -->
               	<div class="fp-card-2">
					<header>
						<div class="bio">
			        		<img src="http://www.croop.cl/UI/twitter/images/up.jpg" alt="background" class="card-bg">
							
							<div class="desc">
								<h3>@carlf</h3>
								<p>Carl Fredricksen is the protagonist in Up. He also appeared in Dug's Special Mission as a minor character.</p>
							</div>
						</div>
						
						<div class="avatarcontainer">
							<img src="http://www.croop.cl/UI/twitter/images/carl.jpg" alt="avatar" class="avatar">
							
							<div class="hover">
									<div class="icon-twitter"></div>
							</div>
						</div>
					</header>
					<div class="content">
						<div class="data">
							<ul>
								<li>2,934<span>Tweets</span></li>
								<li>1,119<span>Followers</span></li>
								<li>530<span>Following</span></li>
							</ul>
						</div>

						<div class="follow">
							<div class="icon-twitter"></div> Follow
						</div>
					</div>

				</div>
            </div>
            <div class="col-sm-4">
            	<div class="fp-card-2">
					<header>
						<div class="bio">
			        <img src="http://www.croop.cl/UI/twitter/images/up.jpg" alt="background" class="card-bg">
							<div class="desc">
								<h3>@carlf</h3>
								<p>Carl Fredricksen is the protagonist in Up. He also appeared in Dug's Special Mission as a minor character.</p>
							</div>
						</div>
						
						<div class="avatarcontainer">
							<img src="http://www.croop.cl/UI/twitter/images/carl.jpg" alt="avatar" class="avatar">
							<div class="hover">
									<div class="icon-twitter"></div>
							</div>
						</div>


					</header>

					<div class="content">
						<div class="data">
							<ul>
								<li>
									2,934
									<span>Tweets</span>
								</li>
								<li>
									1,119
									<span>Followers</span>
								</li>
								<li>
									530
									<span>Following</span>
								</li>
							</ul>
						</div>

						<div class="follow"> <div class="icon-twitter"></div> Follow</div>
					</div>

				</div>
            </div>
            <div class="col-sm-4">
            	<div class="fp-card-2">
					<header>
						<div class="bio">
			        <img src="http://www.croop.cl/UI/twitter/images/up.jpg" alt="background" class="card-bg">
							<div class="desc">
								<h3>@carlf</h3>
								<p>Carl Fredricksen is the protagonist in Up. He also appeared in Dug's Special Mission as a minor character.</p>
							</div>
						</div>
						
						<div class="avatarcontainer">
							<img src="http://www.croop.cl/UI/twitter/images/carl.jpg" alt="avatar" class="avatar">
							<div class="hover">
									<div class="icon-twitter"></div>
							</div>
						</div>


					</header>

					<div class="content">
						<div class="data">
							<ul>
								<li>
									2,934
									<span>Tweets</span>
								</li>
								<li>
									1,119
									<span>Followers</span>
								</li>
								<li>
									530
									<span>Following</span>
								</li>
							</ul>
						</div>

						<div class="follow">
							<div class="icon-twitter"></div> Follow
						</div>
					</div>

				</div>
            </div>
        </div>
    </div>
</div>

<?php
	require_once "lib/footer.php"
?>

<script>
	$(document).ready(

	function iniciar(){
	$('.follow').on("click", function(){
		$('.follow').css('background-color','#34CF7A');
		$('.follow').html('<div class="icon-ok"></div> Following');
	});	
	}

);	
</script>