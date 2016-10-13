<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require_once "lib/dbconn.php";
require_once "lib/head.php";

if(isset($_POST['check_password']) && $_POST['check_password'] === 'y') // fingerprint error -> password check
{

}
else if(isset($_POST['check_fingerprint']) && $_POST['check_fingerprint'] === 'y') // fingerprint check
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

  $pwd = hash('sha256', $_POST['pwd'], false);
  $pin_pwd = hash('sha256', $_POST['pin_pwd'], false);

  $email = $_POST['email'];

  $sql0 = "SELECT * FROM user WHERE email = '$email'";
  $result = mysqli_query($conn, $sql0);

  // echo $sql0;
  // var_dump($result);

  if (mysqli_num_rows($result) !== 0)
  {
    echo "<script type='text/javascript'>";
    echo "window.alert('이미 존재하는 이메일입니다.');";
    echo "history.back();";
    echo "</script>";
    exit();
  }

  $sql1 = "INSERT INTO user(email, password, pin_password) VALUES ('$email', '$pwd', '$pin_pwd')";
  if ($conn->query($sql1) === TRUE)
  {
    $sql2 = "SELECT * FROM user WHERE email = '$email'";
    $result2 = mysqli_query($conn, $sql2);
    $row = mysqli_fetch_assoc($result2);
    $user_id = $row['id'];


    $sql3 = "INSERT INTO fingerprint(user_id,reg_date,user_agent,language,color_depth,pixel_ratio,resolution,available_resolution,timezone_offset,session_storage,local_storage,indexed_db,cpu_class,navigator_platform,do_not_track,regular_plugins,canvas,webgl,adblock,has_lied_languages,has_lied_resolution,has_lied_os,has_lied_browser,touch_support,js_fonts) VALUES ('$user_id', $reg_date,";

    foreach($options as $option)
    {
      if(isset($_POST[$option]))
      {
        $sql3 = $sql3."'".hash('sha256', $_POST[$option], false)."', ";
      }
      else $sql3 = $sql3."'', ";
    }

    $sql3 = substr($sql3, 0, -2);
    $sql3 = $sql3.")";

    if ($conn->query($sql3) === TRUE)
    {
        echo "<script type='text/javascript'>";
        echo "window.alert('가입완료');";
        echo "location.href = 'index.php';";
        echo "</script>";
        exit();
    }
    else
    {
      echo "<script type='text/javascript'>";
      echo "window.alert('err101');";
      echo "history.back();";
      echo "</script>";
      exit();
    }
  }
  else
  {
    echo "<script type='text/javascript'>";
    echo "window.alert('err111');";
    echo "history.back();";
    echo "</script>";
    exit();
  }
}
?>

<!-- 회원가입 -->
<div class="container" id="signup">
        <form class="form-signup" id="form-signup" action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <h2 class="form-signup-heading">Please Sign Up</h2>

            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" autofocus>

            <label for="pwd">Password</label>
            <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
            <!-- <label for="re_pwd">Retype Password:</label> -->
            <input type="password" class="form-control" id="re_pwd" name="re_pwd" placeholder="Retype Password">

            <label for="pin_pwd">PIN</label>
            <input type="password" class="form-control" id="pin_pwd" name="pin_pwd" placeholder="PIN">
            <!-- <label for="re_pin_pwd">Retype PIN</label> -->
            <input type="password" class="form-control" id="re_pin_pwd" name="re_pin_pwd" placeholder="Retype PIN">

          <input type="button" class="btn btn-lg btn-primary btn-block" id="btn_submit_signup" value="Sign Up"></button>

        </form>
</div>


<?php
require_once "lib/footer.php"
?>

<script type="text/javascript">
$("#form_signup").keyup(function(event){
    if(event.keyCode == 13){
        $("#btn_submit_signup").click();
    }
});

$("#btn_submit_signup").on("click", function () {
  var email    = document.getElementById("email").value;
  var pwd    = document.getElementById("pwd").value;
  var re_pwd    = document.getElementById("re_pwd").value;
  var pin_pwd    = document.getElementById("pin_pwd").value;

  if(typeof email === 'undefined' || email === '')
  {
    // the variable is defined
    alert("이메일을 입력해주세요");
  }
  else if(typeof pwd === 'undefined' || pwd === '' || typeof re_pwd === 'undefined' || re_pwd === '')
  {
    // the variable is defined
    alert("비밀번호를 정확하게 입력해주세요");
  }
  else if(re_pwd !== pwd)
  {
    // the variable is defined
    alert("비밀번호가 일치하지 않습니다");
  }
  else if(typeof pin_pwd === 'undefined' || pin_pwd === '')
  {
    // the variable is defined
    alert("핀 비밀번호를 정확하게 입력해주세요");
  }
  else if(pin_pwd.length !== 4) // 추가 검사 필요
  {
    alert("핀 비밀번호는 4자리 숫자 입니다");
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
        $('#form_signup').append(output);
      }
      $('#form_signup').append('<input type="hidden" name="check_fingerprint" value="y"/>');
      $('#form_signup').submit();
    });
  }
});

</script>
