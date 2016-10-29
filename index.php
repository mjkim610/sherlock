<?php
    if (session_status() == PHP_SESSION_NONE) session_start();
    require_once "lib/head.php";
    require_once "lib/get_ip.php";
?>
<?php
if(isset($_SESSION['gold']) && $_SESSION['gold'] == 'got_it')
{
    echo '<div class="container-fluid text-center tran-light-gray">';
    echo '    <div class="container">';
    echo '      <div class="row">';
    echo '        <div class="col-sm-12" style="font-size: 30px;">';
    echo '            Congratulation! Send Email to jhoney7374@gmail.com with Secret Number 920918';
    echo '        </div>';
    echo '      </div>';
    echo '    </div>';
    echo '</div>';
}
?>
<!-- 서비스 소개 -->
<!-- <div class="container-fluid top-part"> -->
<div class="container-fluid text-center tran-light-gray">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
            <h2>What is Sherlock?</h2><br>
            <span style="font-size:1.1em;">Sherlock is a password-free authentication system. Sherlock utilizes browser fingerprinting to authenticate users.</span><br>
        </div>
      </div>
    </div>
</div>

<div class="container-fluid tran-gray">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h2>Let's try Sherlock</h2>
            </div>
            <?php
                if(isset($_SESSION['is_login']) && $_SESSION['is_login'] === true) {
                    echo '<div class="col-sm-4">';
                        echo '<div class="main_btn">';
                        echo '<h2>Play</h2>';
                        echo '<p>Grab the Gold!</p>';
                        echo '<img class="gold-img" src="img/gold.png" alt="gold"/>';
                        echo '<a class="btn btn-warning btn-service" href="gold_event.php">Play</a>';
                        echo '</div>';
                    echo '</div>';
                }
                else {
                    echo '<div class="col-sm-4">';
                    echo '<div class="main_btn">';
                    echo '<h2>Sign In</h2>';
                    echo '<p>Sign In with your Browser Fingerprint</p>';
                    echo '<a class="btn btn-primary btn-service" href="login.php">Sign In</a>';
                    echo '</div>';
                    echo '</div>';

                    echo '<div class="col-sm-4">';
                    echo '<div class="main_btn">';
                    echo '<h2>Sign Up</h2>';
                    echo '<p>Register your Browser Fingerprint</p>';
                    echo '<a class="btn btn-danger btn-service" href="signup.php">Sign Up</a>';
                    echo '</div>';
                    echo '</div>';
                }
            ?>

        </div>
    </div>
</div>

<!-- 서비스 단계 -->
<div class="container-fluid tran-light-gray">
    <div class="container">
        <div class="text-center">
            <h2>How Sherlock Works</h2><br>
        </div>
        <div class="row service_step">

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
                <p>Depending on the confidence level of the session, the user is logged in/prompted for PIN/prompted for password.</p>
            </div>
        </div>
    </div>
</div>

<!-- 서비스 세부 -->
<div class="container-fluid text-center tran-gray">
    <div class="container">
        <div class="row">
            <h2>Our Contribution</h2>
            <br>
            <b>Security:</b> Security is unchanged.<br />
            <b>Usability:</b> Usability is improved.<br />
        </div>
    </div>
</div>

