<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    
    <link rel="icon" href="pandemic.ico" type="image/ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CovidTrack | Admin Upload</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>
    <link rel="stylesheet" type="text/css" href="styleAdmin.css">
</head>

<body>
    <header>
        <div class="topnav">
            <a href="adminpage.php"><i class="fa fa-line-chart"></i> Statistics</a>
            <a class="active" href="adminUpload.php"><i class="fa fa-upload"></i> Upload Data</a>
            <a href="adminDelete.php" name="editprofile"><i class="fa fa-trash"></i> Delete Data</a>
            <a href="index.php?logout='1'" style="color: red;"><i class="fa fa-sign-out"></i> Logout </a>
        </div>

    </header>

    <div id="container">
        <h1>Upload POIs json file</h1>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="jsonFile">
            <input type="submit" name="submit">
        </form>
    </div>

    <?php
    error_reporting(E_ERROR);

    if (isset($_POST['submit'])) {

        $fname = $_FILES['jsonFile']['name'];

        //connect to mysql db
        require('db_connect.php');

        //read the json file contents
        $jsondata = file_get_contents($fname);

        //convert json object to php associative array
        $pois = json_decode($jsondata, true);


        $inserted_rows = 0;
        foreach ($pois as $poi) {

            //get the pois details
            $id = $poi['id'];

            $name = mysqli_real_escape_string($conn, $poi['name']);
            $address = mysqli_real_escape_string($conn, $poi['address']);

            $types_array = $poi['types'];
            $types = implode(",", $types_array);

            $coordinates_lat = $poi['coordinates']['lat'];
            $coordinates_lng = $poi['coordinates']['lng'];

            $rating = $poi['rating'];
            $rating_n = $poi['rating_n'];
            $current_popularity = $poi['current_popularity'];

            if (!empty($poi['time_spent'])) {
                $time_spent = implode(",", $poi['time_spent']);
            } else $time_spent = "NULL";


            //insert into pointofinterest table
            $sql_pois = "INSERT INTO pointofinterest(id, name, address, types, coordinates_lat, coordinates_lng, rating, rating_n, current_popularity, time_spent, last_modified)
            VALUES('$id', '$name', '$address', '$types', '$coordinates_lat', '$coordinates_lng', '$rating', '$rating_n', '$current_popularity', '$time_spent', NOW())
            ON DUPLICATE KEY UPDATE
            id = '$id',
            name = '$name',
            address = '$address',
            types = '$types',
            coordinates_lat = '$coordinates_lat',
            coordinates_lng = '$coordinates_lng',
            rating = '$rating',
            rating_n = '$rating_n',
            current_popularity = '$current_popularity',
            time_spent = '$time_spent',
            last_modified = NOW()
            ";

            if (mysqli_query($conn, $sql_pois)) {
            } else "Error: " . $sql_pois . "<br>" . mysqli_error($conn);


            //insert into poispopulartimes table
            foreach ($poi['populartimes'] as $row) {

                $day = mysqli_real_escape_string($conn, $row['name']);

                $hours = implode(",", $row['data']);

                $daily_visits = array_sum($row['data']);

                // insert to poispopulartimes
                $sql_poispopulartimes = "INSERT INTO poispopulartimes(poi, day, hours, daily_visits)
                                        VALUES('$id', '$day', '$hours', '$daily_visits')
                                        ON DUPLICATE KEY UPDATE
                                        poi = '$id',
                                        day = '$day',
                                        hours = '$hours',
                                        daily_visits = '$daily_visits'
                                        ";


                if (mysqli_query($conn, $sql_poispopulartimes)) {
                } else "Error: " . $sql_poispopulartimes . "<br>" . mysqli_error($conn);

                
                for($i=0; $i<24; $i++){
                    $hour = $i+1;
                    $hourly_visits = $row['data'][$i];

                    // insert to hourlypopulartimes
                    $sql_hourlypopulartimes = "INSERT INTO hourlypopulartimes(poi, day, hour, hourly_visits)
                                        VALUES('$id', '$day', '$hour', '$hourly_visits')
                                        ON DUPLICATE KEY UPDATE
                                        poi = '$id',
                                        day = '$day',
                                        hour = '$hour',
                                        hourly_visits = '$hourly_visits'
                                        ";

                    if (mysqli_query($conn, $sql_hourlypopulartimes)) {
                    } else "Error: " . $sql_hourlypopulartimes . "<br>" . mysqli_error($conn);
                }
            }

            $inserted_rows++;
        }

        if (count($pois) == $inserted_rows) {
            echo "All records inserted successfully!";
        } else echo "Error";

        mysqli_close($conn);
    }
    ?>
</body>

</html>