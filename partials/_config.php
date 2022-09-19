<?php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "cab_booking";

$conn = mysqli_connect($server,$username,$password,$dbname);
if(!$conn)
{
    echo "error connecting to db";
}

?>