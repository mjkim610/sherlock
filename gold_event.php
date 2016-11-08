<?php
    if (session_status() == PHP_SESSION_NONE) session_start();
    require_once "lib/dbconn.php";
    require_once "lib/head.php";
    require_once "lib/get_ip.php";
?>

<div class="container-fluid tran-gray">
    <div class="container">
        <div class="text-center">
            <h2>Break Through Sherlock's Defenses!</h2><br>
        </div>
        <div class="row service_step">
            <br />
            <div class="col-sm-6">
                <div class="gold-text">
                  <h4>Sherlock is waiting for you!</h4>
                  <p>Mr. Holmes is protecting a pile of gold from potential thiefs. If you are able to maneuver through Sherlock's defenses you can take home the gold!</p>
                </div>

                <div class="gold-text">
                  <h4>Actual reward</h4>
                  <p>Upon successful login to the <b>try.sherlock@gmail.com</b> account, a message prompt with instructions to contact the Sherlock team will appear. Those who follow the instructions will be rewarded with actual prizes!</p>
                </div>

                <div class="gold-text">
                  <h4>How to</h4>
                  <p>The <b>try.sherlock@gmail.com</b> account is an email account stored in Sherlock servers in exactly the same way as a normal user account. Whoever is able to spoof their identity and log in to the  <b>try.sherlock@gmail.com</b> first wins the prize.<!--  Players can log in with any of the 3 methods:<br />1) Fingerprint, 2) PIN, 3) Password --></p>
                </div>
            </div>

            <div class="col-sm-6">
            <div class="login_container">
            <form class="form-signup" id="form-login" action="<?=$_SERVER['PHP_SELF']?>" method="post">
              <h2 class="form-signup-heading">Wanna try?</h2>

              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="try.sherlock@gmail.com" readonly>

              <label class="hidden" id="pwd_label" for="pwd">Password</label>
              <input class="hidden form-control" type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">

              <label class="hidden" id="pin_label" for="pin_pwd">PIN</label>
              <input class="hidden form-control" type="password" class="form-control" id="pin_pwd" name="pin_pwd" placeholder="PIN">

              <br />
              <input type="button" class="btn btn-lg btn-primary btn-block" id="btn_submit_login" value="Gold is Mine!!">

              <input type="hidden" id="login_type" value="fp">

            </form>
            </div>
            </div>
        </div>
    </div>
</div>

<?php
  require_once "lib/footer.php"
?>

<script type="text/javascript">
  $("#form-login").keyup(function(event) {
    if(event.keyCode == 13) {
      $("#btn_submit_login").click();
    }
  });

  $("#btn_submit_login").on("click", function() {
    var email_val = $("#email").val();
    var login_type = $("#login_type").val();

    if(login_type == 'fp')
    {

      if (typeof email_val === 'undefined' || email_val === '') {
        alert("Enter a valid email address");
      }
      else {
        var d1 = new Date();
        var fp = new Fingerprint2();
        var ips = document.getElementById("ip").innerHTML.split('.');
        var string = '';
        var i = 0;
        fp.get(function(result, components,a,b) {
          var strings = '';

          for (var property in components) {
            strings = strings + '!@#' + components[property]['value'];
          }

          for (var ip in ips) {
             strings = strings + '!@#' + ips[ip];
          }

          var ttt = strings.split('!@#'); // array 형태로 변환
          var ddd = ttt.shift(); // 첫번째 원소 제거
          $.ajax({
            type : "POST",
            data : {
              email : email_val,
              final_fp : result,
              datas : JSON.stringify(ttt) // json 형태로 변환
            },
            url : "lib/chk_fingerprint.php",
            success: function(result)
            {
              var json_result = $.parseJSON(result);

              if(result == '1111')
              {
                alert('This email address does not exist');
              }
              else if(result == '1112')
              {
                alert('Try again (err 109)');
              }
              else if(result == '1101')
              {
                alert('Welcome');
                location.href = 'index.php';
              }
              else if(result == '1122')
              {
                alert('Fingerprint login failed. Please enter password');
                $("#login_type").val("password");
                $("#pwd_label").removeClass("hidden");
                $("#pwd").removeClass("hidden");
                $("#pwd").focus();

              }
              else if(result == '1151')
              {
                alert('Fingerprint is not perfect. Please enter PIN');
                $("#login_type").val("pin");
                $("#pin_label").removeClass("hidden");
                $("#pin_pwd").removeClass("hidden");
                $("#pin_pwd").focus();
              }
              else if(json_result[0] == '1155')
              {
                // alert('Nice try! Try with different Fingerprint :)');
                var gold_alert = 'Nice try! You got '+json_result[1]+' out of 27 factors';
                alert(gold_alert);
              }
              else
              {
                alert('Try again (err 110)');
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
    }
    else if(login_type == 'password')
    {
      var email_val = $("#email").val();
      var password_val = $("#pwd").val();

      var fp = new Fingerprint2();
            var ips = document.getElementById("ip").innerHTML.split('.');
      fp.get(function(result, components,a,b) {
          var strings = '';

          for (var property in components) {
            strings = strings + '!@#' + components[property]['value'];
          }

          for (var ip in ips) {
             strings = strings + '!@#' + ips[ip];
          }
          var ttt = strings.split('!@#'); // array 형태로 변환
          var ddd = ttt.shift(); // 첫번째 원소 제거
          $.ajax({
            type : "POST",
            data : {
              email : email_val,
              final_fp : result,
              password : password_val,
              datas : JSON.stringify(ttt) // json 형태로 변환
            },
            url : "lib/chk_pwd.php",
            success: function(result)
            {
              if(result == '2211')
              {
                alert('This email address does not exist');
              }
              else if(result == '2221')
              {
                alert('Welcome');
                location.href = 'index.php';
              }
              else if(result == '2232')
              {
                alert('Try again');
              }
              else
              {
                alert('Try again(err 212)');
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
    else if(login_type == 'pin')
    {
      var email_val = $("#email").val();
      var pin_val = $("#pin_pwd").val();

      var fp = new Fingerprint2();
            var ips = document.getElementById("ip").innerHTML.split('.');

      fp.get(function(result, components,a,b) {

          var strings = '';

          for (var property in components) {
            strings = strings + '!@#' + components[property]['value'];
          }

          for (var ip in ips) {
             strings = strings + '!@#' + ips[ip];
          }

          var ttt = strings.split('!@#'); // array 형태로 변환
          var ddd = ttt.shift(); // 첫번째

          $.ajax({
            type : "POST",
            data : {
              email : email_val,
              pin : pin_val,
              final_fp : result,
              datas : JSON.stringify(ttt)
            },
            url : "lib/chk_pin.php",
            success: function(result)
            {
              if(result == '3111')
              {
                alert('This email address does not exist');
              }
              else if(result == '3112')
              {
                alert('Try again (err 312)');
              }
              else if(result == '3101')
              {
                alert('Welcome');
                location.href = 'index.php';
              }
              else if(result == '3323')
              {
                alert('Nice Try :)');
                history.back();
              }
              else if(result == '3233')
              {
                alert('PIN login failed. Please enter password');
                $("#login_type").val("password");
                $("#pwd_label").removeClass("hidden");
                $("#pwd").removeClass("hidden");
                $("#pin_label").addClass("hidden");
                $("#pin_pwd").addClass("hidden");
                $("#pwd").focus();
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

  });

</script>
