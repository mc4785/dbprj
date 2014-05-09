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

.diary-note, .comment-btn, .like-btn {
    margin-left: 5px;
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

    $fetch_diary_sql = "CALL listDiaryByFriendsWithLikes('%s')";
    $sql = sprintf($fetch_diary_sql, $_SESSION['uname']);
    //error_log("fetch diary SQL: ".$sql);
   
    //$s = "";  
    $result = mysql_query($sql);
    if ($result) {
        $diary_item_format = "<div id='d%d' href='#top' class='diary-item'><div class='row box list-group-item'>%s%s</div>%s%s</div>";
        $diary_img_format = "<div class='row nopadding'><img class='col-lg-12 img-rounded' src='data:image/jpeg;base64, %s'/></div>";
        $diary_note_format = "<div class='row diary-note'><dl><dd>%s</dd></dl></div>";
        $comment_btn = "<span><a class='comment-btn'>Comment</a></span>";
        $like_cnt_format = "<span class='like-counts'><span><i class='glyphicon glyphicon-thumbs-up'></i></span><span id='ld%d'>%d</span></span>";
        $diary_tool_format = "<div class='row diary-tool'><span><a class='like-btn' href=\"#\">Like</a></span>%s%s</div>";
        $comment_holder_format = "<div id='dch%d' class='row'></div>";

        while ($diary = mysql_fetch_assoc($result)) {
            $diary_img = ($diary['iid'] === NULL) ? "" : sprintf($diary_img_format, $diary['icontent']);
            $diary_note = sprintf($diary_note_format, $diary['ncontent']);

            $like_cnt = sprintf($like_cnt_format, $diary['did'], $diary['cnt']);
            $diary_tool = sprintf($diary_tool_format, $comment_btn, $like_cnt);
            $comment_holder = sprintf($comment_holder_format, $diary['did']);
            $diary_item = sprintf($diary_item_format, $diary['did'], $diary_img, $diary_note, $diary_tool, $comment_holder);
            //$s = $diary_item.$s;
            echo $diary_item;
        }
    }
    //echo $s;
    mysql_free_result($result);
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
