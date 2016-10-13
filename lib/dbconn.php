<?php //데이터 베이스 연결
$servername = "localhost";
$username = "root";
if($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === 'localhost')
{
	$password = "202ghkdlxld!";
}
else
{
	$password = "wjdgjs1";
}
$dbname = "sherlock";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// mysql_query("SET NAMES utf8");
?>
