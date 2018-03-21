<html>
 <head>
  <title>PHP Test</title>
  <link rel="stylesheet" href="style.css" />
 </head>
 <body>
   <?php

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "LAB1";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
       die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM Nom";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
?>
<table>
  <tr>
    <td>#</td>
    <td>Last Name</td>
    <td>First Name</td>
    <td>Email</td>
  </tr>

<?php
      while($row = $result->fetch_assoc()) {
        if($row["id"]%2 == 0){
        echo "<tr class=\"tabernak\">";
        echo "<td>" . $row["id"]. "</td><td>" . $row["lastName"]. "</td><td>" . $row["firstName"]. "</td><td>" . $row["Email"]. "</td><br>";
        echo "</tr>";
        }else{
          echo "<tr class=\"tabernak2\">";
          echo "<td>" . $row["id"]. "</td><td>" . $row["lastName"]. "</td><td>" . $row["firstName"]. "</td><td>" . $row["Email"]. "</td><br>";
          echo "</tr>";
        }
      }
      for ($i=4; $i<14; $i++) {
        if($i%2==0){
          echo "<tr class=\"tabernak\">
                  <td>$i</td>
                  <td>toto</td>
                  <td>toto</td>
                  <td>toto</td>
                </tr>";
        }else{
          echo "<tr class=\"tabernak2\">
                  <td>$i</td>
                  <td>toto</td>
                  <td>toto</td>
                  <td>toto</td>
                </tr>";
        }
      }
    } else {
      echo "0 results";
    }

    $conn->close();


 ?>
</table>
 </body>
</html>