<!-- 핑거프린트 테스트 -->
<div class="container-fluid tran-light-gray">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="text-center">Get Your browser fingerprint</h2><br>
                <span id="components"></span>
                <button type="button" class="btn btn-lg btn-primary btn-block" id="btn">Get My Fingerprint</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid tran-gray">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center team-info">
                    <h2>Team 협업실 B01</h2>
                    <p class="team-sub">Team 협업실 B01 for Yonsei univ, Software Capstone Project.</p>
            </div>
            <div class="col-sm-12">
                <div class="col-sm-4">
                    <div class="team-card">
                        <div class="profile-card">
                      <header>
                        <!-- here’s the avatar -->
                        <a target="_blank" href="mailto:mjkim610@gmail.com?Subject=Regarding%20Sherlock">
                          <img src="img/team/1.jpg" class="hoverZoomLink">
                        </a>

                        <!-- the username -->
                        <h1>김명종</h1>

                        <!-- and role or location -->
                        <h2>Developer</h2>
                      </header>

                      <!-- bit of a bio; who are you? -->
                      <div class="profile-bio">
                        <p>
                          Yonsei Univ
                        </p>
                        <p>
                          Computer Science. 4
                        </p>
                        <p>
                          mjkim610@gmail.com
                        </p>
                      </div>
                      <!-- some social links to show off -->
                      <ul class="profile-social-links">
                        <li>
                          <a target="_blank" href="https://www.facebook.com/creativedonut">
                            <i class="fa fa-facebook"></i>
                          </a>
                        </li>
                        <li>
                          <a target="_blank" href="https://github.com/mjkim610">
                            <i class="fa fa-github"></i>
                          </a>
                        </li>
                        <li>
                          <a target="_blank" href="mailto:mjkim610@gmail.com?Subject=Regarding%20Sherlock">
                            <i class="fa fa-envelope"></i>
                          </a>
                        </li>

                      </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-card">
                        <div class="profile-card">
                      <header>
                        <!-- here’s the avatar -->
                        <a target="_blank" href="mailto:jhoney7374@gmail.com?Subject=Regarding%20Sherlock">
                          <img src="img/team/2.jpg" class="hoverZoomLink">
                        </a>

                        <!-- the username -->
                        <h1>김정헌</h1>

                        <!-- and role or location -->
                        <h2>Developer</h2>
                      </header>

                      <!-- bit of a bio; who are you? -->
                      <div class="profile-bio">
                        <p>
                          Yonsei Univ
                        </p>
                        <p>
                          Computer Science. 4
                        </p>
                        <p>
                          jhoney7374@gmail.com
                        </p>
                      </div>
                      <!-- some social links to show off -->
                      <ul class="profile-social-links">
                        <li>
                          <a target="_blank" href="https://www.facebook.com/honey.Rnf">
                            <i class="fa fa-facebook"></i>
                          </a>
                        </li>
                        <li>
                          <a target="_blank" href="https://github.com/restforest">
                            <i class="fa fa-github"></i>
                          </a>
                        </li>
                        <li>
                          <a target="_blank" href="mailto:jhoney7374@gmail.com?Subject=Regarding%20Sherlock">
                            <i class="fa fa-envelope"></i>
                          </a>
                        </li>

                      </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-card">
                        <div class="profile-card">
                      <header>
                        <!-- here’s the avatar -->
                        <a target="_blank" href="mailto:sullamij@naver.com?Subject=Regarding%20Sherlock">
                          <img src="img/team/3.jpg" class="hoverZoomLink">
                        </a>

                        <!-- the username -->
                        <h1>정술람</h1>

                        <!-- and role or location -->
                        <h2>Developer</h2>
                      </header>

                      <!-- bit of a bio; who are you? -->
                      <div class="profile-bio">
                        <p>
                          Yonsei Univ
                        </p>
                        <p>
                          Theo / CS. 4
                        </p>
                        <p>
                          sullamij@naver.com
                        </p>
                      </div>
                      <!-- some social links to show off -->
                      <ul class="profile-social-links">
                        <li>
                          <a target="_blank" href="#">
                            <i class="fa fa-facebook"></i>
                          </a>
                        </li>
                        <li>
                          <a target="_blank" href="https://github.com/sullamij">
                            <i class="fa fa-github"></i>
                          </a>
                        </li>
                        <li>
                          <a target="_blank" href="mailto:sullamij@naver.com?Subject=Regarding%20Sherlock">
                            <i class="fa fa-envelope"></i>
                          </a>
                        </li>

                      </ul>
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
    $(document).ready(function() {
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
                }, 900, function() {

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            } // End if
        });
    })
</script>

<script>
    $("#btn").on("click", function () {
        var d1 = new Date();
        var fp = new Fingerprint2();
        var string = '';
        var i = 0;
        fp.get(function(result, components,a,b) {
            var d2 = new Date();
            var timeString = "Time took to calculate the fingerprint: " + (d2 - d1) + "ms";
            if (typeof window.console !== "undefined") {
                console.log(result);
                console.log(timeString);
                console.log(a);
                console.log(b);
            }

            var output = '';
            for (var property in components) {
                output += property + ': <b>' + components[property]['key'] + '</b><br>' + String(components[property]['value']).substring(0, 1248)+'<br><br>';
            }

            $("#fp").text(result);
            $("#time").text(timeString);
            $("#components").html(output);
        });
    });
</script>
