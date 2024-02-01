<?php

$sname = "localhost";
$uname = "root";
$password = "";

$db_name = "nu_accountsdb";
$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn){
    echo "Connection failed";
}