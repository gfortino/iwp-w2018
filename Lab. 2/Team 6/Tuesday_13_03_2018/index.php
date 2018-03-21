<html>
 <head>
  <title>PHP Test</title>
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
      while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["Name"]. "<br>";
      }
    } else {
      echo "0 results";
    }
    $conn->close();


    $value = 10 ;
    $othervalue = "10";

    echo "FIRST PART<br>";
    if($value  == $othervalue){
      echo ("Same value<br>");
    }else{
      echo ("Wrong value<br>");
    }
    echo "SECOND PART<br>";
    if($value  === $othervalue){
      echo ("Same value<br>");
    }else{
      echo ("Wrong value<br>");
    }
    if(++$value > $othervalue){
      echo $value . "<br>";
      echo $othervalue . "<br>";
    }

   ?>
 </body>
</html>
