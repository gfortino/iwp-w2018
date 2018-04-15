<html>
<body>
  <form method="GET">
    <input type="text" name="mail">
    <input type="submit" value="Envoyer" >
  </form>
<?php
if (isset($_GET['mail'])) {
  if($_GET['mail']){
    $val = $_GET['mail'];
    if (preg_match('#^[\w.-]+@[a-z]{2,6}+\.[a-z]{2,6}$#', $val)) {
          echo "Mail: ". $val . " is valid.";
    } else {
          echo "Mail: ". $val. " is not valid.";
    }
  }
}
?>
</body>
</html>
