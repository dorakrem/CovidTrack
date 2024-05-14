<?php
session_start();
$errors = array();
if (isset($_POST['searchpoi']) && $_POST["poi_keyword"]!="") {

                    $keyword = isset($_POST["poi_keyword"])?$_POST["poi_keyword"]:"";
                        // Database Settings

                        // DBMS connection code -> hostname,
                        // username, password, database name
                        $db = mysqli_connect('localhost', 'root', '', 'covidtrack',3310);
                        $clean_keyword = $db->real_escape_string($keyword);
                        
                        
                        //SQL Syntax
                        $query = "SELECT * FROM pointofinterest WHERE name LIKE '%".$clean_keyword."%' OR address LIKE '%".$clean_keyword."%' OR rating LIKE '%".$clean_keyword."%' GROUP BY name ASC";

                        //Execute SQL
                        $result = $db->query($query);

                        //Count results
                        $rowCount = $result->num_rows;
                      // echo $rowCount;
                        if($rowCount == 0)
                        {
                            array_push($errors, "No Poi(s) Found.");
                        }

                            while ($row = $result->fetch_array()){
                                //Assing table variables

                                $id = $row[0];
                                $name = $row[1];
                                $address = $row[2];
                                $types = $row[3];
                                $lat = $row[4];
                                $lng = $row[5];
                                $rating = $row[6];
                                $rating_n = $row[7];
                                $current_popularity = $row[8];
                                $time_spent = $row[9];
                               

                                // Store results into JSON array

                                $rows[] = array(
                                    "id" => $id,
                                    "name" =>  $name,
                                    "address" => $address,
                                    "types" => $types,
                                    "lat" => $lat,
                                    "lng" => $lng,
                                    "rating" => $rating,
                                    "rating_n" => $rating_n,
                                    "current_popularity" => $current_popularity,
                                    "time_spent" => $time_spent
                                );
                    
                    // Encode rows data to JSON format

                    $jsonOutput = json_encode($rows);}

                    //echo $jsonOutput;

                    // Free and close DB connection
                    $result->free();
                    $db->close();}
                    ?>

        <!-- Leaflet JS -->
   
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

        <!-- JSON Data -->
        <?php
            //Dislpay POIs data from JSON output as <script> tag
            echo "<script type='text/javascript'>";
            echo "var dataPOI = " .$jsonOutput.";\n";
            echo "</script>\n";
        ?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="pandemic.ico" type="image/ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> CovidTrack | Map </title>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
        <?php include('errors.php'); ?>
        <style>

        body {
            margin: 0;
            padding: 0;

        }

        #map {
            width: 100%;
            height: 92vh;
        }
        </style>
         <style>
        /* Add a black background color to the top navigation bar */
    .topnav {
    overflow: hidden;
    background-color: #e9e9e9;
    width:100%;
    }

    /* Style the links inside the navigation bar */
    .topnav a {
    float: left;
    display: block;
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
    font-family: "Times New Roman", Times, serif;
    }

    /* Change the color of links on hover */
    .topnav a:hover {
    background-color: #ddd;
    color: black;
    }

    /* Style the "active" element to highlight the current page */
    .topnav a.active {
    background-color: #2196F3;
    color: white;
    }

    /* Style the search box inside the navigation bar */
    .topnav input[type=text] {
    float: right;
    padding: 6px;
    border: none;
    margin-top: 6.5px;
    margin-right: 16px;
    font-size: 17px;
     font-family: "Times New Roman", Times, serif;
    }

    .topnav .search-container {
  float: right;
}

.topnav .search-container button {
  float: right;
  padding: 7px 10px;
  margin-top: 6.8px;
  margin-right: 16px;
  background: #ddd;
  font-size: 17px;
  border: none;
  cursor: pointer;
  position: absolute;
  right: 0;
}

.topnav .search-container button:hover {
  background: #ccc;
}

    /* When the screen is less than 600px wide, stack the links and the search field vertically instead of horizontally */
    @media screen and (max-width: 600px) {
  .topnav .search-container {
    float: none;
  }
  .topnav a, .topnav input[type=text], .topnav .search-container button {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
    
  }
  .topnav input[type=text] {
    border: 1px solid #ccc;  
  }
}
    </style>
    </head>
<body>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>
    <div class="topnav">
        <a class="active" href="map.php"><i class="fa fa-globe"></i>  User's Live Location</a>
        <a href="testaddcase.php"><i class="fas fa-virus"></i>  Covid Case</a>
        <a href="covidcontact.php" ><i class="fas fa-users"></i>  Possible Covid Contact</a>
        <a href="editprofile.php" name="editprofile"><i class="fas fa-user-circle"></i> Profile</a>
        <a href="login.php?logout='1'" style="color: red;"><i class="fa fa-sign-out"></i> Logout </a>
        <div class="search-container">
            <form method="post" action="map.php" >
                
      <input type="text" name="poi_keyword" placeholder="Search POI(s).." >
      <button type="submit" id="showData1" name="searchpoi"><i class="fa fa-search"></i></button>
    </form>
  </div>
      </div>
     
    <div id="map"></div>



