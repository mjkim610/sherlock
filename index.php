<?php
    if (session_status() == PHP_SESSION_NONE) session_start();
    require_once "lib/head.php";
?>

<!-- 서비스 소개 -->
<div class="container-fluid bg-grey" id="service">
    <h2>What is Sherlock?</h2><br>
    <span style="font-size:1.1em;">Sherlock is a usable authentication system using browser fingerprinting.</span><br>
</div>

<!-- 서비스 단계 -->
<div class="container-fluid text-center">
    <h2>How Sherlock Works</h2>
    <br>
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

    </div>
</div>

<!-- 서비스 세부 -->
<div class="container-fluid text-center bg-grey">
    <h2>Our Contribution</h2>
    <br>
    <b>Security:</b> Security is unchanged.<br />
    <b>Usability:</b> Usability is improved.<br />
</div>

<!-- 핑거프린트 테스트 -->
<div class="container-fluid" id="service">
    <h2>Your browser fingerprint</h2>
    <p><code id="time"></code></p>
    <span id="components"></span>
    <button type="button" id="btn">Get my fingerprint</button>
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

        $(window).scroll(function() {
            $(".slideanim").each(function() {
                var pos = $(this).offset().top;

                var winTop = $(window).scrollTop();
                if (pos < winTop + 600) {
                    $(this).addClass("slide");
                }
            });
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
                output += property + '. key : ' + components[property]['key'] + '<br>  &nbsp&nbsp value : ' + components[property]['value']+'<br>';
            }

            $("#fp").text(result);
            $("#time").text(timeString);
            $("#components").html(output);
        });
    });
</script>
