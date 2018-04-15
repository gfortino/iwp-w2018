<?php
include 'header.php';
if(! empty($_SESSION['mail'])){
?>
            <li><a href="account.php"><span class="glyphicon glyphicon-ok"></span> <?php echo $_SESSION['mail'] ?></a></li>
            <li><form method="POST">
              <button style="margin-top:10%" type="submit" name="deco">
                Deconnection
              </button>
              <form></li>
<?php
}
if (isset($_POST['deco'])){
  // Deconnection
  session_unset();
  session_destroy();
  // Refresh
  echo "<meta http-equiv=\"refresh\" content=\"1;url=index.php\"/>";
}
if(empty($_SESSION['mail'])){
?>
<html>
<div class="space">
<h2>Log in</h2><br>
<form method=POST>
   <label>Email:</label>
     <input type="email" name="mail" placeholder="Enter email"><br>
   <label>Password:</label>
     <input type="password" name="password" placeholder="Enter password"><br><br>
     <button type="submit" class="btn btn-default">Submit</button>
</form><br>

<h2>Sign in</h2><br>
<form method=POST>
   <label>Email:</label>
     <input type="email" name="newmail" placeholder="Enter email"><br>
   <label>Password:</label>
     <input type="password" name="newpassword" placeholder="Enter password"><br><br>
     <button type="submit" class="btn btn-default">Submit</button>
</form>


<?php
if (isset($_POST['mail'])){
  $con = "SELECT mail, password FROM user WHERE mail='".$_POST['mail']."' AND password='".$_POST['password']."'";
  $info = $bdd->query($con);
  $infos = $info->fetchAll();
if(count($infos)!=0){
  $_SESSION['mail'] = $_POST['mail'];
  $_SESSION['password'] = $_POST['password'];
  }else{
    echo "<h3>Invalid identifiers</h3>";
  }

}
if (isset($_POST['newmail'])){
  $_SESSION['mail'] = $_POST['newmail'];
  $_SESSION['password'] = $_POST['newpassword'];
  $new = "INSERT INTO user (mail,password) VALUES ('".$_POST['newmail']."','".crypt($_POST['newpassword'].)"')";
  $bdd->query($new);
}
}
echo $res."</div>
</html>";
?>
