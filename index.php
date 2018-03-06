<?php 
//echo "<script type=\"text/javascript\">alert(\"$cDay $fd $cMonth $fm $cYear $fy\")</script>";
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
include_once 'dbconnect.php';
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AirCar</title>    
        
        <!-- BOOTSTRAP RESOURCES -->
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"/>

        <!-- index.php RESOURCES -->
        <link rel="stylesheet" type="text/css" href="css/index.css"/>
        <link rel="stylesheet" type="text/css" href="css/registerLogin.css"/> 
        <link href="css/normalize.css" rel="stylesheet" type="text/css"/>
        <link href="css/datepicker.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="css/footer.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/loginRegister.js"></script>
        

        <!-- SLIDERS RESOURCES -->
        <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
        <link rel="stylesheet" id="themeCSS" href="css/slider/iThing.css">
        <script src="js/slider/jquery.mousewheel.min.js"></script>
        <script src="js/slider/jQAllRangeSliders-min.js"></script>
        <script src="js/slider/slider.js"></script>
        
        <!-- RESOURCES FOR DATEPICKER AND SELECT (BRAND, MAKE) -->
        <script type="text/javascript" src="js/brand.js"></script>
        <script type="text/javascript" src="js/datePicker.js"></script>
        
        <!-- GOOGLE API, AUTOCOMPLETE-->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEVS7ISYWl4irbHtp3xuDiZ6gAetSe5zQ&libraries=places" async defer></script>
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
        
        <script>
            var autocomplete;
            // funciton called at the begining (body on load) which initializes the sliders and autocomplete
            function initialize() {
                
                $("#slider").rangeSlider("min", 0);
                $("#slider").rangeSlider("max", 500);
                setRange(0,500); // set the range of hidden elements (for the form)
                // bind the slider so that when the price change, the value of the hidden elements will change.
                $("#slider").bind("valuesChanging", function(e, data){
                    setRange(data.values.min,data.values.max); // set the range of hidden elements (for the form)
                });
                // initialize autocomplete (google api)
                autocomplete = new google.maps.places.Autocomplete(
                  /** @type {HTMLInputElement} */(document.getElementById('place')),
                  { types: ['geocode'] });
                google.maps.event.addListener(autocomplete, 'place_changed', function() {

                  GetLatlong(); // When user choose autocomplete, then call getlatlong
                });
            }
            
            function GetLatlong()
            {
                // this will set the hidden element lat and lng to the value of the location
                console.log("t");
                var geocoder = new google.maps.Geocoder();
                var address = document.getElementById('place').value;
                //var address = document.getElementById('place').value;
                geocoder.geocode({ 'address': address }, function (results, status) {

                    if (status == google.maps.GeocoderStatus.OK) {
                        var latitude = results[0].geometry.location.lat();
                        var longitude = results[0].geometry.location.lng();
                        document.getElementById('lat').value = latitude;
                        document.getElementById('lng').value = longitude;
                        
                    }
                });
            }
            
            function setRange(x,y){
                document.getElementById("priceFrom").value = x;
                document.getElementById("priceTo").value = y;
            }
        </script>
        
        
    </head>    

    <body onload="InitializeMake(); initialize();">
        <?php
        include 'login.php';
        include 'register.php'; 
        ?>
        
        <div id="mainDiv">
            <?php // depending if the user is logged in or not, load appropriate navigation bar (top menu)
                if( (isset($_SESSION['user'])!= "") ){
                    include 'loggedInNavBar.php';
                }else{
                    include 'notLoggedInNavBar.php';
                }
            ?>

            <div class="container" id="mainSearchDiv"> <!-- Container -->
                <div id="standardSearchDiv" class="table-responsive">
                    <center>
                        <form name="searchForm" id="searchBox" method="get" action="main.php">
                                <table class="table">
                                    <tr>
                                        <input type ="hidden" name="lat" id="lat"/>
                                        <input type ="hidden" name="lng" id="lng"/>
                                        <input type ="hidden" name ="make" id="makeHidden" />
                                        <input type ="hidden" name="model" id="modelHidden"/>
                                        <input type ="hidden" name="priceFrom" id= "priceFrom" />
                                        <input type ="hidden" name="priceTo" id="priceTo" />
                                        <input type ="hidden" name="fromDay" id="fromDayHidden" />
                                        <input type ="hidden" name="fromMonth" id="fromMonthHidden" />
                                        <input type ="hidden" name="fromYear" id="fromYearHidden" />
                                        <input type ="hidden" name="toDay" id="toDayHidden" />
                                        <input type ="hidden" name="toMonth" id="toMonthHidden" />
                                        <input type ="hidden" name="toYear" id="toYearHidden" />
                                        
                                        <th colspan="4"><input type="text" class="form-control" name="place" id="place" required placeholder="Where do you want to go?"/></th>
                                        
                                        <?php
                                            if(isset($errorMsg)){ 
                                        ?>
                                        <span class="redClass"> <?php echo $errorMsg; ?></span>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><input type="text" name="from" id="fromDatePicker" class="pickerStyle form-control" required placeholder="From.."/></td>
                                        <td colspan="2"><input type="text" name="to" id="toDatePicker" class="pickerStyle form-control" required placeholder="To.."/></td>
                                    </tr>
                                    <tr>
                                        <td><text>Make</text></td>
                                        <td>
                                            <select class="form-control" name ="makeSelect" onchange="ChangeModel(this.selectedIndex);">
                                                <option><text>Any Make</text></option>
                                            </select>
                                        </td>
                                        <td><text>Model</text></td>
                                        <td>
                                            <select class="form-control" name ="modelSelect" onchange="SetModel(this.selectedIndex);">
                                                <option><text>Any Model</text></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="noBorder">
                                        <th class="form-control blueBorder" id="priceHeader" colspan="4">Price Per Day:</th>
                                    </tr>
                                    <tr class="blueBorder">
                                        <td colspan="2"><div id="slider"></div></td>
                                        <td colspan="2"><button class="btn" type="submit" id="searchButton">Search!</button></td>
                                    </tr>        
                                </table>
                        </form>
                    </center>

                </div>

                <div id="textDiv">
                    <div class="row">
                            <div class="col-sm-2">
                                <ul>
                                    <img id="searchImage" class="img-responsive" src="images/location.png" />
                                    <h3>1. Choose where to look.</h3>
                                </ul>
                            </div><!-- End of col-sm-2 -->

                            <div class="col-sm-2 marginLeftClass">
                                <img id="carImage" class="img-responsive" src="images/car.png" />
                                <h3>2.Choose a car.</h3>
                            </div><!-- End of col-sm-2 -->

                            <div class="col-sm-2 marginLeftClass">
                                <img id="payImage" class="img-responsive" src="images/pay-icon.png" />
                                <h3>3. Pay securely.</h3>
                            </div><!-- End of col-sm-2 -->
                    </div>
                </div>
            </div> <!-- end of container (mainSearchDiv) -->

        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>