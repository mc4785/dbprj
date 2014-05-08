<?php
$q = $_GET['q'];
    $connect = mysqli_connect('localhost','root','root','communitynetwork');
    //if (!$connect) {
      //  die('Could not connect: ' . mysqli_error($connect));
    //}
    
    //mysqli_select_db($connect,"communitynetwork");
$sql="SELECT * FROM Users WHERE uname = '".$q."'";
$result = mysqli_query($sql);
    //echo $sql;
    echo $result;
echo "<table border='1'>
<tr>
<th>Friends name</th>
<th>birthday</th>
<th>honetown</th>
</tr>";

while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>".$row['uname']."</td>";
  echo "<td>".$row['birth']."</td>";
  echo "<td>".$row['city']."</td>";
  echo "</tr>";
}

echo "</table>";

?>