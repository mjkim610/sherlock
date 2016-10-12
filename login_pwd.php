<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require_once "lib/dbconn.php";
require_once "lib/head.php";

if(isset($_POST['check_password']) && $_POST['check_password'] === 'y') // fingerprint error -> password check
{
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

	$email = $_POST['email'];

	$sql0 = "SELECT * FROM user WHERE email = '$email'";
	$result = mysqli_query($conn, $sql0);

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

	$user_pwd = $row['password'];
	$user_id = $row['id'];

	$pwd = $_POST['pwd'];

	if($user_pwd !== hash('sha256', $pwd, false))
	{
		echo "<script type='text/javascript'>";
		echo "window.alert('비밀번호가 일치하지 않습니다.');";
		echo "history.back();";
		echo "</script>";
		exit();
	}

	$sql3 = "SELECT * FROM fingerprint WHERE user_id = '$user_id' ORDER BY reg_date ASC";
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
	    echo "window.alert('err152.');";
	    echo "history.back();";
	    echo "</script>";
	    exit();
	}

	$tmp = FALSE;
	if (mysqli_num_rows($result3) > 3) // fingerprint 3개 이상이면 오래된 데이터에 덮어쓰기
	{
		$old_data_id = $fingerprints[0]['id'];

		$sql4 = "DELETE FROM fingerprint WHERE id = '$old_data_id'";
		if ($conn->query($sql4) === TRUE)
		{
			$tmp = TRUE;
		}
	}
	else
	{
		$tmp = TRUE;
	}

	if ($tmp === TRUE) 
	{
	    $sql5 = "INSERT INTO fingerprint(user_id,reg_date,user_agent,language,color_depth,pixel_ratio,resolution,available_resolution,timezone_offset,session_storage,local_storage,indexed_db,cpu_class,navigator_platform,do_not_track,regular_plugins,canvas,webgl,adblock,has_lied_languages,has_lied_resolution,has_lied_os,has_lied_browser,touch_support,js_fonts) VALUES ('$user_id', $reg_date,";

	    foreach($options as $option)
	    {
	      if(isset($_POST[$option]))
	      {
	        $sql5 = $sql5."'".hash('sha256', $_POST[$option], false)."', ";
	      }
	      else $sql5 = $sql5."'', ";
	    }

	    $sql5 = substr($sql5, 0, -2);
	    $sql5 = $sql5.")";

	    if ($conn->query($sql5) === TRUE)
	    {
	    	$_SESSION['is_login'] = true;
	        echo "<script type='text/javascript'>";
	        echo "window.alert('패스워드 로그인 성공');";
	        echo "location.href = 'index.php';";
	        echo "</script>";
	        exit();
	    }
	    else
	    {
	      echo "<script type='text/javascript'>";
	      echo "window.alert('err501');";
	      echo "history.back();";
	      echo "</script>";
	      exit();
	    }
	}
	else 
	{
	   	echo "<script type='text/javascript'>";
	    echo "window.alert('err392.');";
	    echo "history.back();";
	    echo "</script>";
	    exit();
	}
}
?>

<!-- 핑거프린트 테스트 -->
<div class="container-fluid" id="signup">
  <div class="container">
    <div class="row">
      <div class="col-sm-4 col-sm-offset-4">
        <form id="form_login_pwd" action="<?=$_SERVER['PHP_SELF']?>" method="post">
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter password">
          </div>
          <input type="button" class="btn btn-default" value="Submit" id="btn_submit_login_pwd" style="float: right;">
        </form>
      </div>
    </div>
  </div>
</div>

<?php
require_once "lib/footer.php"
?>

<script type="text/javascript">
$("#form_login_pwd").keyup(function(event){
    if(event.keyCode == 13){
        $("#btn_submit_login_pwd").click();
    }
});

$("#btn_submit_login_pwd").on("click", function () {
  var email    = document.getElementById("email").value;
  var pwd    = document.getElementById("pwd").value;

  if(typeof email === 'undefined' || email === '')
  {
    // the variable is defined
    alert("제목을 입력해주세요");
  }
  else if(typeof pwd === 'undefined' || pwd === '')
  {
    // the variable is defined
    alert("비밀번호를 입력해주세요");
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
        $('#form_login_pwd').append(output);
      }
      $('#form_login_pwd').append('<input type="hidden" name="check_password" value="y"/>');
      $('#form_login_pwd').submit();
    });  
  }
});

</script>