<?php
if (session_status() == PHP_SESSION_NONE) session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sherlock</title>
  <link rel="shortcut icon" href="img/favicon.png">
  <meta http-equiv="content-type" content="text/html;charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta property="og:type" content="website">
  <meta property="og:title" content="Sherlock">
  <meta property="og:description" content="Browser Fingerprint Authentication System">
  <!-- <meta property="og:image" content="http://.jpg"> -->
  <!-- <meta property="og:url" content="http://.kr/"> -->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="css/style.css" rel="stylesheet" media="screen">
  <link href="css/agency.css" rel="stylesheet" media="screen">
  <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <script src="http://code.jquery.com/jquery.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/fingerprint2.js"></script>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Sherlock</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
        <?php
          if(isset($_SESSION['is_login']) && $_SESSION['is_login'] === true)
          {
            echo '<li><a href="lib/logout.php">Logout</a></li>';
            echo '<li><a href="lib/mypage.php">My Page</a></li>';
          }
          else
          {
            echo '<li><a href="lib/login.php">Log In</a></li>';
            echo '<li><a href="lib/signup.php">Sign Up</a></li>';
          }
         ?>

        </ul>
      </div>
    </div>
  </nav>

  <!-- 핑거프린트 테스트 -->
  <div class="container-fluid" id="service">
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <p>Your browser fingerprint: <strong id="fp"></strong></p>
          <p><code id="time"></code></p>
          <span id="components"></span>
          <button type="button" id="btn">Get my fingerprint</button>
        </div>
      </div>
    </div>
  </div>

  <!-- 서비스 소개 -->
  <div class="container-fluid bg-grey" id="service">
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <h2>What is Sherlock?</h2><br>
          <span style="font-size:1.1em;">Sherlock is a usable authentication system using browser fingerprinting.</span><br>
        </div>
      </div>
    </div>
  </div>

  <!-- 서비스 단계 -->
  <div class="container-fluid text-center">
    <h2>How Sherlock Works</h2>
    <br>
    <div class="container">
      <div class="row slideanim service_step">
        <div class="col-sm-4">
          <h4>1. Browser fingerprinting</h4>
          <p>JavaScript calculates the browser fingerprint of the session.</p>
        </div>
        <div class="col-sm-4">
          <h4>2. Authentication</h4>
          <p>User-input username is checked against the MySQL database.</p>
        </div>
        <div class="col-sm-4">
          <h4>3. Different levels of authentication</h4>
          <p>Depending on the confidence level of the session, the user is logged in/prompted for PIN/prompted for password</p>
        </div>
        <div class="col-sm-4">
          <h4>4. Number 4</h4>
          <p>Number 4</p>
        </div>
        <div class="col-sm-4">
          <h4>5. Number 5</h4>
          <p>Number 5</p>
        </div>
      </div>
    </div>
  </div>

  <!-- 서비스 세부 -->
  <div class="container-fluid text-center bg-grey">
    <h2>Our Contribution</h2>
    <!-- <h4>What we offer</h4> -->
    <br>
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          Security: Security is unchanged.<br />
          Usability: Usability is improved.<br />
        </div>
      </div>
    </div>
  </div>

<?php
require_once "lib/footer.php"
?>

  <script>
    $(document).ready(function(){
      // Add smooth scrolling to all links in navbar + footer link
      $(".navbar a, footer a[href='#']").on('click', function(event) {
        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
          // Prevent default anchor click behavior
          event.preventDefault();

          // Store hash
          var hash = this.hash;

          // Using jQuery's animate() method to add smooth page scroll
          // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
          $('html, body').animate({
            scrollTop: $(hash).offset().top
          }, 900, function(){

            // Add hash (#) to URL when done scrolling (default click behavior)
            window.location.hash = hash;
          });
        } // End if
      });

      $(window).scroll(function() {
        $(".slideanim").each(function(){
          var pos = $(this).offset().top;

          var winTop = $(window).scrollTop();
            if (pos < winTop + 600) {
              $(this).addClass("slide");
            }
        });
      });
    })
  </script>

</body>
</html>
<script>
$("#btn").on("click", function () {
  var d1 = new Date();
  var fp = new Fingerprint2();
  var string = '';
  var i = 0;
  fp.get(function(result, components) {
    var d2 = new Date();
    var timeString = "Time took to calculate the fingerprint: " + (d2 - d1) + "ms";
    if(typeof window.console !== "undefined") {
      console.log(timeString);
      console.log(result);
      console.log(components);
    }
    var output = '';
    for (var property in components) {
      output += property + '. key : ' + components[property]['key'] + '<br>  &nbsp&nbsp value : ' + components[property]['value']+'<br>';
    }
    $("#fp").text(result);
    $("#time").text(timeString);
    $("#components").html(output);
  });
});
</script>
