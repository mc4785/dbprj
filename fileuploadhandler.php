<?php
session_start();

error_reporting(E_ALL | E_STRICT);
//require('server/php/UploadHandler.php');
//$upload_handler = new UploadHandler();

$re = print_r($_FILES, TRUE);
error_log( $re);
$re = print_r($_POST, TRUE);
error_log( $re);

//error_log( $_FILES['files']['tmp_name'][0]);
//if (move_uploaded_file($_FILES['files']['tmp_name'][0], '/private/var/tmp/test/'.$_FILES['files']['name'][0])) {
//    error_log("File is valid, and was successfully uploaded.\n");
//} else {
//    error_log("Possible file upload attack!\n");
//}

// Connect to server and select databse.
include("db_connect.inc.php");

if($_SESSION['uname']!=null){
    //error_log("uname=".$_SESSION['uname']);
    $create_diary_sql = "insert into Diary (uname, actid, lid, visible) values ('%s', %s, %s ,'%s')";
    $check_loc_sql = "select * from Location where lid = '%s'";
    $create_loc_sql = "insert into Location values ('%s','%s','%s','%s')";
    $create_note_sql = "insert into Note (did, ncontent) values (%d, '%s')";
    $create_img_sql = "insert into Image (did, icontent) values (%d, '%s')";

    // check location input
    if (isset($_POST['loc_id'])) {
        $_POST['loc_id'] = stripslashes($_POST['loc_id']);
        $_POST['loc_id'] = mysql_real_escape_string($_POST['loc_id']);
        $sql = sprintf($check_loc_sql, $_POST['loc_id']);
        $result = mysql_query($sql);
        if ($result) {
            $count = mysql_num_rows($result);
            if($count == 0) {
                $sql = sprintf($create_loc_sql, $_POST['loc_id'], $_POST['loc_name'], $_POST['loc_lat'], $_POST['loc_lon']);
                $result = mysql_query($sql);
                if($result) {
                    $lid = sprintf("'%s'", $_POST['loc_id']);
                } else {
                    error_log("insert location error: ".$sql);
                    error_log(mysql_error());
                    $lid = "NULL";
                }
            } else {
                $lid = sprintf("'%s'", $_POST['loc_id']);
            }
        } else {
            error_log("search loc error;".$sql);  
            error_log(mysql_error());  
        }
    } else {
        $lid = "NULL";    
    }

    // check activity input, need fix, but will have to modify DB, too lazy to do it...
    if (isset($_POST['activity'])) {
        // need fix hear, a diary can only associate with one activity?
        foreach ($_POST['activity'] as &$activity) {
            $act_id = sprintf("'%s'", $activity);
        }
    } else {
        $act_id = "NULL";    
    }


    $sql = sprintf($create_diary_sql, $_SESSION['uname'], $act_id, $lid, $_POST['dv']);
    error_log("diary SQL: ".$sql);
    $result = mysql_query($sql);
    if($result) {
        $did = mysql_insert_id();
        //error_log("did=$did");
        //error_log("tmp_name=$_FILES['files']['tmp_name'][0]");
        
        // To protect MySQL injection (more detail about MySQL injection)
        $mycomment = stripslashes($_POST['micropost']['content']);
        $sql = sprintf($create_note_sql, $did, $mycomment);
        $result = mysql_query($sql);
        if($result) {
            //error_log("note SQL SUCCESS ");  
        } else {
            error_log("note SQL FAIL ");
            error_log(mysql_error());
        }
            
        $im = file_get_contents($_FILES['files']['tmp_name'][0]);
        $imdata = base64_encode($im);
        $sql = sprintf($create_img_sql, $did, $imdata);
        //error_log("image SQL: ".$sql);
        $result = mysql_query($sql);
        if($result) {
            //error_log("image SQL SUCCESS ");  
        } else {
            error_log("image SQL FAIL ");
            error_log(mysql_error());
        }
    } else {
        error_log("diary SQL FAIL:".$sql);
        error_log(mysql_error());
    }
} else {
    error_log("session invalid");    
}
mysql_close($connect);

?>
