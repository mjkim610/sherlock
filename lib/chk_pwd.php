<?php
if (session_status() == PHP_SESSION_NONE) session_start();

require_once "function.php";
require_once "dbconn.php";
?>

<meta http-equiv="content-type" content="text/html;charset=utf-8">

<?php
if(isset($_POST['tmp']) && $_POST['tmp'] == 'sp_tmp')
{
	$num = test_input($_POST['num']);
	$no = test_input($_POST['no']);
	$pwd = test_input($_POST['pwd']);

	// if($no === 'ans') // 답글 쓰기
	// {
	// 	$sql = "SELECT * FROM qna WHERE num = $num";
	// 	$result = mysqli_query($conn, $sql);

	// 	if (mysqli_num_rows($result) == 1)
	// 	{
	// 		// output data of each row
	// 		$row = mysqli_fetch_assoc($result);
	// 	}
	// 	else
	// 	{
	// 		goback_with_alert('잘못된 접근입니다. (err 003)');
	// 		exit();
	// 	}

	// 	$tmp = hash('sha256', $pwd, false);
	// 	$sercet = $row['secret'];

	// 	if($sercet === 'y' && $tmp === $row['password'])
	// 	{
	// 		$_SESSION['grant'] = $tmp;
	// 		$href = '../qna.php?action=write_ans&num='.$num;
	// 		echo "<script type='text/javascript'>";
	// 		echo "location.href = '" . $href . "';";
	// 		echo "</script>";
	// 		exit();
	// 	}
	// 	else
	// 	{
	// 		goback_with_alert('비밀번호가 틀렸습니다.');
	// 		exit();
	// 	}
	// }
	
	// 자기 질문 보기
	$sql = "SELECT * FROM qna WHERE num = $num";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) == 1)
	{
		// output data of each row
		$row = mysqli_fetch_assoc($result);
	}
	else
	{
		goback_with_alert('잘못된 접근입니다. (err 003)');
		exit();
	}

	$tmp = hash('sha256', $pwd, false);
	if($row['password'] === $tmp)
	{
		$_SESSION['grant'] = $tmp;
		$href = '../qna.php?action=read&num='.$num.'&no='.$no;
		echo "<script type='text/javascript'>";
		echo "location.href = '" . $href . "';";
		echo "</script>";
		exit();
	}
	else
	{
		goback_with_alert('비밀번호가 틀렸습니다.');
		exit();
	}
	
}

if(!isset($_GET['num']) || !isset($_GET['no']))
{
	goback_with_alert('잘못된 접근입니다. (err 007)');
	exit();
}

$num = test_input($_GET['num']);
$no = test_input($_GET['no']);
?>

<div class="container-fluid text-center">
	<div class="container">
		<div class="row">
			<form method="post" action="lib/chk_pwd.php">
				<span style="font-weight:700;">비밀번호를 입력하세요</span><br><br>
				<input class="form-control" type="password" name="pwd" id="pwd" style="max-width:300px;margin:0 auto;"><br>
				<input type="hidden" name="num" id="num" value="<?=$num?>">
				<input type="hidden" name="no" id="no" value="<?=$no?>">
				<input type="hidden" name="tmp" id="tmp" value="sp_tmp">
				<button class="btn btn-primary btn_form">취소</button>&nbsp;&nbsp;&nbsp;
				<input class="btn btn-primary btn_form" type="submit" name="form_submit" id="form_submit" value="확인">
			</form>
		</div>
	</div>
</div>
