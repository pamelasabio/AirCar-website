<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
 
function validateFields(){
    if(isset($lat)){return true;}
    
    if(isset($_GET["lat"]) && isset($_GET["lng"]) && isset($_GET["fromDay"]) && isset($_GET["fromMonth"]) && isset($_GET["fromYear"]) && isset($_GET["toDay"]) && isset($_GET["toMonth"]) && isset($_GET["toYear"]) && isset($_GET["make"]) && isset($_GET["model"]) && isset($_GET["priceFrom"]) && isset($_GET["priceTo"])){
        return true;   
    }else{
        return false;
    }
}
include_once 'dbconnect.php';
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $error = false;
    // function to validate if the TO date is not smaller than FROM date (that would mean user is trying to return the car before its rental).
    function validateDate($fd,$fm,$fy,$td,$tm,$ty){
        if($fy > $ty){ // Check if from year is bigger than to year
            return false;
        }

        if($fm > $tm){ // check months
            return false;
        }

        if($fd > $td){ // check days
            return false;
        }

        return true; // if dates are okay, then return true
    }
    // function will compare the "from date" with current date to make sure that user is not trying to book the car in the past
    function compareWithCurrentDate($fd,$fm,$fy){
        $cYear = date("Y");

        if($cYear > $fy){ // check if user is trying to select year in the past
            return false;
        }

        $cMonth = date("m");
        if($cMonth > $fm){ // check if user is trying to select month in the past (same year)

            return false;
        }
        $cDay = date("d");
        if($cDay > $fd){ // check if user is trying to select day in the past (same year, same month)
            return false;
        }

        return true; // otherwise return true
    }


    if(validateFields()){
        // get variables using GET
        // htmlspecialchars used in order to avoid javascript injection
        $lat = htmlspecialchars($_GET["lat"]);
        $lng = htmlspecialchars($_GET["lng"]);
        $fromDay = htmlspecialchars($_GET["fromDay"]);
        $fromMonth = htmlspecialchars($_GET["fromMonth"]);
        $fromMonth = ($fromMonth +1);
        $fromYear = htmlspecialchars($_GET["fromYear"]);
        $toDay = htmlspecialchars($_GET["toDay"]);
        $toMonth = htmlspecialchars($_GET["toMonth"]);
        $toMonth = ($toMonth +1);
        $toYear = htmlspecialchars($_GET["toYear"]);
        $make = htmlspecialchars($_GET["make"]);
        $model = htmlspecialchars($_GET["model"]);
        $priceFrom = htmlspecialchars($_GET["priceFrom"]);
        $priceTo = htmlspecialchars($_GET["priceTo"]); 

        // avoid SQL injection
        $lat = mysqli_real_escape_string($conn,$lat);
        $lng = mysqli_real_escape_string($conn,$lng);
        $fromDay = mysqli_real_escape_string($conn,$fromDay);
        $fromMonth = mysqli_real_escape_string($conn,$fromMonth);
        $fromYear = mysqli_real_escape_string($conn,$fromYear);
        $toDay = mysqli_real_escape_string($conn,$toDay);
        $toMonth = mysqli_real_escape_string($conn,$toMonth);
        $toYear = mysqli_real_escape_string($conn,$toYear);
        $make = mysqli_real_escape_string($conn,$make);
        $model = mysqli_real_escape_string($conn,$model);
        $priceFrom = mysqli_real_escape_string($conn,$priceFrom);
        $priceTo = mysqli_real_escape_string($conn,$priceTo);
        $fromDate = new DateTime();
        $fromDate->setDate($fromYear, $fromMonth, $fromDay);
        $toDate = new DateTime();
        $toDate->setDate($toYear, $toMonth, $toDay);

        if($lat == "" || $lng == ""){  // Check if location is found
            $error = true;
            $errorMsg = "Invalid Location";
        }else if(!validateDate($fromDay,$fromMonth,$fromYear,$toDay,$toMonth,$toYear)){
            $error = true;
            $errorMsg = "The return date is before the from date. Please check your dates.";
        }else if(!compareWithCurrentDate($fromDay,$fromMonth,$fromYear)){
            $error = true;
            $errorMsg = "You cannot choose to rent a car in the past. Please check your dates.";
        }

        if($error){
            include 'index.php';
        }else{
            include 'searchResults.php';
        }

    }else{
        header("Location: index.php");  // if user tries to access formController witout previously going through index.php then redirect him back to index.php 
        // e.g. if user types in .../formController.php directely to the address bar 
    }
}else{
    if(validateFields()){
        if(isset($_SESSION['user']) != ""){
            include 'searchResults.php';
        }else
        {
            include 'index.php';
        }
    }else{
        include 'index.php';
    }
}

?>