</body>


<!--- leaflet js-->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.js" charset="utf-8"></script>
<script>
    //Map initialization
     var map =L.map('map').setView([38.246639, 21.734573], 14);
     var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
     });
    osm.addTo(map);
    var lc = L.control.locate({
        follow: true,  // follow the user's location
        setView: true,
        drawCircle: true, 
      locateOptions: {
               enableHighAccuracy: true
    }}).addTo(map);
   lc.start();

   
//checks for color of marker
for (var i=0; i<dataPOI.length; i++){
    if  ( dataPOI[i].current_popularity == 0){
        var leafletImage = L.icon({
            iconUrl: 'green.png',
            iconSize: [30, 40],
            iconAnchor: [15, 40],
            popupAnchor: [0, -35]
        });
        function clickZoom(e) {
            map.setView(e.target.getLatLng(),17);
        }
        
        let id = dataPOI[i].id;
        L.marker([dataPOI[i].lat,dataPOI[i].lng],{icon: leafletImage}).bindPopup("<b>"+ dataPOI[i].name  + "</b><br />Address: "+ dataPOI[i].address + "</b><br />Rating: " + dataPOI[i].rating + "</b><br />Popularity: " + "No Data for this location!" +  ' </b><br /><a href="insertvisit.php?id=' + id+ '">Insert Visit</a> ' + '</b><br /><a href="estimatepeople.php?id=' + id+'">Estimate number of people</a> ' ).on('click', clickZoom).addTo(map);
    }else if  (dataPOI[i].current_popularity>0 && dataPOI[i].current_popularity <=32){
        var leafletImage = L.icon({
            iconUrl: 'green.png',
            iconSize: [30, 40],
            iconAnchor: [15, 40],
            popupAnchor: [0, -35]
        });
        function clickZoom(e) {
            map.setView(e.target.getLatLng(),17);
        }
        let id = dataPOI[i].id;
        L.marker([dataPOI[i].lat,dataPOI[i].lng],{icon: leafletImage}).bindPopup("<b>"+ dataPOI[i].name  + "</b><br />Address: "+ dataPOI[i].address + "</b><br />Rating: " + dataPOI[i].rating + "</b><br />Popularity: " + dataPOI[i].current_popularity+' </b><br /><a href="insertvisit.php?id=' + id+ '">Insert Visit</a> '+'</b><br /><a href="estimatepeople.php?id=' + id+'">Estimate number of people</a> ' ).on('click', clickZoom).addTo(map);
    }else if (dataPOI[i].current_popularity > 32 && dataPOI[i].current_popularity <= 65) {
        var leafletImage = L.icon({
            iconUrl: 'orange.png',
            iconSize: [30, 40],
            iconAnchor: [15, 40],
            popupAnchor: [0, -35]
        });
        function clickZoom(e) {
            map.setView(e.target.getLatLng(),17);
        }
        let id = dataPOI[i].id;
        L.marker([dataPOI[i].lat,dataPOI[i].lng],{icon: leafletImage}).bindPopup("<b>"+ dataPOI[i].name  + "</b><br />Address: "+ dataPOI[i].address + "</b><br />Rating: " + dataPOI[i].rating + "</b><br />Popularity: " + dataPOI[i].current_popularity+' </b><br /><a href="insertvisit.php?id=' + id+ '">Insert Visit</a> '+'</b><br /><a href="estimatepeople.php?id=' + id+'">Estimate number of people</a> ' ).on('click', clickZoom).addTo(map);
    }else {
        var leafletImage = L.icon({
            iconUrl: 'red.png',
            iconSize: [30, 40],
            iconAnchor: [15, 40],
            popupAnchor: [0, -35]
        });
        function clickZoom(e) {
            map.setView(e.target.getLatLng(),17);
        }
        let id = dataPOI[i].id;
        L.marker([dataPOI[i].lat,dataPOI[i].lng],{icon: leafletImage}).bindPopup("<b>"+ dataPOI[i].name  + "</b><br />Address: "+ dataPOI[i].address + "</b><br />Rating: " + dataPOI[i].rating + "</b><br />Popularity: " + dataPOI[i].current_popularity+' </b><br /><a href="insertvisit.php?id=' + id+ '">Insert Visit</a> ' +'</b><br /><a href="estimatepeople.php?id=' + id+'">Estimate number of people</a> ' ).on('click', clickZoom).addTo(map);
     }
}

function insert_visit(){
    console.log("hello");
    alert("<?php echo 'Press OK to insert a new visit in this POI.' ?>"); 
    window.open("insertvisit.php");
}
</script>

</html>