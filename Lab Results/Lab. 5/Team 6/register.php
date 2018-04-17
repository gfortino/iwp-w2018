<?php

require('connect.php');
    if (isset($_POST['username']) && isset($_POST['password']))
    {
        $username = $_POST['username'];
	    $email = $_POST['email'];
        $password = md5($_POST['password']);

        $query = "INSERT INTO `user` (username, password, email) VALUES ('$username', '$password', '$email')";
        $result = mysqli_query($connection, $query);
        if($result)
        {
            echo "User created";
        }
        else
        {
            echo "Failed";
        }
    }
?>

<div>
      <form class="form-signin" method="POST">
        <label for="inputEmail" >Email address</label>
        <input type="email" name="email" placeholder="Email address"> <br/>
        <label for="inputPassword">Password</label>
        <input type="password" name="password" placeholder="Password">  <br/>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
        <button class="btn btn-lg btn-primary btn-block" href="login.php">Login</button>
      </form>
</div>
</form>
