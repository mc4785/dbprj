<?php
    include("db_connect.inc.php");
    $sql="call likeDiary('$username','$did')";
    $result=mysql_query($sql);
    
    echo "<table border='1'>
    <tr>
    <th>activity id</th>
    </tr>";
    
    while($row=mysql_fetch_array($result)){
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "</tr>";
    }
    echo "</table>";
    ?>
