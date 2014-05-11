<html>
<head>
<link type="text/css" rel="stylesheet" href="./static/main.css" />
<title>Friends</title>
</head>
<body>
<?php
    session_start();
    if ($_SESSION['uname']==null) {
        header("location: logout.php");
    } else {
        
        include("db_connect.inc.php");
        
        include("feeds.php");
        
        echo "<br />";
        echo "<h2><center>Friends</center> </h2>";
       
        
        $query = "SELECT uname from Friends join Users on Friends.uname = Users.uname where uname = '{$_SESSION['uname']}'";
        //echo $query;
        $result = @ mysql_query($query, $connect) or
        die("Can't query table friendship.");
        
        echo "<table class='post'>";
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            echo "<tr><td><a href='friendProfile.php?uname={$row['funame']}'>
            {$row['uname']}</a></td>&nbsp;&nbsp;&nbsp;";
            echo "<td>Pinboards</td>";
           
            echo "</a></tr>";
            $query_1 = "select * from Users natural join Diary natural join Activity natual join Location where uname = '{$row['uname']}'";
            $result_1 = mysql_query($query_1, $connect) or
            die("Can't query table pinboard.");
            
            // echo "<ul>";
            while ($row_1 = mysql_fetch_array($result_1, MYSQL_ASSOC)) {
                echo "<td>{$row_1['aname']}";
                echo"</td>";
                echo "<td>{$row_1['lname']}";
                echo"</td>";
            }
            // echo "</ul>";
            
        }
        echo "</table>";
    }
	?>
        <br>
<a href="friendsadd.php">Add new friends</a>
<br>
<form action='profile.php'>
<input type="submit" value="Back to home page">
</form>

</body>
</html>