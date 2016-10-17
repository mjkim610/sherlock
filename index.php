<?php
    if (session_status() == PHP_SESSION_NONE) session_start();
    require_once "lib/head.php";
?>

<!-- 서비스 소개 -->
<!-- <div class="container-fluid top-part" id="service"> -->
<div class="container-fluid tran-light-gray" id="service">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
            <h2>What is Sherlock?</h2><br>
            <span style="font-size:1.1em;">Sherlock is a password-free authentication system. Sherlock utilizes browser fingerprinting to authenticate users.</span><br>
        </div>
      </div>
    </div>
</div>

<div class="container-fluid tran-gray" id="service">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                Let's try Sherlock
            </div> 
            <div class="col-sm-3 col-sm-offset-3">
                <div class="main_btn">
                <h2>Sign In</h2>  
                <p>Sign In with your Browser Fingerprint</p> 
                <a class="btn btn-primary btn-service" href="login.php">Sign In</a>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="main_btn">
                <h2>Sign Up</h2>
                <p>Regist your Browser Fingerprint</p>
                <a class="btn btn-danger btn-service" href="signup.php">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 
<div class="cont_forms" >
    <div class="cont_img_back_">
    <img src="https://images.unsplash.com/42/U7Fc1sy5SCUDIu4tlJY3_NY_by_PhilippHenzler_philmotion.de.jpg?ixlib=rb-0.3.5&q=50&fm=jpg&crop=entropy&s=7686972873678f32efaf2cd79671673d" alt="" />
    </div>
</div> -->

<!-- <div class="container-fluid top-part" id="service">
    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-sm-offset-2">
        asdasd
        </div>
        <div class="col-sm-3 col-sm-offset-2">
asdasdasd
        </div>
      </div>
    </div>
</div> -->
<!-- 서비스 단계 -->
<div class="container-fluid tran-light-gray" id="service">
    <div class="container">
        <div class="text-center">
            <h2>How Sherlock Works</h2>
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
                <p>Depending on the confidence level of the session, the user is logged in/prompted for PIN/prompted for password</p>
            </div>
        </div>
    </div>
</div>

<!-- 서비스 세부 -->
<div class="container-fluid text-center tran-gray" id="service">
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
<div class="container-fluid tran-light-gray" id="service">
    <div class="container">
        <div class="row">
            <h2>Get Your browser fingerprint</h2>
            <span id="components"></span>
            <button type="button" class="btn btn-lg btn-primary btn-block" id="btn">Get My Fingerprint</button>
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

        // $(window).scroll(function() {
        //     $(".slideanim").each(function() {
        //         var pos = $(this).offset().top;

        //         var winTop = $(window).scrollTop();
        //         if (pos < winTop + 600) {
        //             $(this).addClass("slide");
        //         }
        //     });
        // });
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
