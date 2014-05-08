<?php
session_start();
error_log("--------test 2-----------");

error_reporting(E_ALL | E_STRICT);

// Connect to server and select databse.
include("db_connect.inc.php");

if($_SESSION['uname']!=null){
    $create_diary_sql = "insert into Diary (uname) values ('%s')";
    $create_note_sql = "insert into Note (did, ncontent) values (%d, '%s')";
    $create_img_sql = "insert into Image (did, icontent) values (%d, '%s')";

    $sql = sprintf($create_diary_sql, $_SESSION['uname']);
    $result = mysql_query($sql);
    if($result) {
        $did = mysql_insert_id();
        
        // To protect MySQL injection (more detail about MySQL injection)
        $mycomment = stripslashes($_POST['micropost']['content']);
        $sql = sprintf($create_note_sql, $did, $mycomment);
        $result = mysql_query($sql);
        if($result) {
            //error_log("note SQL SUCCESS ");
        } else {
            //error_log("note SQL FAIL ");
        }
            
        $im = file_get_contents($_FILES['files']['tmp_name'][0]);
        $imdata = base64_encode($im);
        $sql = sprintf($create_img_sql, $did, $imdata);
        $result = mysql_query($sql);
        if($result) {
            //error_log("image SQL SUCCESS ");
        } else {
            //error_log("image SQL FAIL ");
        }
    } else {
        //error_log("diary SQL FAIL ");
    }
} else {
    //error_log("session invalid");
}
mysql_close($connect);

?>
