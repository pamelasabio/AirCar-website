<?php
    // this will avoid mysql_connect() deprecation error.
    //error_reporting( ~E_DEPRECATED & ~E_NOTICE );

    define('DBHOST', 'localhost');
    define('DBUSER', 'root');
    define('DBPASS', '');
    define('DBNAME', 'AirCar'); 

    $conn = new mysqli(DBHOST,DBUSER,DBPASS);

    if ( $conn->connect_error ) {
        die("Connection failed : " . mysql_error());
    }

    $conn = new mysqli(DBHOST, DBUSER, DBPASS);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . "<br/>");
    } 

    // Create database test2
    $sql = "CREATE DATABASE IF NOT EXISTS AirCar";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating database: " . $conn->error . "<br/>";
    }

    // Create connection
    $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    // sql to create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
    userId INT(11) NOT NULL AUTO_INCREMENT, 
    userName VARCHAR(30) NOT NULL,
    userEmail VARCHAR(60) NOT NULL,
    userPass VARCHAR(255) NOT NULL,
    PRIMARY KEY(userId),
    UNIQUE KEY userEmail (userEmail)
    )";

    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error ."<br/>";
    }
?>