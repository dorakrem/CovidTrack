<?php
//Connecto to db
require('db_connect.php');

// Starting the session, to use and
// store data in session variable
session_start();

// If the session variable is empty, this
// means the user is yet to login
// User will be sent to 'login.php' page
// to allow the user to login
if (!isset($_SESSION['username'])) {
  $_SESSION['msg'] = "You have to log in first";
  header('location: login.php');
}

// Logout button will destroy the session, and
// will unset the session variables
// User will be headed to 'login.php'
// after logging out
if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="pandemic.ico" type="image/ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CovidTrack | Admin</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>
  <link rel="stylesheet" type="text/css" href="styleAdmin.css">
  <!-- Data Tables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">

<body>
  <header>
    <div class="topnav">
      <a class="active" href="adminpage.php"><i class="fa fa-line-chart"></i> Statistics</a>
      <a href="adminUpload.php"><i class="fa fa-upload"></i> Upload Data</a>
      <a href="adminDelete.php" name="editprofile"><i class="fa fa-trash"></i> Delete Data</a>
      <a href="index.php?logout='1'" style="color: red;"><i class="fa fa-sign-out"></i> Logout </a>
    </div>
  </header>


  <div id="card">
    <div class="row">
      <div class="col-sm-3">
        <div class="card text-light bg-success mb-3" style="width: 15rem; height: 12rem;">
          <div class="card-header">Total Visits</div>
          <div class="card-body">
            <h5 class="card-title  text-center">Visits</h5>
            <?php
            $sql = "SELECT COUNT(*) AS 'total' FROM visit";
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($result);

            echo '<h1 class="card-text text-center">  ' . $data['total'] . '</h1>';

            ?>
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="card text-light bg-danger mb-3" style="width: 15rem; height: 12rem;">
          <div class="card-header">Total Covid Cases</div>
          <div class="card-body">
            <h5 class="card-title text-center">Covid Cases</h5>
            <?php

            $sql = "SELECT DISTINCT COUNT(*) AS 'total' FROM covidcase";
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($result);

            echo '<h1 class="card-text text-center">  ' . $data['total'] . '</h1>';

            ?>
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="card text-light bg-warning mb-3" style="width: 15rem; height: 12rem;">
          <div class="card-header">Active covid cases visits</div>
          <div class="card-body">
            <h5 class="card-title text-center">Visits</h5>
            <?php

            $sql = "SELECT count(visit.poi) as 'visits'
                    from covidcase
                    INNER JOIN visit ON covidcase.username = visit.username
                    WHERE DATEDIFF((covidcase.timeofdiagnosis), (visit.timeofvisit)) > 7 OR DATEDIFF((visit.timeofvisit), (covidcase.timeofdiagnosis))> 14";

            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($result);

            echo '<h1 class="card-text text-center">  ' . $data['visits'] . '</h1>';


            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="tableD">
    <?php
    $username = $_SESSION["username"];

    $sql = "SELECT pointofinterest.types as 'types', COUNT(visit.poi) as 'visits'
            FROM pointofinterest
            INNER JOIN visit ON pointofinterest.id = visit.poi
            GROUP BY pointofinterest.types
            ORDER BY visits DESC;";

    $result = mysqli_query($conn, $sql);
    ?>

    <div class="box">
      <h4>POIs types based on user visits</h4>
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
            <th scope="col">POIs types</th>
            <th scope="col">Visits</th>
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
              <td><?= $rows['types'] ?></td>
              <td><?= $rows['visits'] ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } ?>
  </div>

  <div id="tableE">
    <?php
    $username = $_SESSION["username"];

    $sql = "SELECT pointofinterest.types as 'types', count(visit.poi) as 'visits'
            FROM visit
              INNER JOIN covidcase ON visit.username = covidcase.username
              INNER JOIN pointofinterest ON visit.poi = pointofinterest.id
              WHERE DATEDIFF((covidcase.timeofdiagnosis), (visit.timeofvisit)) > 7 OR DATEDIFF((visit.timeofvisit), (covidcase.timeofdiagnosis)) > 14
              GROUP BY pointofinterest.types
              ORDER BY count(visit.poi) DESC";

    $result = mysqli_query($conn, $sql);
    ?>

    <div class="box">
      <h4>POIs types based on covid cases visits</h4>
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
            <th scope="col">POIs types</th>
            <th scope="col">Visits</th>
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
              <td><?= $rows['types'] ?></td>
              <td><?= $rows['visits'] ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } ?>
  </div>

  <div id="tableF">
    <table id="mytable" class="display responsive nowrap" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>#</th>
          <th>Poi</th>
          <th>Day</th>
          <th>Hourly Visits</th>
          <th>Daily Visits</th>
        </tr>
      </thead>

      <tbody>
        <?php
        require('db_connect.php');
        $sql = "SELECT pointofinterest.name as 'name', poispopulartimes.day as 'day', poispopulartimes.hours as 'hours', poispopulartimes.daily_visits as 'visits'
                FROM pointofinterest
                INNER JOIN poispopulartimes ON pointofinterest.id = poispopulartimes.poi;";

        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
          // output data of each row
          $i = 0;
          while ($row = mysqli_fetch_assoc($result)) {
            $i++;
        ?>
            <tr>
              <td><?= $i; ?></td>
              <td><?= $row['name'] ?></td>
              <td><?= $row['day'] ?></td>
              <td><?= $row['hours'] ?></td>
              <td><?= $row['visits'] ?></td>
            <?php }  ?>
            </tr>
          <?php } ?>

      </tbody>


    </table>

    <button class="btn btn-primary btn-sm"><a href="chart.php" style="text-decoration: none; color: #fff;">
        <i class="fas fa-chart-bar"></i> Gprahical Results</a></button>

    <script src="https://code.jquery.com/jquery-3.4.0.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function() {
        $('#mytable').DataTable();
      });
    </script>

    <script type="text/javascript">
      // Search box
      $('#myTable').DataTable({
        dom: 'Qfrtip'
      });
    </script>
  </div>

</body>

</html>