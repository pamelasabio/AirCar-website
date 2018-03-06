<?php
session_start(); 
include_once 'dbconnect.php';
$userId = $_SESSION['user'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="css/profile.css"/>
    <link rel="stylesheet" type="text/css" href="css/mainNavBar.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/registerLogin.css"/>  
    <script type="text/javascript" src="js/loginRegister.js"></script>
</head>
<body>
    <?php
    include 'loggedInNavBar.php';
    ?>
    <div id="profileBody">
        <center>
        <?php
        $sql="SELECT * FROM users where userId='$userId'";
        $result_set=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_array($result_set))
        {
        ?>
            <h3><?php echo $row['userName']?></h3>
            <p>Email: <?php echo $row['userEmail']?></p>
            
            <?php 
            if($row['image'] == null){
            ?>
                <img src="img/profileimg.png">
                    <?php
            }else{
            ?>
                <img src="uploads/<?php echo $row['image'] ?>">
            <?php
            }
            ?>
        <?php
        }
        ?>
        <div class="container" id="body">
            <center>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="file" name="file" />
                    <button id="uploadbtn" type="submit" name="btn-upload">upload</button>
                </div>
            </form>
                </center>
        </div>
        </center>
    </div>
</body>
</html>