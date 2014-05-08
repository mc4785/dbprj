<div id="diaries">
<?php
    
// Connect to server and select databse.
include("db_connect.inc.php");

    
if($_SESSION['uname']!=null){

    $fetch_diary_sql = "CALL listDiaryByUser('%s')";
    $sql = sprintf($fetch_diary_sql, $_SESSION['uname']);
    
    $result = mysql_query($sql);
    if ($result) {
        $diary_a_format = "<a id='d%d' href='#top' class='property_item'><div class='row box list-group-item'>%s%s</div></a>";
        $diary_img_format = "<div class='col-md-12 nopadding'><img class='col-lg-12 img-rounded' src='data:image/jpeg;base64, %s'/></div>";
        $diary_note_format = "<div><dl><dd>%s</dd></dl></div>";
        
        while ($diary = mysql_fetch_array($result)) {
            $diary_img = ($diary[9] === NULL) ? "" : sprintf($diary_img_format, $diary[11]);
            $diary_note = sprintf($diary_note_format, $diary[8]);
            $diary_a = sprintf($diary_a_format, $diary[0], $diary_img, $diary_note);
            echo $diary_a;
        }
    }
    mysql_free_result($result);
}
    
mysql_close($connect);
?>
</div>
