<!DOCTYPE html>
<html>
<head>
<link type="text/css" rel="stylesheet" href="./static/main.css" />
<title>Adding new friends</title>
</head>
<body>
	<?php
		session_start();
		if ($_SESSION['uname']==null) {
			header("location: logout.php");
		} else {

			include("db_connect.inc.php");

			include("feeds.php");

			echo "<form method='post'>";
			echo "<label>User Name</label>
			<input type='search' name='search'>";
			echo "<input type='submit' value='Search'>";
			echo "</form>";

			if (!empty($_POST['search'])) {
				$sname = mysql_real_escape_string($_POST['search']);
				$query = "select uname from Users where uname like '%{$sname}%'";

				// echo $query;
				//echo $query;
				$result = mysql_query($query, $connect) or
					die("Failed.");
				echo "<ul>";
				while ($user_row = mysql_fetch_array($result, MYSQL_ASSOC)) {
					$query = "select * from Users
						where uname = '{$user_row['uname']}' and uname not in
				(select funame as uname from Friends
				where uname = '{$_SESSION['uname']}' and funame = '{$user_row['uname']}'
				union 
				select funame as uname from Friends
				where uname = '{$_SESSION['uname']}' and funame ='{$user_row['uname']}'
				)";
					$appRes = mysql_query($query, $connect) or
						die("appRes Failed.");
					$row = mysql_fetch_array($appRes);
					if(!empty($row))
					{
					echo "<li>{$row['uname']} ";
					echo "<a href='friendRequest.php?reqname={$row['uname']}'>
						add</a>";
					
					echo "</li>";
					}
				}
				echo "</ul>";
			}
		}
	?>
	<br>
	<form action='profile.php'>
		<input type="submit" value="Back to home page">
	</form>
</body>
</html>		
