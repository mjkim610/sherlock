<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require_once "lib/dbconn.php";
require_once "lib/head.php";

if(isset($_POST['check_password']) && $_POST['check_password'] === 'y') // fingerprint error -> password check
{

}
else if(isset($_POST['check_fingerprint']) && $_POST['check_fingerprint'] === 'y') // fingerprint check
{
	$thresh_hold = 20;

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

	$email = $_POST['email'];

	$sql0 = "SELECT * FROM user WHERE email = '$email'";
	$result = mysqli_query($conn, $sql0);

	// echo $sql0;
	// var_dump($result);

	if (mysqli_num_rows($result) === 0)
	{
	echo "<script type='text/javascript'>";
	echo "window.alert('이메일이 존재하지 않습니다.');";
	echo "history.back();";
	echo "</script>";
	exit();
	}

	$sql2 = "SELECT * FROM user WHERE email = '$email'";
	$result2 = mysqli_query($conn, $sql2);
	$row = mysqli_fetch_assoc($result2);
	$user_id = $row['id'];

	$sql3 = "SELECT * FROM fingerprint WHERE user_id = '$user_id'";
	$result3 = mysqli_query($conn, $sql3);
    if (mysqli_num_rows($result3) > 0)
	{
		$fingerprints = [];
		while($row = mysqli_fetch_assoc($result3))
		{
			$fingerprints[] = $row;
		}
	}
	else
	{
		echo "<script type='text/javascript'>";
	    echo "window.alert('err102.');";
	    echo "history.back();";
	    echo "</script>";
	    exit();
	}

	foreach ($fingerprints as $fingerprint)
	{
		$test_value = 0;
		foreach($options as $option)
		{
		  if(isset($_POST[$option]))
		  {
		    if($fingerprint[$option] == hash('sha256', $_POST[$option], false))
		    {
		    	$test_value = $test_value + 1;
		    }
		  }
		}

		if($test_value > $thresh_hold) // fingerprint 일치!
		{
			$_SESSION['is_login'] = true;
	        echo "<script type='text/javascript'>";
	        echo "window.alert('환영합니다');";
	        echo "location.href = 'index.php';";
	        echo "</script>";
	        exit();
		}
	}

	echo "<script type='text/javascript'>";
    echo "window.alert('비밀번호 로그인페이지로 이동');";
    echo "location.href = 'login_pwd.php';";
    echo "</script>";
    exit();
}
?>

<!-- 핑거프린트 테스트 -->
<div class="container-fluid" id="signup">
  <div class="container">
    <div class="row">
      <div class="col-sm-4 col-sm-offset-4">
        <form id="form_login" action="<?=$_SERVER['PHP_SELF']?>" method="post">
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
          </div>
          <input type="button" class="btn btn-default" value="Submit" id="btn_submit_login" style="float: right;">
        </form>
      </div>
    </div>
  </div>
</div>

<div class="container" id="login">
        <form class="form-signup" id="form-login" action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <h2 class="form-signup-heading">Please Sign Up</h2>

            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" autofocus>

            <label class="hidden" for="pwd">Password</label>
            <input class="hidden" type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">

            <label class="hidden" for="pin_pwd">PIN</label>
            <input class="hidden" type="password" class="form-control" id="pin_pwd" name="pin_pwd" placeholder="PIN">

			<br />
          <input type="button" class="btn btn-lg btn-primary btn-block" id="btn_submit_login" value="Log In"></button>

        </form>
</div>


<?php
require_once "lib/footer.php"
?>

<script type="text/javascript">
$("#form_login").keyup(function(event){
    if(event.keyCode == 13){
        $("#btn_submit_login").click();
    }
});

$("#btn_submit_login").on("click", function () {
  var email    = document.getElementById("email").value;

  if(typeof email === 'undefined' || email === '')
  {
    // the variable is defined
    alert("이메일을 입력해주세요");
  }
  else
  {
    var d1 = new Date();
    var fp = new Fingerprint2();
    var string = '';
    var i = 0;
    fp.get(function(result, components,a,b) {
      var d2 = new Date();
      var timeString = "Time took to calculate the fingerprint: " + (d2 - d1) + "ms";
      for (var property in components) {
        var output = '<input type="hidden" name="'+ components[property]['key']+ '" value="'+components[property]['value']+'"/>';
        $('#form_login').append(output);
      }
      $('#form_login').append('<input type="hidden" name="check_fingerprint" value="y"/>');
      $('#form_login').submit();
    });
  }
});

</script>
