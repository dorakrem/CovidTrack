<?php
session_start();
error_reporting(E_ALL ^ E_WARNING);;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="pandemic.ico" type="image/ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CovidTrack | Admin Delete</title>


    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>
    <link rel="stylesheet" type="text/css" href="styleDelete.css">
</head>

<body>

    <header>
        <div class="topnav">
            <a href="adminpage.php"><i class="fa fa-line-chart"></i> Statistics</a>
            <a href="adminUpload.php"><i class="fa fa-upload"></i> Upload Data</a>
            <a class="active" href="adminDelete.php" name="editprofile"><i class="fa fa-trash"></i> Delete Data</a>
            <a href="index.php?logout='1'" style="color: red;"><i class="fa fa-sign-out"></i> Logout </a>
        </div>

    </header>

    <div class="container">
        <!-- Database Connection and Query -->
        <?php
        // Connecto to DB
        require('db_connect.php');

        $username = $_SESSION["username"];

        $sql = "SELECT * FROM pointofinterest GROUP BY name ASC";
        $result = mysqli_query($conn, $sql);

        ?>

        <div class="box">
            <div class="col-md-10 text-center">
                <h4>Available POIs</h4>
                <a href="deleteAllPois.php" class="btn btn-danger text">Delete All</a>
            </div>
            <br>
            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-warning text-center" role="alert">
                    <?php echo $_GET['success']; ?>
                </div>
            <?php } ?>
            <?php if (mysqli_num_rows($result)) {
            ?>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Latitude</th>
                            <th scope="col">Longtitude</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Popularity</th>
                            <th scope="col">Last Modified</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        while ($rows = mysqli_fetch_assoc($result)) {
                            $i++;
                        ?>
                            <tr>
                                <th scope="row"><?= $i ?></th>
                                <td><?= $rows['id'] ?></td>
                                <td><?= $rows['name'] ?></td>
                                <td><?= $rows['address'] ?></td>
                                <td><?= $rows['coordinates_lat'] ?></td>
                                <td><?= $rows['coordinates_lng'] ?></td>
                                <td><?= $rows['rating'] ?></td>
                                <td><?= $rows['current_popularity'] ?></td>
                                <td><?= $rows['last_modified'] ?></td>
                                <td><a href="deletePoi.php?id=<?= $rows['id'] ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
</body>

</html>