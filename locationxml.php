<?php
include_once 'dbconnect.php';

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);


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
          // Add to XML document node
            $node = $dom->createElement("marker");
            $newnode = $parnode->appendChild($node);
            $newnode->setAttribute("make",$row['make']);
            $newnode->setAttribute("model", $row['model']);
            $newnode->setAttribute("lat", $row['lat']);
            $newnode->setAttribute("lng", $row['lng']);
            $newnode->setAttribute("price", $row['price']);
            $newnode->setAttribute("image", $row['image1']);
        }
    }
}
echo $dom->save('locations.xml');

?>