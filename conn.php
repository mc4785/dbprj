<?php
    $host="localhost"; // Host name
    $username="root"; // Mysql username
    $password="root"; // Mysql password
    $db_name="communitynetwork"; // Database name
    $user_tbl_name="Users"; // Table name
    
    $connect = mysql_connect("localhost", "root", "root") or die("cannot connect");
    mysql_select_db("communitynetwork", $connect) or die("cannot select DB");
    ?>