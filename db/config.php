<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "presensi";

try {    
    //create PDO connection 
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $db_create = new PDO("mysql:host=$db_host;", $db_user, $db_pass);
    $db_create->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    //show error
    die("Terjadi masalah: " . $e->getMessage());
}
