<?php
//ob_start();
require_once 'dbconnect.php';
if(!isset($_SESSION['user'])){
    session_start();
}

include "userQuery.php";


if( isset($_POST['btn-change']) ) { 
    $encryptOldPass = hash('sha256', $_POST["oldPass"]); 
    if(empty($_POST["oldPass"])){
         $oldError = "Old password cannot be empty";
         echo "<script type=\"text/javascript\">alert(\"$oldError\")</script>";
    }else if(empty($_POST["newPass"])){
         $newError = "New Pass cannot be empty";
         echo "<script type=\"text/javascript\">alert(\"$newError\")</script>";
    }else if($encryptOldPass == $password){
        $newPass = hash('sha256',$_POST["newPass"]);
        $sql = "UPDATE users SET userPass = '$newPass' WHERE userEmail = '$user'";
        if ($conn->query($sql) === TRUE) {
            $errMSG = "Password updated, please use your new password now!";
            unset($_SESSION['user']);
            echo "<script type=\"text/javascript\">alert(\"$errMSG\")</script>";
        } else {
            $errMSG = $conn->error;
            echo "<script type=\"text/javascript\">alert(\"Please try again.\")</script>";
        }
    }else{
        
        $errMSG = "Wrong old password";
        echo "<script type=\"text/javascript\">alert(\"$errMSG\")</script>";
    } 
}

if( isset($_POST['btn-delete']) ){
                  
    $sql = "DELETE FROM users WHERE userId='$userId'";
    $result = $conn->query($sql);
    
    if ($result) {
        unset($_SESSION['user']);
         echo "<script type=\"text/javascript\">alert(\"Account Deleted\")</script>";
    }else{
        echo "<script type=\"text/javascript\">alert(\"Failed to delete the account.\")</script>";
    }
}

header("Location:index.php");

?>