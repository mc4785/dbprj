<?php session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("db_connect.inc.php");
echo '<a href="logout.php">log out</a> <br><br>';

if($_SESSION['uname']!=null)
{
echo '<a href="signup.php">sign up</a> ';
echo '<a href="update.php">revise</a> ';
echo '<a href="delete.php">delete</a> <br><br>';

$sql="select * from Users";
$result=mysql_query($sql);
while($row=mysql_fetch_row($result))
{
echo "$row[0] - name: $row[1],"."phone: $row[3], address: $row[4], comment: $row[5]<br>";
}
}
else{
echo 'you have no rights to browse this website!';
echo '<meta http-equiv=REFRESH CONTENT=2;url=login.php>';
}
?>