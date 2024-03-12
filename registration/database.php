<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "stan";
$dbName = "bookingsystem";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

?>