<?php
    include("db_connect.inc.php");
    $sql="call userlikeActivity('$username','$id')";
    $result=mysql_query($sql);
    
    echo "<table border='1'>
    <tr>
    <th>activity id</th>
    </tr>";
    
    while($row=mysql_fetch_assoc($result)){
    echo "<tr>";
    echo "<td>".$row['$username']."</td>";
    echo "<td>".$row['$id']."</td>";
    echo "</tr>";
    }
    echo "</table>";
    ?>
