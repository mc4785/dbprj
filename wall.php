<?php
    session_start();

    if($_SESSION['uname'] == null) {
        header("location:logout.php");
    }
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">	
    
    <!-- Bootstrap core CSS -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css" rel="stylesheet">
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
        include("events.php");
    ?>
    <div class="container">
        <div class="row">
        <div class="column">
        <div class="col-md-4">
    </div>
    <div class="col-md-7">
        <section>
            <?php
                include("post.inc.php");
            ?>
        </section>
        <section>
            <?php
                include("fetchmypost.inc.php");
            ?>
        </section>
    </div>
<div class="col-md-5">
</div>
        </div>
    </div>

</body>
</html>
