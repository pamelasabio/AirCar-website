<?php
session_start(); 
include_once 'dbconnect.php';
$userId = $_SESSION['user'];
if(isset($_POST['btn-upload']))
{    
     
    $file = rand(1000,100000)."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $folder="uploads/";
    $imageFileType = pathinfo($file,PATHINFO_EXTENSION);

    // new file size in KB
    $new_size = $file_size/1024;  
    // new file size in KB

    // make file name in lower case
    $new_file_name = strtolower($file);
    // make file name in lower case

    $final_file=str_replace(' ','-',$new_file_name);
    
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    ?>
        <script>
            alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
            window.location.href='profile.php';
        </script>
    <?php
    }else{
        if(move_uploaded_file($file_loc,$folder.$final_file))
        {
            $sql="update users set image = '$final_file' where userId='$userId'";
            mysqli_query($conn,$sql);
            ?>
        <script>
        alert('successfully uploaded');
            </script>
        <?php
        }
        else
        {
        ?>
        <script>
        alert('error while uploading file');
            window.location.href='profile.php';
            </script>
        <?php
        }
    }
}
?>