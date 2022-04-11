<?php
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $databaseName = 'ecommerce';
    $connection = mysqli_connect($hostname, $username, $password, $databaseName) or 
        exit("Unable to connect database");
    session_start();
?>