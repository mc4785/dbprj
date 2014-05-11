<?php
	session_start();
	if ($_SESSION['uname']==null) || empty($_GET['reqname'])) {
		header("location: friends.php");
	} else {
		include("db_connect.inc.php");
		$query = "insert into Friends(uname, funame, ts_sel) values ('{$_SESSION['uname']}', '{$_GET['reqname']}', now())";
		echo $query;
		$result = mysql_query($query, $connect) or die("Failed.");
		header("location: friendsadd.php");
	}
?>
