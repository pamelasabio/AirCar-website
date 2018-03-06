<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
include_once 'dbconnect.php';
include_once 'locationxml.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/searchResults.css"/>
    <link rel="stylesheet" type="text/css" href="css/mainNavBar.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/registerLogin.css"/>  
    
    <script type="text/javascript" src="js/loginRegister.js"></script>
    
    
    <script>

        // Function which calculates total price
        function calculatePrice(f,t){
            
            //alert(f);
            var fSplit =f.split('/');
            //alert(fSplit);
            var fDate = new Date(fSplit[2],fSplit[1]-1,fSplit[0]);
            var tSplit = t.split('/');
            var tDate = new Date(tSplit[2],tSplit[1]-1,tSplit[0]); 

            //Get 1 day in milliseconds
            var one_day=1000*60*60*24;

            // Convert both dates to milliseconds
            var date1_ms = fDate.getTime();
            var date2_ms = tDate.getTime();

            // Calculate the difference in milliseconds
            var difference_ms = date2_ms - date1_ms;

            // Convert back to days and return
            return Math.round(difference_ms/one_day); 
        }
        
        // Function that submits the form
        function submitForm(id,from,to,make,model,price,trans,desc, mil, y, ft, eng,i1,i2,i3){
            document.getElementById('carpost_id').value = id; 
            document.getElementById('fromDate').value = from;
            document.getElementById('toDate').value = to;
            document.getElementById('make').value = make;
            document.getElementById('model').value = model;
            document.getElementById('price').value = price;
            document.getElementById('transmission').value = trans;
            document.getElementById('description').value = desc;
            document.getElementById('image1').value = i1;
            document.getElementById('image2').value = i2;
            document.getElementById('image3').value = i3;
            document.getElementById('millage').value = mil;
            document.getElementById('year').value = y;
            document.getElementById('fuelType').value = ft;
            document.getElementById('engine').value = eng;
            
            var days = calculatePrice(from,to);
            var total = days * price;
            document.getElementById('totalPrice').value = total;
            document.getElementById('days').value = days;
            
            document.forms["viewCarFormName"].submit();
        }
        
     // Function that initializes the map and shows the markers
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: new google.maps.LatLng(<?php echo $lat . "," . $lng; ?>),
            });
        
            var infoWindow = new google.maps.InfoWindow;
            downloadUrl('./locations.xml', function(data) {
                var xml = data.responseXML;
                var markers = xml.documentElement.getElementsByTagName('marker');
                    Array.prototype.forEach.call(markers, function(markerElem) {
                    var make = markerElem.getAttribute('make');
                    var model = markerElem.getAttribute('model');
                    var price = markerElem.getAttribute('price');
                    var image = markerElem.getAttribute('image');
                    var point = new google.maps.LatLng(
                    parseFloat(markerElem.getAttribute('lat')),
                    parseFloat(markerElem.getAttribute('lng')));
                    
                    var infowincontent = document.createElement('div');
                    var pic = document.createElement('img');
                    pic.setAttribute('src', image);
                    pic.setAttribute('height', '50px');
                    pic.setAttribute('width', '50px');
                    infowincontent.appendChild(pic);
                    infowincontent.appendChild(document.createElement('br'));
                        
                    var strong = document.createElement('strong');
                    strong.textContent = make
                    infowincontent.appendChild(strong);
                    infowincontent.appendChild(document.createElement('br'));

                    var text = document.createElement('text');
                    text.textContent = model
                    infowincontent.appendChild(text);
                    var marker = new google.maps.Marker({
                            map: map,
                            position: point,
                            label: "€" + price
                    });
                    marker.addListener('click', function() {
                        infoWindow.setContent(infowincontent);
                        infoWindow.open(map, marker);
                    });
                });
            });
        }

        function downloadUrl(url, callback) {
            var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

            request.onreadystatechange = function() {
                if (request.readyState == 4) {
                request.onreadystatechange = doNothing;
                callback(request, request.status);
                }
            };

            request.open('GET', url, true);
            request.send(null);
        }
        
        function doNothing(){}
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD79HtR5HAniEOhZzmrizkfapW5gBxxBRk&callback=initMap"></script>
</head>
    
