<?php
    if (session_status() == PHP_SESSION_NONE) session_start();
    require_once "lib/dbconn.php";
    require_once "lib/head.php";
?>
<!-- 로그인 폼 -->
<div class="container-fluid tran-light-gray" id="mypage">
    <div class="container">
        <div class="row">

            <div class="col-sm-5">
                <h4>1. Browser fingerprinting</h4>
                <p>JavaScript calculates the browser fingerprint of the session.</p>
            </div>

            <div class="col-sm-5 col-sm-offset-2">
                <h4>2. Authentication</h4>
                <p>User-input username is checked against the MySQL database.</p>
            </div>

        </div>
    </div>
</div>

<?php
	require_once "lib/footer.php"
?>