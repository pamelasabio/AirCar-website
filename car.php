<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
include_once 'dbconnect.php';

function validateFields(){
    if(isset($lat)){return true;}
    
    if(isset($_GET["carpost_id"]) && isset($_GET["fromDate"]) && isset($_GET["toDate"]) && isset($_GET["make"]) && isset($_GET["model"]) && isset($_GET["price"]) && isset($_GET["transmission"]) && isset($_GET["description"]) && isset($_GET["image1"]) && isset($_GET["image2"]) && isset($_GET["image3"]) && isset($_GET["year"]) && isset($_GET["fuelType"]) && isset($_GET["engine"]) && isset($_GET["millage"]) && isset($_GET["totalPrice"]) && isset($_GET["days"])){
        return true;   
    }else{
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (!empty($_GET["carpost_id"])) {      
      if(validateFields()){
          $image1 = $_GET["image1"];
          $image2 = $_GET["image2"];
          $image3 = $_GET["image3"];
          $carpost = $_GET["carpost_id"];
          $fromDate = $_GET["fromDate"];
          $toDate = $_GET["toDate"];
          $make = $_GET["make"];
          $model = $_GET["model"];
          $price = $_GET["totalPrice"];
          $trans = $_GET["transmission"];
          $desc = $_GET["description"];
          
          $year = $_GET["year"];
          $fuelType = $_GET["fuelType"];
          $engine = $_GET["engine"];
          $millage = $_GET["millage"];
          $dailyPrice = $_GET["price"];
          $days = $_GET["days"];
          
      }else{
          // If there is errors, redirect user to the main page.
          header("Location: index.php");
      }
      
  }else{
        // If there is errors, redirect user to the main page.
        header("Location: index.php");
  }
}else{
    // If there is errors, redirect user to the main page.
    header("Location: index.php");
}
?>


<html>
    <head>
        
        <!-- BOOTSTRAP, JQUERY RESOURCES -->
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"/>  
        
        <link rel="stylesheet" type="text/css" href="css/car.css"/> <!-- main css -->
        <link rel="stylesheet" type="text/css" href="css/footer.css"/> <!-- the footer -->
        <link rel="stylesheet" type="text/css" href="css/mainNavBar.css"/> <!-- for main navbar -->
        <script type="text/javascript" src="js/car.js"></script>    <!-- javascript for this page -->
        
        <link rel="stylesheet" type="text/css" href="css/registerLogin.css"/>
        <script type="text/javascript" src="js/loginRegister.js"></script> 
        
    </head>
    
    
    <body>
        <?php
        include 'login.php';
        include 'register.php';
        ?>
        
        <div id="mainDiv">
            
            <?php
            if( isset($_SESSION['user'])!= "" ){
                include 'loggedInNavBar.php';
                //include 'navBars/loggedInNavBarMain.php';
            }else{
                include 'notLoggedInNavBar.php';
                //include 'navBars/notLoggedInNavBarMain.php';
            }
            ?> 
            
            
            <div id="bigImageDiv"> <!-- DIV FOR BIG IMAGE -->
                <img name="preview" src ="<?php echo $image1 ?>" id="bigImage"/>
            </div>
            
            <div id="smallImagesDiv" align="center"> <!-- THE DIV FOR SMALL IMAGES -->
                <div class ="thumbnails">
                    <img onmouseover="changeImage(img1.src)" name ="img1" src ="<?php echo $image1 ?>", alt ="" />
                    <img onmouseover="changeImage(img2.src)" name ="img2" src ="<?php echo $image2 ?>", alt ="" />
                    <img onmouseover="preview.src=img3.src" name ="img3" src ="<?php echo $image3 ?>", alt ="" />
                </div>
            </div>
            
            <div class="container" id="mainCarDiv">  <!-- THE CONTAINER DIV -->
                <hr/>
                <div id="informationDiv">  <!-- DIV FOR INFORMATION -->
                    <h1 class="headerClass">Key Info <span id="totalPrice">€ <?php echo $price ?> for <?php echo $days ?> Days</span></h1> 
                    <table id ="informationTable">
                        <tr>
                            <th>Make: </th>
                            <td><?php echo $make ?></td>
                            <th>Millage: </th>
                            <td><?php echo $millage ?></td>
                            <th>Transmission: </th>
                            <td><?php echo $trans ?></td>
                            <th>Daily Price: </th>
                            <td id="priceTd">€ <?php echo $dailyPrice ?></td>
                        </tr>
                        <tr>
                            <th>Model: </th>
                            <td><?php echo $model?></td>
                            <th>Year: </th>
                            <td><?php echo $year ?></td>
                            <th>Fuel Type: </th>
                            <td><?php echo $fuelType?></td>
                            <th>Engine: </th>
                            <td><?php echo $engine ?> L</td>
                        </tr>
                    </table>
                </div>
                <hr/>
                <div id="descriptionDiv"> <!-- DIV FOR DESCRIPTION -->
                    <h1 class="headerClass">Description</h1>
                    <p><?php echo $desc?></p>
                </div>
                <hr/>
                
                
            </div> <!-- end of container (mainSearchDiv) -->
        </div> <!-- end of mainDiv -->
        <span id="footerSpan"><?php include 'footer.php'; ?></span>
    </body>
</html>