<?php
    $q = $_GET['q'];
    include("db_connect.inc.php");
    
    //$connect = mysqli_connect('localhost','root','root','communitynetwork');
    
    $sql="SELECT * FROM Users WHERE uname = '".$q."'";
    $result = mysql_query($sql);
    echo "<p>".$sql."</p>";
    //echo $result;
    echo "<table border='1'>
            <tr>
                <th>Friends name</th>
                <th>birthday</th>
                <th>honetown</th>
            </tr>";

    while($row = mysql_fetch_array($result)) {
        echo "<tr>";
        echo "<td>".$row[0]."</td>";
        echo "<td>".$row[2]."</td>";
        echo "<td>".$row[3]."</td>";
        echo "</tr>";
    }

    echo "</table>";

?>
