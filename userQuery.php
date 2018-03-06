<?php
//ob_start();
require_once 'dbconnect.php';
if(!isset($_SESSION['user'])){
    session_start();
}

$userId = $_SESSION['user'];
$sql = "SELECT userEmail, userPass FROM users WHERE userId='$userId'";
$result = $conn->query($sql);
$user = "";
$password = "";
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $user = $row['userEmail'];
    $password = $row['userPass'];
}else{
    $_SESSION['user'] = "";
}
?>