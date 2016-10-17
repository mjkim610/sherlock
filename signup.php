<?php
    if (session_status() == PHP_SESSION_NONE) session_start();
    require_once "lib/dbconn.php";
    require_once "lib/head.php";

    // fingerprint check
    if(isset($_POST['check_fingerprint']) && $_POST['check_fingerprint'] === 'y') {
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

        $password = hash('sha256', $_POST['password'], false);
        $pin = hash('sha256', $_POST['pin'], false);

        $email = $_POST['email'];

        $sql0 = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $sql0);

        // echo $sql0;
        // var_dump($result);

        if (mysqli_num_rows($result) !== 0) {
            echo "<script type='text/javascript'>";
            echo "window.alert('이미 존재하는 이메일입니다.');";
            echo "history.back();";
            echo "</script>";
            exit();
        }

        $sql1 = "INSERT INTO user(email, password, pin_password) VALUES ('$email', '$password', '$pin')";
        if ($conn->query($sql1) === TRUE)
        {
            $sql2 = "SELECT * FROM user WHERE email = '$email'";
            $result2 = mysqli_query($conn, $sql2);
            $row = mysqli_fetch_assoc($result2);
            $user_id = $row['id'];

            $sql3 = "INSERT INTO fingerprint(user_id,reg_date,user_agent,language,color_depth,pixel_ratio,resolution,available_resolution,timezone_offset,session_storage,local_storage,indexed_db,cpu_class,navigator_platform,do_not_track,regular_plugins,canvas,webgl,adblock,has_lied_languages,has_lied_resolution,has_lied_os,has_lied_browser,touch_support,js_fonts,ip_1,ip_2,ip_3,ip_4) VALUES ('$user_id', $reg_date,";

            foreach($options as $option) {
                if(isset($_POST[$option])) {
                    $sql3 = $sql3."'".hash('sha256', $_POST[$option], false)."', ";
                } else {
                    $sql3 = $sql3."'', ";
                }
            }

            $sql3 = substr($sql3, 0, -2);
            $sql3 = $sql3.")";

            if ($conn->query($sql3) === TRUE) {
                echo "<script type='text/javascript'>";
                echo "window.alert('가입완료');";
                echo "location.href = 'index.php';";
                echo "</script>";
                exit();
            }
            else {
                echo "<script type='text/javascript'>";
                echo "window.alert('err101');";
                echo "history.back();";
                echo "</script>";
                exit();
            }
        }
        else {
            echo "<script type='text/javascript'>";
            echo 'window.alert("err111'.$sql1.'");';
            echo "history.back();";
            echo "</script>";
            exit();
        }
    }
?>

<!-- 회원가입 -->
<div class="login_container" id="signup">
    <form class="form-signup" id="form-signup" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <h2 class="form-signup-heading">Sign Up</h2>

        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" autofocus>

        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        <!-- <label for="re_password">Retype Password:</label> -->
        <input type="password" class="form-control" id="re_password" name="re_password" placeholder="Retype Password">

        <label for="pin">PIN</label>
        <input type="password" class="form-control" id="pin" name="pin" placeholder="PIN">
        <!-- <label for="re_pin">Retype PIN</label> -->
        <input type="password" class="form-control" id="re_pin" name="re_pin" placeholder="Retype PIN">

        <input type="button" class="btn btn-lg btn-primary btn-block" id="btn_submit_signup" value="Sign Up"></button>

    </form>
</div>


<?php
    require_once "lib/footer.php"
?>

<script type="text/javascript">
    $("#form-signup").keyup(function(event) {
        if(event.keyCode == 13) {
            $("#btn_submit_signup").click();
        }
    });

    $("#btn_submit_signup").on("click", function () {
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        var re_password = document.getElementById("re_password").value;
        var pin = document.getElementById("pin").value;
        var re_pin = document.getElementById("re_pin").value;

        if(typeof email === 'undefined' || email === '') {
            // the variable is defined
            alert("이메일을 입력해주세요");
        }
        else if(typeof password === 'undefined' || password === '' || typeof re_password === 'undefined' || re_password === '') {
            // the variable is defined
            alert("비밀번호를 정확하게 입력해주세요");
        }
        else if(re_password !== password) {
            // the variable is defined
            alert("비밀번호가 일치하지 않습니다");
        }
        else if(typeof pin === 'undefined' || pin === '' || typeof re_pin === 'undefined' || re_pin === '') {
            // the variable is defined
            alert("핀비밀번호를 정확하게 입력해주세요");
        }
        else if(re_pin !== pin) {
            alert("핀번호가 일치하지 않습니다")
        }
        // 추가 검사 필요
        else if(pin.length !== 4) {
            alert("핀번호는 4자리 숫자 입니다");
        }
        else {
            var d1 = new Date();
            var fp = new Fingerprint2();
            var ips = getIP();

            fp.get(function(result, components,a,b) {
                var d2 = new Date();
                var timeString = "Time took to calculate the fingerprint: " + (d2 - d1) + "ms";
                for (var property in components) {
                    var output = '<input type="hidden" name="'+ components[property]['key']+ '" value="'+components[property]['value']+'"/>';
                    $('#form-signup').append(output);
                }

                var i = 1;
                for (var ip in ips) {
                     var output = '<input type="hidden" name="ip_' + i + '" value="'+ ip +'"/ />';
                    $('#form-signup').append(output);
                    i++;
                }

                $('#form-signup').append('<input type="hidden" name="check_fingerprint" value="y"/>');
                $('#form-signup').submit();
            });
        }
    });
</script>
