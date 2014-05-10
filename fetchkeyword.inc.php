<style>

.diary-tool {
    margin-bottom: 5px;
    margin-top: 5px;
}

.diary-item:hover > div {
    background-color: #eee;
}

.diary-item {
    margin-bottom: 50px;
}

.diary-note{
    margin: 5px 0px 10px 0px;    
}

.comment-btn, .like-btn {
    margin-left: 5px;
}
.diary-info {
    margin: 0px;
}

.diary-author {
    margin-bottom: 11px;    
    padding-left: 0px;
    font-weight: bold;
    font-size: 16px;
}

.like-counts {
    position: absolute;
    right: 0;    
}

</style>

<div id="diaries">
<?php
    
// Connect to server and select databse.
include("db_connect.inc.php");

    
if($_SESSION['uname']!=null){

    $discard_patterns = array('/ing$/', '/ed$/', '/s$/', '/e$/');
    $kw = trim($_POST["keyword"]);
    $kw = preg_replace($discard_patterns, '', strtolower($kw));
    $kw = stripslashes($kw);
    $kw = mysql_real_escape_string($kw);
    $fetch_diary_sql = "CALL searchDiaryByActKey('%s', '%s')";
    $sql = sprintf($fetch_diary_sql, $_SESSION['uname'], $kw.'%');
    //error_log("fetch diary SQL: ".$sql);
   
    //$s = "";  
    $result = mysql_query($sql);
    if ($result) {
        $diary_item_format = "<div id='d%d' href='#top' class='diary-item'><div class='row box list-group-item'>%s%s%s%s</div>%s%s</div>";
        $diary_author_format = "<div class='diary-author col-lg-12'><a><span>%s</span></a></div>";
        $diary_img_format = "<div class='row nopadding'><img class='col-lg-12 img-rounded' src='data:image/jpeg;base64, %s'/></div>";
        $diary_note_format = "<div class='row diary-note'><span>%s</span></div>";
        $act_info_format = "<span><a href='actpage.php?actid=%s'>%s</a></span>";
        $loc_info_format = "<span style='color:#898f9c;'>&nbspat&nbsp</span><span><a href='locationpage.php?lid=%s'>%s</a></span>";
        $diary_info_format = "<div class='row diary-info'>%s%s</div>";
        $comment_btn = "<span><a class='comment-btn'>Comment</a></span>";
        $like_cnt_format = "<span class='like-counts'><span><i class='glyphicon glyphicon-thumbs-up'></i></span><span id='ld%d'>%d</span></span>";
        $diary_tool_format = "<div class='row diary-tool'><span><a class='like-btn' href=\"#\">Like</a></span>%s%s</div>";
        $comment_holder_format = "<div id='dch%d' class='row'></div>";

        while ($diary = mysql_fetch_assoc($result)) {
            $diary_author = sprintf($diary_author_format, $diary['uname']);
            $diary_img = ($diary['iid'] === NULL) ? "" : sprintf($diary_img_format, $diary['icontent']);
            $diary_note = sprintf($diary_note_format, $diary['ncontent']);

            $act_info = ($diary['actid'] === NULL) ? "" : sprintf($act_info_format, $diary['actid'], $diary['aname']);
            $loc_info = ($diary['lid'] === NULL) ? "" : sprintf($loc_info_format, $diary['lid'], $diary['lname']);
            $diary_info = ($diary['actid'] === NULL && $diary['lid'] === NULL) ? "" : sprintf($diary_info_format, $act_info, $loc_info);

            $like_cnt = sprintf($like_cnt_format, $diary['did'], $diary['cnt']);
            $diary_tool = sprintf($diary_tool_format, $comment_btn, $like_cnt);
            $comment_holder = sprintf($comment_holder_format, $diary['did']);
            $diary_item = sprintf($diary_item_format, $diary['did'], $diary_author, $diary_img, $diary_note, $diary_info, $diary_tool, $comment_holder);
            //error_log($diary_item);
            echo $diary_item;
        }
        mysql_free_result($result);
    } else {
        error_log("search diary error;".$sql); 
        error_log(mysql_error());   
        echo mysql_error();   
    }
    //echo $s;
}
    
mysql_close($connect);
?>
</div>

<script>
$(".like-btn").click(function(){
    var did = $(this).closest(".diary-item").attr('id').substring(1);
    $.getJSON( "likediary.php", { "did": did }, function(data) {
        if (data["result"] == "success") {
            $("#ld"+data["did"]).html(data["cnt"])
        }
    });
    return false;
});

$(".comment-btn").click(function(){
    var did = $(this).closest(".diary-item").attr('id').substring(1);
    $.getJSON( "getcomments.php", { "did": did }, function(data) {
        if (data["result"] == "success") {
            $("#dch"+data["did"]).append(data["cmt_form"]).append(data["comments"]);
            $("#dch"+data["did"]).find("form").submit(function(){
                $.post( "addcomment.php", $(this).serialize(), function(data){
                    $("#dch"+data["did"]).find("ul").append(data["comment"])
                    return false;
                }, "json"); 
                $(this)[0].reset();   
                return false;
            });
        }
        return false;
    });
    return false;
});
</script>
