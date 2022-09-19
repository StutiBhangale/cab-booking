<?php

session_start();

if(true)
{
    session_unset();
    session_destroy();
    header("location: login.php");
}

?>