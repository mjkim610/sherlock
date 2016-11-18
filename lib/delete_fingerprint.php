<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require_once "dbconn.php";

if(isset($_SESSION['is_login']) && isset($_SESSION['user_id']))
{
	$user_id = $_SESSION['user_id'];

  if(!isset($_POST['fp_id']))
  {
    echo '8811';
		exit();
  }

  $input_fp_id = $_POST['fp_id'];

  $sql = "SELECT * FROM fingerprint WHERE id = '$input_fp_id'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) != 1)
  {
		echo '8776';
		exit();
	}

  $fp = mysqli_fetch_assoc($result);

  if($user_id != $fp['user_id'])
  {
    echo '8777';
		exit();
  }

  $sql = "DELETE FROM fingerprint WHERE id = '$input_fp_id'";

  if ($conn->query($sql) === TRUE) {
      echo "8885";
      exit();
  }
  else {
      echo "8879";
      exit();
  }
}
else
{
  echo "8179";
  exit();
}
