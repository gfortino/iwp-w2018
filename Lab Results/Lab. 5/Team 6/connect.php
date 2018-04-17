<?php
$connection = mysqli_connect('localhost', 'root', '');
if (!$connection)
{
    die("Database Connection Failed" . mysqli_error($connection));
}

?>