<body>    
    <?php
    include 'register.php';
    include 'login.php';
    if( isset($_SESSION['user'])!= "" ){
        include 'loggedInNavBar.php';
        //include 'navBars/loggedInNavBarMain.php';
    }else{
        include 'notLoggedInNavBar.php';
       // include 'navBars/notLoggedInNavBarMain.php';
    }
    ?>
   
        <div class="container" id="leftMainDiv">
            <div class="list-group">
                <form id="viewCarFormId" name="viewCarFormName" method="get" action="car.php" >
                    <input type="hidden" id="carpost_id" name="carpost_id" value="" />
                    <input type="hidden" id="fromDate" name ="fromDate" value="" />
                    <input type="hidden" id="toDate" name = "toDate" value="" />
                    <input type="hidden" id="make" value="" name="make" />
                    <input type="hidden" id="model" value="" name="model"/>
                    <input type="hidden" id="price" value="" name="price"/>
                    <input type="hidden" id="transmission" name="transmission" value="" />
                    <input type="hidden" id="description" name="description" value="" />
                    <input type="hidden" id="image1" value="" name="image1"/>
                    <input type="hidden" id="image2" value="" name="image2"/>
                    <input type="hidden" id="image3" value="" name="image3"/>
                    <input type="hidden" id="millage" value="" name="millage"/>
                    <input type="hidden" id="year" value="" name="year"/>
                    <input type="hidden" id="fuelType" value="" name="fuelType"/>
                    <input type="hidden" id="engine" value="" name="engine"/> 
                    <input type="hidden" id="totalPrice" value="" name="totalPrice"/>   
                    <input type="hidden" id="days" value="" name="days"/> 
                </form>

                <?php
                if($make == "Any Make" & $model == "Any Model"){
                        $sql = "SELECT * , ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(" . $lng . ") ) + sin( radians(" . $lat . ") ) * sin( radians( lat ) ) ) ) AS distance FROM car_posts where price >= " . $priceFrom . 
                        "&& price <= " .$priceTo . "&& fromDate >= " . $fromDate->format('Y/m/d') . " HAVING distance < 250 ORDER BY distance;";

                    }else if($make == $make & $model == "Any Model"){ 
                        $sql = "SELECT * , ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(" . $lng . ") ) + sin( radians(" . $lat . ") ) * sin( radians( lat ) ) ) ) AS distance FROM car_posts where make = '" . $make . "'&& price >= " . $priceFrom . "&& price <= " .$priceTo . "&& fromDate >= " . $fromDate->format('Y/m/d') . " HAVING distance < 250 ORDER BY distance;";
                    }else if($make == $make & $model == $model){
                         $sql = "SELECT * , ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(" . $lng . ") ) + sin( radians(" . $lat . ") ) * sin( radians( lat ) ) ) ) AS distance FROM car_posts where make = '" . $make . "'&& model = '" . $model . "'&& price >= " . $priceFrom . "&& price <= " .$priceTo . "&& fromDate >= " . $fromDate->format('Y/m/d') . " HAVING distance < 250 ORDER BY distance;";
                }

                if(($result = $conn->query($sql))){
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            
                            
                        ?>
                        
                        <a href="javascript:submitForm('<?php echo $row["carpost_id"]; ?>','<?php echo $fromDate->format('d/m/Y'); ?>','<?php echo $toDate->format('d/m/Y'); ?>','<?php echo $row["make"]; ?>','<?php echo $row["model"]; ?>','<?php echo $row["price"]; ?>','<?php echo $row["transmission"]; ?>','<?php echo $row["description"]; ?>','<?php echo $row["millage"]; ?>','<?php echo $row["year"]; ?>','<?php echo $row["fuelType"]; ?>','<?php echo $row["engine"]; ?>','<?php echo $row["image1"]; ?>','<?php echo $row["image2"]; ?>','<?php echo $row["image3"]; ?>')" class="list-group-item">
                            
                            
                            <div class="media"> <!-- create a div -->
                                <div class="media-left"> <!-- create another div -->
                                    <img src="<?php echo $row["image1"]; ?>" class="media-object"> <!-- set the image source -->
                                </div> <!-- close div -->
                                <div class="media-body"> <!--  create div -->
                                    <h4 class="media-heading"> <?php echo $row["make"]; ?> <?php echo $row["model"]; ?></h4> <!--  set make and model headers -->
                                    <p>From: <?php echo $fromDate->format('d/m/Y'); ?> To: <?php echo $toDate->format('d/m/Y'); ?></p> <!--  set dates -->
                                    <p><?php echo $row["description"]; ?></p> <!-- set description -->
                                </div><!--  end div -->
                            </div><!-- end div -->
                        </a><!-- end a href -->
                
                            
                            <?php
                        }
                    } else {
                        echo "0 results";
                    }
                }else{
                    header("Location: index.php");
                }
                $conn->close();
                ?>
            </div>
        </div>
    
        <div class="container" id="map">

        </div>
   
    
    
</body>
    
    
</html>