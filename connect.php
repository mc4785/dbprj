<?php session_start();?>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<?php
include("conn.php");
$id=$_POST['id'];
$pw=$_POST['pw'];

$sql="select * from Users where uname='$id'";
$result=mysql_query($sql);
$row=@mysql_fetch_row($result);
if($id!=null&&$pw!=null&&$row[1]==$id&&$row[2]==$pw)
{
$_SESSION['uname']=$id;
echo 'login successfully!';
echo '<meta http-equiv=REFRESH CONTENT=1;url=member.php>';
}
else
{
echo 'login unsuccessfully';
echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
}
?>