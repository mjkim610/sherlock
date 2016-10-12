<?php
if (session_status() == PHP_SESSION_NONE) session_start();

session_destroy();
$_SESSION = array();

echo "<script>
location.href='../index.php';
</script>";
?>
