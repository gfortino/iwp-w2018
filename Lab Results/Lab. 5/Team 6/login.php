<?php

session_start();
require('connect.php');

if (isset($_POST['username']) and isset($_POST['password']))
{
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query = "SELECT * FROM `user` WHERE username='$username' and password='$password'";

    $result = mysqli_query($connection, $query);
    $count = mysqli_num_rows($result);

    if ($count == 1)
    {
        $_SESSION['username'] = $username;
    }
    else
    {
        $fmsg = "Error";
    }
}

if (isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
    echo "Welcome " . $username ;
}

?>
