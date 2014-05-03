<?php
    session_start();
    
    if($_SESSION['username'] == null) {
        header("location:logout.php");
    }
    ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
@@ -13,18 +20,40 @@
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

<style>
body {
    padding-top: 100px;
}
.btn {
    margin-top: 10px;
}
</style>

<title>Wildbook</title>
</head>

<body>

<?php
    include("header.inc.php");
    ?>
<div class="container">

<div class="row">
<div class="col-md-7">
<section>
<form action="postdiary.php" class="new_micropost" id="new_micropost" method="post">
<textarea id="micropost_content" name="micropost[content]" placeholder="Give comment ..." style="width:100%">
</textarea>
<input class="btn btn-large btn-primary pull-right" name="commit" type="submit" value="POST" />
</form>
</section>
</div>
<div class="col-md-5">
<?php
    // for each post
    //<ol class="microposts"></ol>
    ?>
</div>
</div>
</div>


</body>
</html>
